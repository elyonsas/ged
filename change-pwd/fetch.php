<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected();

$output = '';

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'change-pwd') {

        $update = update(
            'compte',
            [
                'mdp_compte' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ],
            "id_utilisateur = {$_SESSION['id_utilisateur']}",
            $db
        );

        if ($update) {
            $output = [
                'success' => true,
                'message' => 'Vous avez réinitialisé votre mot de passe avec succès !'
            ];
        } else {
            $output = [
                'success' => false,
                'message' => "Une erreur s'est produite !"
            ];
        }
    }
}



echo json_encode($output);
