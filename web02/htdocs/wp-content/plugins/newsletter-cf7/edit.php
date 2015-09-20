<?php
require_once dirname(__FILE__) . '/controls.php';
$module = NewsletterCF7::$instance;
$controls = new NewsletterControls();

$form_id = (int) $_GET['id'];

if (!$controls->is_action()) {
    $controls->data = get_option('newsletter_cf7_' . $form_id, array());
} else {
    if ($controls->is_action('save')) {
        add_option('newsletter_cf7_' . $form_id, array(), '', 'no');
        update_option('newsletter_cf7_' . $form_id, $controls->data);
        $controls->messages = 'Saved.';
    }
}

$form = WPCF7_ContactForm::get_instance($form_id);
$form_fields = $form->form_scan_shortcode();
$fields = array();
foreach ($form_fields as $form_field) {
    $field_name = str_replace('[]', '', $form_field['name']);
    $fields[$field_name] = $field_name;
}
?>

<div class="wrap">

    <h2>Form "<?php echo esc_html($form->title) ?>" linking</h2>

    <p>
        See the <a href="http://www.thenewsletterplugin.com/plugins/newsletter/contact-form-7-extension" target="_blank">official documentation</a>
        to correctly configure your Contact Form 7 forms.
    </p>

    <?php $controls->show(); ?>

    <form action="" method="post">
        <p>    
            <?php $controls->button('save', 'Save'); ?> <a href="?page=newsletter-cf7/index.php" class="button-secondary">Back</a>
        </p>
        <?php $controls->init(); ?>

        <table class="form-table">
            <tr valign="top">
                <th>Email field</th>
                <td>
                    <?php $controls->select('email', $fields, 'Select...'); ?>
                </td>
            </tr>           
            <tr valign="top">
                <th>Subscription checkbox field</th>
                <td>
                    <?php $controls->select('newsletter', $fields, 'Select...'); ?>
                    <p class="description">
                        Add a checkbox type field in the form to be used as subscription indicator for
                        example <code>[checkbox newsletter "Subscribe to my newsletter"]</code>.
                    </p>
                </td>
            </tr>                    
        </table>

    </form>

</div>