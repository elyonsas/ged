<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

}

if (isset($_POST['action'])) {

    // espace param relance
    if ($_POST['action'] == 'fetch_page_param_relance') {

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM modele_mail_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = $result;
    }
    
}

if (isset($_FILES['file'])) {

    

    $output = $targetFile;
    echo $output;
    die;
}

echo json_encode($output);
