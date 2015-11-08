<?php
require_once dirname(__FILE__) . '/controls.php';
require_once dirname(__FILE__) . '/helper.php';

$email_id = (int) $_REQUEST['id'];
$module = NewsletterStatistics::instance();
$helper = new NewsletterStatisticsHelper();
$controls = new NewsletterControls();
$email = $module->get_email($email_id);

if ($controls->is_action('set')) {
    $r = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set list_" . $controls->data['preference'] . "=1 where id in (select distinct user_id from " . NEWSLETTER_STATS_TABLE . " where email_id=" . $email_id . ")");
    $controls->messages = 'Done. Added ' . $r . ' subscribers.';
}

$read = $helper->get_read_count($email_id);
$clicked = $helper->get_clicked_count($email_id);
$only_read = $read - $clicked;
$total = $helper->get_click_count($email_id);
$urls = $helper->get_clicked_urls($email_id);
$events = $helper->aggregate_events_by_day($helper->get_first_events($email_id));
$events_max = max($events);

function percent($value, $total) {
    if ($total == 0)
        return '-';
    return sprintf("%.2f", $value / $total * 100) . '%';
}

function percentValue($value, $total) {
    if ($total == 0)
        return 0;
    return round($value / $total * 100);
}
?>

<div class="wrap">

    <h2>Statistics for the email "<?php echo htmlspecialchars($email->subject); ?>"</h2>

    <?php $controls->show(); ?>

    <div id="tabs">

        <ul>
            <li><a href="#tab-overview">Overview</a></li>
            <li><a href="#tab-events">Events</a></li>
            <li><a href="#tab-gender">Gender</a></li>
            <li><a href="#tab-countries">Countries</a></li>
            <li><a href="#tab-urls">URLs</a></li>
            <li><a href="#tab-actions">Actions</a></li>
        </ul>

        <div id="tab-overview">

            <div class="row">
                <div class="col-md-6">
                    <div class="page-header">
                        <?php if ($email->status == 'sending' || $email->status == 'paused'): ?>
                        <h1><?php echo $email->sent; ?> <small>Emails Sent of</small> <?php echo $email->total; ?> <small>Total Emails <span class="glyphicon glyphicon-send"></span></small></h1>
                        <?php else: ?>
                        <h1><?php echo $email->total; ?> <small>Emails Sent <span class="glyphicon glyphicon-send"></span></small></h1>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="page-header">
                        <h1><?php echo $total; ?> <small>Total Clicks <span class="glyphicon glyphicon-share"></span></small></h1>
                    </div>
                </div>
            </div>

            <div class="text-muted">Subscribers who read the email</div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo percentValue($read, $email->total) ?>" 
                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentValue($read, $email->total) ?>%; min-width: 2em;">
                    <?php echo $read; ?> (<?php echo percent($read, $email->total); ?>)
                </div>
            </div>

            <div class="text-muted">Subscribers who only read the email</div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo percentValue($only_read, $email->total) ?>" 
                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentValue($only_read, $email->total) ?>%; min-width: 2em;">
                    <?php echo $only_read; ?> (<?php echo percent($only_read, $email->total); ?>)
                </div>
            </div>

            <div class="text-muted">Subscribers who clicked the email</div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo percentValue($clicked, $email->total) ?>" 
                     aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentValue($clicked, $email->total) ?>%; min-width: 2em;">
                    <?php echo $clicked; ?> (<?php echo percent($clicked, $email->total); ?>)
                </div>
            </div>

            <div class="text-muted">Clicked or only opened?</div>
            <div class="progress">
                <div class="progress-bar progress-bar-success" style="width: <?php echo $firstBarPercent = percentValue($clicked, $clicked + $only_read) ?>%">
                    Clicked (<?php echo percent($clicked, $clicked + $only_read); ?>)
                </div>
                <div class="progress-bar progress-bar-warning" style="width: <?php echo (100 - $firstBarPercent) ?>%">
                    Only read (<?php echo percent($only_read, $clicked + $only_read); ?>)
                </div>
            </div>

        </div>

        <div id="tab-events">

            <p>Users' interactions (open or click) distribution over time, starting from the sending day.</p>

            <?php if (empty($events)) {
                ?>
                <p>No data</p>
                <?php
            } else {
                ?>
                <div id="firstevents-chart"></div>
            <?php } ?>

        </div>

        <div id="tab-gender">
            <div id="sex-chart"></div>
        </div>

        <div id="tab-countries">

            <?php
            $countries = $wpdb->get_results("select country, count(*) as total from {$wpdb->prefix}newsletter_stats where email_id=$email_id and country<>'' group by country order by total");
            ?>

            <?php if (empty($countries)) { ?> 
                <p>No data available, just wait some time to let the processor to work to resolve the countries. Thank you.</p>
            <?php } else { ?>
                <p><div id="country-chart"></div></p>
            <?php } ?>

            <p>The right number in the density bar below the chart indicates the maximum value that can be found on a country in the map.</p>

        </div>

        <div id="tab-urls">

            <?php if (empty($urls)) { ?>
                <p>No clicks by now.</p>
            
            <?php } else { ?>
            
                <table class="widefat" style="width: auto">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Clicks</th>
                            <th>%</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($urls); $i++) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($urls[$i]->url) ?></td>
                                <td><?php echo $urls[$i]->number ?></td>
                              
                                <td style="width: 250px">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo percentValue($urls[$i]->number, $total); ?>" 
                                             aria-valuemin="0" aria-valuemax="100" style="width: <?php echo percentValue($urls[$i]->number, $total); ?>%">
                                                 <?php echo percent($urls[$i]->number, $total); ?>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <?php
                                    $users = $helper->get_users_by_url($email_id, $urls[$i]->url);
                                    $values = $helper->split_by_sex($users);
                                    ?>
                                    <?php echo $values['m']; ?>&nbsp;Males<br>
                                    <?php echo $values['f']; ?>&nbsp;Females<br>
                                    <?php echo $values['n']; ?>&nbsp;Unknown<br>
                                </td>
                            <tr>

                            <?php } ?>
                    </tbody>
                </table>

            <?php } ?>
        </div>

        <div id="tab-actions">
            <form action="" method="post">
                <?php $controls->init(); ?>

                <?php
                //if (is_dir(WP_PLUGIN_DIR . '/newsletter-reports')) {
                    $export_url = plugins_url('newsletter-reports') . '/export.php';
                //} else {
                //    $export_url = WP_CONTENT_URL . '/extensions/newsletter/reports/export.php';
                //}
                ?>

                <p>Export a list of subscribers who opened the email 
                    <a target="_blank" href="<?php echo wp_nonce_url($export_url . '?email_id=' . $email_id, 'export') ?>" class="button">Export</a>
                </p>

                <p>To all who opened the email set the preference 
                    <?php $controls->preferences_select(); ?>
                    <?php $controls->button_confirm('set', 'Go', 'Proceed?'); ?>
                </p>

            </form>
        </div>

    </div>

