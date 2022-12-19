<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

// send mail

$to = [
    'to' => [
        ['arnaudadjovi274@gmail.com', 'Arnaud'],
    ],
    'cc' => [
        ['arnaud2adjovi276@gmail.com'],
    ],
    'bcc' => [
        ['arnaud3adjovi278@gmail.com'],
    ],
    'reply_to' => [
        ['c_elyon@yahoo.fr'],
    ],
];

$from = 'c_elyon@yahoo.fr';

$subject = 'test';

$message = 'test';

$attachment = [
    [$_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/avatars/300-1.jpg', 'Avatar'],
];

send_mail($to, $from, $subject, $message, $attachment);