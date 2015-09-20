<?php

/*
  Plugin Name: CF7 Extension for Newsletter
  Plugin URI: http://www.thenewsletterplugin.com/plugins/newsletter/archive-module
  Description: 
  Version: 1.0.0
  Author: Stefano Lissa
  Author URI: http://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */
    
if (!defined('NEWSLETTER_EXTENSION')) {
    define('NEWSLETTER_EXTENSION', true);
}

class NewsletterCF7 {

    /**
     * @var NewsletterCF7
     */
    static $instance;
    var $prefix = 'newsletter_cf7';
    var $slug = 'newsletter-cf7';
    var $plugin = 'newsletter-cf7/cf7.php';
    var $id = 61;
    var $options;

    function __construct() {
        self::$instance = $this;
        register_activation_hook(__FILE__, array($this, 'hook_activation'));
        register_deactivation_hook(__FILE__, array($this, 'hook_deactivation'));
        $this->options = get_option($this->prefix, array());
        add_action('init', array($this, 'hook_init'));
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
            //add_action('admin_init', array($this, 'hook_admin_init'));

            add_action('admin_menu', array($this, 'hook_admin_menu'), 100);
            if (isset($_GET['page']) && strpos($_GET['page'], $this->slug . '/') === 0) {
                wp_enqueue_script('jquery-ui-tabs');
                wp_enqueue_style($this->prefix . '_css', plugin_dir_url(__FILE__) . '/admin.css');
            }
        } else {
            add_action('wpcf7_mail_sent', array($this, 'hook_wpcf7_mail_sent'));
        }
    }
    
    /**
     * 
     * @param WPCF7_ContactForm $form
     */
    function hook_wpcf7_mail_sent($form) {

        $form_options = get_option('newsletter_cf7_' . $form->id(), null);
        if (empty($form_options)) return;
        
        if (isset($_REQUEST[$form_options['newsletter']])) {
            $email = $_REQUEST[$form_options['email']];
            if (!NewsletterModule::is_email($email)) return;
            $_REQUEST['ne'] = $email;
            $_REQUEST['nr'] = 'cf7-' . $form->id;
            NewsletterSubscription::instance()->subscribe();
        } else {
            
        }
    }


    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'CF7 Integration', 'CF7 Integration', 'manage_options', 'newsletter-cf7/index.php');
    }

    function hook_site_transient_update_plugins($value) {
        if (!method_exists('Newsletter', 'set_extension_update_data')) {
            return $value;
        }

        return Newsletter::instance()->set_extension_update_data($value, $this);
    }

    function save_options($options) {
        $this->options = $options;
        update_option($this->prefix, $options);
    }

}

new NewsletterCF7();
