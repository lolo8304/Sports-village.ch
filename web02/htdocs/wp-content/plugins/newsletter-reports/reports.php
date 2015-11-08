<?php

/*
  Plugin Name: Newsletter Reports Extension
  Plugin URI: http://www.thenewsletterplugin.com/
  Description: Extends the statistic viewer adding graphs, link clicks, export and many other data. Automatic updates available setting the license key on Newsletter configuration panel.
  Version: 2.2.4
  Author: Stefano Lissa
  Author URI: http://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

if (!defined('NEWSLETTER_EXTENSION')) {
    define('NEWSLETTER_EXTENSION', true);
}

class NewsletterReports {

    var $prefix = 'newsletter_reports';
    var $slug = 'newsletter-reports';
    var $plugin = 'newsletter-reports/reports.php';
    var $id = 50;
    var $options;

    /**
     * @return NewsletterReports
     */
    static $instance;

    function __construct() {
        self::$instance = $this;
        register_activation_hook(__FILE__, array($this, 'hook_activation'));
        register_deactivation_hook(__FILE__, array($this, 'hook_deactivation'));
        add_action('init', array($this, 'hook_init'));
        $this->options = get_option($this->prefix, array());
    }

    function hook_activation() {
        delete_transient($this->prefix . '_plugin');
    }

    function hook_deactivation() {
        delete_transient($this->prefix . '_plugin');
    }

    function hook_init() {

        if (!class_exists('Newsletter')) {
            return;
        }

        add_filter('site_transient_update_plugins', array($this, 'hook_site_transient_update_plugins'));

        if (is_admin()) {
            add_action('admin_init', array($this, 'hook_admin_init'));

            add_action('admin_menu', array($this, 'hook_admin_menu'), 100);
            add_filter('newsletter_statistics_view', array($this, 'hook_newsletter_statistics_view'));
            if (isset($_GET['page']) && strpos($_GET['page'], $this->slug . '/') === 0) {
                wp_enqueue_script('jquery-ui-tabs');
                wp_enqueue_style($this->prefix . '_css', plugin_dir_url(__FILE__) . '/admin.css');
                wp_enqueue_style($this->prefix . '_css2', plugin_dir_url(__FILE__) . '/css/bootstrap.css');
            }

            add_action('newsletter_user_newsletters_tab', array($this, 'hook_newsletter_user_newsletters_tab'));
        }

        if (!defined('DOING_CRON') || !DOING_CRON) {
            if (wp_get_schedule('newsletter_reports_country') === false) {
                wp_schedule_event(time() + 60, 'newsletter', 'newsletter_reports_country');
            }
        }
        add_action('newsletter_reports_country', array($this, 'country'));
    }

    function hook_admin_init() {
        
    }

    /**
     * 
     * @global wpdb $wpdb
     */
    function hook_newsletter_user_newsletters_tab($user_id) {
        global $wpdb;
        $emails = $wpdb->get_results($wpdb->prepare("select id, subject, s.status, s.error from " . NEWSLETTER_EMAILS_TABLE . " e join " . $wpdb->prefix . "newsletter_sent s on s.email_id=e.id and s.user_id=%d", $user_id));
        echo '<table class="widefat">';
        echo '<thead><tr><th>ID</th><th>Subject</th><th>Sent</th><th>Read</th><th>Clicked</th><th>Error</th></tr></thead>';
        foreach ($emails as $email) {
            echo '<tr>';
            echo '<td>';
            echo $email->id;
            echo '</td>';
            
            echo '<td>';
            echo esc_html($email->subject);
            echo '</td>';
            
            echo '<td>';
            echo $email->status ? '<span style="font-size: 1.5em; font-weight: bold; color: #009900">&#10003;</span>' : '<span style="font-size: 1.5em; font-weight: bold; color: #990000">&#10007;</span>';
            echo '</td>';

            $read = $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_STATS_TABLE . " where user_id=%d and email_id=%d", $user_id, $email->id));

            echo '<td>';
            echo $read ? '<span style="font-size: 1.5em; font-weight: bold; color: #009900">&#10003;</span>' : '';
            echo '</td>';
            
            $clicked = $wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_STATS_TABLE . " where user_id=%d and email_id=%d and url<>''", $user_id, $email->id));
           
            echo '<td>';
            echo $clicked ? '<span style="font-size: 1.5em; font-weight: bold; color: #009900">&#10003;</span>' : '';
            echo '</td>';

            echo '<td>';
            echo esc_html($email->error);
            echo '</td>';
            
            echo '<tr>';
        }
        echo '</table>';
    }

    function hook_site_transient_update_plugins($value) {
        if (!method_exists('Newsletter', 'set_extension_update_data')) {
            return $value;
        }

        return Newsletter::instance()->set_extension_update_data($value, $this);
    }

    var $country_result = '';

    function country() {
        global $wpdb;
        $list = $wpdb->get_results("select id, ip from " . NEWSLETTER_STATS_TABLE . " where ip<>'' and country='' limit 50");
        $this->save_last_run(time());

        if (!empty($list)) {
            $this->country_result .= 'Processed ' . count($list) . ' statistic entries.';

            foreach ($list as &$r) {

                $body = wp_remote_retrieve_body(wp_remote_get('http://freegeoip.net/json/' . $r->ip));
                if (!empty($body)) {
                    $x = json_decode($body);
                    if (isset($x->country_code)) {

                        $wpdb->query($wpdb->prepare("update " . NEWSLETTER_STATS_TABLE . " set country=%s where id=%d limit 1", $x->country_code, $r->id));
                    } else {
                        $wpdb->query($wpdb->prepare("update " . NEWSLETTER_STATS_TABLE . " set country='XX' where id=%d limit 1", $r->id));
                    }
                }
            }
        }

        $list = $wpdb->get_results("select id, ip from " . NEWSLETTER_USERS_TABLE . " where ip<>'' and country='' limit 50");
        if (!empty($list)) {
            $this->country_result .= ' Processed ' . count($list) . ' subscribers.';
            foreach ($list as &$r) {

                $body = wp_remote_retrieve_body(wp_remote_get('http://freegeoip.net/json/' . $r->ip));
                if (!empty($body)) {
                    $x = json_decode($body);

                    if (isset($x->country_code)) {
                        $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set country=%s where id=%d limit 1", $x->country_code, $r->id));
                    } else {
                        $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set country='XX' where id=%d limit 1", $r->id));
                    }
                }
            }
        }
    }

    function hook_admin_menu() {
        $newsletter = Newsletter::instance();
        $capability = ($newsletter->options['editor'] == 1) ? 'manage_categories' : 'manage_options';
        add_submenu_page('newsletter_main_index', 'Reports', 'Reports', $capability, 'newsletter-reports/index.php');
        add_submenu_page(null, 'Report', 'Report', $capability, 'newsletter-reports/view.php');
    }

    function hook_newsletter_statistics_view($page) {
        return 'newsletter-reports/view.php';
    }

    function save_last_run($time) {
        update_option($this->prefix . '_last_run', $time);
    }

    function get_last_run() {
        return get_option($this->prefix . '_last_run', 0);
    }

}

new NewsletterReports();