</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    google.load('visualization', '1.0', {'packages': ['corechart', 'geochart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

<?php if (!empty($urls)) { ?>
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'URL');
            data.addColumn('number', 'Count');
    <?php for ($i = 0; $i < min(count($urls), 10); $i++) { ?>
                data.addRow(['URL <?php echo $i + 1; ?>', <?php echo $urls[$i]->number ?>]);
    <?php } ?>

            // Set chart options
            var options = {'title': 'URLs',
                'width': 400,
                'height': 400};

            //var chart = new google.visualization.PieChart(document.getElementById('urls-chart'));
            //chart.draw(data, options);
<?php } ?>

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Sex');
        data.addColumn('number', 'Count');
<?php $sex = $helper->get_sex($email_id); ?>
        data.addRow(['Male', <?php echo $sex['m']; ?>]);
        data.addRow(['Female', <?php echo $sex['f']; ?>]);
        data.addRow(['Unknown', <?php echo $sex['n']; ?>]);

        // Set chart options
        var options = {'title': 'Sex',
            'width': 400,
            'height': 400
        
            };

        var chart = new google.visualization.PieChart(document.getElementById('sex-chart'));
        chart.draw(data, options);

<?php if (!empty($events)) { ?>
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Events');
    <?php for ($i = 0; $i < count($events); $i++) { ?>
                data.addRow(['<?php echo $i; ?>', <?php echo $events[$i] ?>]);
    <?php } ?>

            var options = {'title': 'First events', 'width': 900, 'height': 500};

            var chart = new google.visualization.ColumnChart(document.getElementById('firstevents-chart'));
            chart.draw(data, options);
<?php } ?>

<?php if (!empty($countries)) { ?>
            var countries = new google.visualization.DataTable();
            countries.addColumn('string', 'Country');
            countries.addColumn('number', 'Total');
    <?php foreach ($countries as &$country) { ?>
                countries.addRow(['<?php echo $country->country; ?>', <?php echo $country->total; ?>]);
    <?php } ?>

            var options = {'title': 'Country', 'width': 700, 'height': 500};
            var chart = new google.visualization.GeoChart(document.getElementById('country-chart'));
            chart.draw(countries, options);
<?php } ?>
    }
</script>

