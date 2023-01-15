<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('dd');

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
    if ($_POST['action'] == 'edit_relance_temp_1') {
        
        $update = update(
            'modele_mail_client',
            [
                'mail_objet' => $_POST['mail_objet'],
                'mail_content' => $_POST['mail_content'],
            ],
            "relance_option_facture = 'after_5_days'",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => "Modèle sauvegarder !"
            );
        }
    }
    if ($_POST['action'] == 'edit_relance_temp_2') {
        $update = update(
            'modele_mail_client',
            [
                'mail_objet' => $_POST['mail_objet'],
                'mail_content' => $_POST['mail_content'],
            ],
            "relance_option_facture = 'after_30_days'",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => "Modèle sauvegarder !"
            );
        }
    }
}

if (isset($_FILES['file'])) {

    

    $output = $targetFile;
    echo $output;
    die;
}

echo json_encode($output);
