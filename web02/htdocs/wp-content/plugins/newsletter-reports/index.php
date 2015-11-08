<?php
/* @var wpdb $wpdb */
require_once dirname(__FILE__) . '/controls.php';
$module = NewsletterReports::$instance;
$controls = new NewsletterControls();

if ($controls->is_action('country')) {
    $module->country();
    $controls->messages = $module->country_result;
}

if ($controls->is_action('import')) {
    $wpdb->query("insert ignore into " . $wpdb->prefix . "newsletter_sent (user_id, email_id, time) select user_id, email_id, UNIX_TIMESTAMP(created) from " . NEWSLETTER_STATS_TABLE);
    $controls->messages = 'Done!';
}
?>

<div class="wrap">

    <h2>Newsletter Reports Extension</h2>

    <?php $controls->show(); ?>

    <p>You can read the <a href="http://www.thenewsletterplugin.com/plugins/newsletter/reports-module" target="_blank">plugin documentation</a> to get more information.<p>

    <p>
        This plugin <strong>has not</strong> a set of options. This page is here to confirm the correct installation. 
        When you open the statistics of a sent email or the subscriber list, this module will replace the standard page with an
        extended view.
    </p>

    <h3>Configuration</h3>

    <form method="post" action="">
        <?php $controls->init(); ?>
        <table class="form-table">
            <tr>
                <th>Country detection last run</th>
                <td>
                    <?php echo $controls->print_date($module->get_last_run()); ?>
                    <?php $controls->button('country', 'Run the country detection'); ?>
                    <p class="description">
                        The country detection finds the countries from which the users subscribed (visible on user statistic panel) and
                        the countries from ehich the single newsletters have been read.
                    </p>
                </td>
            </tr>
            <tr>
                <th>Country detection next run</th>
                <td>
                    <?php echo $controls->print_date(wp_next_scheduled('newsletter_reports_country')); ?>
                </td>
            </tr>
            <tr>
                <th>Country detection data</th>
                <td>
                    Subscribers to be processed: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where ip<>'' and country=''"); ?>
                    <br>
                    Subscribers resolved: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where ip<>'' and country<>'' and country<>'XX'"); ?>
                    <br>
                    Subscribers not resolvable: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where ip<>'' and country='XX'"); ?>
                
                    <br><br>
                    
                    Statistic entries to be processed: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_STATS_TABLE . " where ip<>'' and country=''"); ?>
                    <br>
                    Statistic entries resolved: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_STATS_TABLE . " where ip<>'' and country<>'' and country<>'XX'"); ?>
                    <br>
                    Statistic entries not resolvable: <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_STATS_TABLE . " where ip<>'' and country='XX'"); ?>
                    <br>
                    <p class="description">
                        Totals refer only to subscribers or statistic entries which have an IP address. Some may have not.
                    </p>
                </td>
            </tr>            
            <tr valign="top">
                <th>License key</th>
                <td>
                    <?php
                    if (empty(Newsletter::instance()->options['contract_key'])) {
                        echo 'Not set';
                    } else {
                        echo Newsletter::instance()->options['contract_key'];
                    }
                    ?>
                    <p class="description">
                        The license key can be set on main Newsletter configuration and will be used for the one clic
                        update feature.
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th>Newsetter sent logs</th>
                <td>
                    <?php $controls->button_confirm('import', 'Run', 'It can take long time') ?>
                    <p class="description">Tries to populate the new newsletter sent logs with old collected data.</p>
                </td>
            </tr>            
        </table>

    </form>
</div>
