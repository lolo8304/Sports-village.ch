<?php

// This page is linked to {subscription_confirm_url} tag.

require_once '../../../wp-load.php';

if (!check_admin_referer('export')) {
    wp_die('Invalid nonce key');
}

$email_id = $_GET['email_id'];

header('Content-Type: text/plain;charset=UTF-8');

echo '"Email";"Name";"Surname";"Sex";"URL"';
echo "\n";

$page = 0;
while (true) {
    $users = $wpdb->get_results($wpdb->prepare("select distinct u.id, email, name, surname, sex, s.url from " . NEWSLETTER_USERS_TABLE . " u
        join " . NEWSLETTER_STATS_TABLE . " s on u.id=s.user_id and email_id=%d
        order by u.id limit " . $page * 500 . ",500", $email_id));

    for ($i = 0; $i < count($users); $i++) {
        echo '"' . $users[$i]->email;
        echo '";"';
        echo newsletter_sanitize_csv($users[$i]->name);
        echo '";"';
        echo newsletter_sanitize_csv($users[$i]->surname);
        echo '";"';
        echo $users[$i]->sex;
        echo '";"';
        echo newsletter_sanitize_csv($users[$i]->url);
        echo '"';
        echo "\n";
        flush();
    }
    if (count($users) < 500) {
        break;
    }
    $page++;
}

function newsletter_sanitize_csv($text) {
    $text = str_replace('"', "'", $text);
    $text = str_replace("\n", ' ', $text);
    $text = str_replace("\r", ' ', $text);
    $text = str_replace(";", ' ', $text);
    return $text;
}
