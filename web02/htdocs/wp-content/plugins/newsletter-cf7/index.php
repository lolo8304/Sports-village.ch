<?php

if (isset($_GET['id'])) {
    include dirname(__FILE__) . '/edit.php';
    return;
}

require_once dirname(__FILE__) . '/controls.php';
$module = NewsletterCF7::$instance;
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->data = $module->options;
} else {
    if ($controls->is_action('save')) {
        $module->save_options($controls->data);
        $controls->messages = 'Saved.';
    }
}

$forms = get_posts(array('post_type'=>'wpcf7_contact_form', 'number'=>100));
?>

<div class="wrap">

    <h2>Newsletter CF7 Extension</h2>

    <?php $controls->show(); ?>

        <p>
            See the <a href="http://www.thenewsletterplugin.com/plugins/newsletter/contact-form-7-extension" target="_blank">official documentation</a>
            to correctly configure your Contact Form 7 forms.
        </p>
        <p>
            Below the lits of your Contact Form 7 forms you can bind to Newsletter.
        </p>


    <form action="" method="post">
        <?php $controls->init(); ?>
        
        <table class="widefat" style="width: auto">
            <thead>
                <tr>
                    <th>Id</th>
                    <th><?php _e('Title', 'newsletter-cf7')?></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($forms as $form) { ?>
                <tr>
                    <td>
                        <?php echo esc_html($form->ID) ?>
                    </td>
                    <td>
                        <?php echo esc_html($form->post_title) ?>
                    </td>
                    <td>
                        <a href="?page=newsletter-cf7/index.php&id=<?php echo $form->ID?>">Configure</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
       
    </form>

</div>