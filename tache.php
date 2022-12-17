<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

$update = update(
    'facture',
    [
        'statut_facture' => 'relance',
        'updated_at_facture' => date('Y-m-d H:i:s'),
        'updated_by_facture' => $_SESSION['id_utilisateur']
    ],
    "date_echeance_facture LIKE '%2022-12-17%'",
    $db
);