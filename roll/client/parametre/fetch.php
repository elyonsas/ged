<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');
use Ramsey\Uuid\Uuid;

connected('client');

$output = '';

if (isset($_POST['datatable'])) {

}

if (isset($_POST['action'])) {

    // espace param
    if ($_POST['action'] == 'fetch_page_parametre') {
        $id_utilisateur = $_SESSION['id_utilisateur'];

        $query = "SELECT * FROM utilisateur, compte WHERE utilisateur.id_utilisateur = compte.id_utilisateur AND utilisateur.id_utilisateur = '$id_utilisateur'";
        $statement = $db->prepare($query);
        $statement->execute();

        $result = $statement->fetch();

        $output = $result;
    }

    if ($_POST['action'] == 'edit_profile') {

        $id_utilisateur = $_SESSION['id_utilisateur'];

        $uuid = Uuid::uuid1();
        $uniq = $uuid->toString();
        $avatar_utilisateur = $uniq . '_' . $_FILES['avatar_utilisateur']['name'];

        $nom_utilisateur = $_POST['nom_utilisateur'];
        $tel_utilisateur = $_POST['tel_utilisateur'];
        $email_utilisateur = $_POST['email_utilisateur'];
        $adresse_utilisateur = $_POST['adresse_utilisateur'];

        $email_compte = $_POST['email_compte'];

        // upload avatar
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/media/avatars/' . $avatar_utilisateur;
        $upload = move_uploaded_file($_FILES['avatar_utilisateur']['tmp_name'], $upload_path);

        if ($_FILES['avatar_utilisateur']['name'] != '') {
            $update1 = update(
                'utilisateur',
                [
                    'avatar_utilisateur' => $avatar_utilisateur,
                    'nom_utilisateur' => $nom_utilisateur,
                    'tel_utilisateur' => $tel_utilisateur,
                    'email_utilisateur' => $email_utilisateur,
                    'adresse_utilisateur' => $adresse_utilisateur,
                ],
                "id_utilisateur = '$id_utilisateur'",
                $db
            );
        } else{
            $update1 = update(
                'utilisateur',
                [
                    'nom_utilisateur' => $nom_utilisateur,
                    'tel_utilisateur' => $tel_utilisateur,
                    'email_utilisateur' => $email_utilisateur,
                    'adresse_utilisateur' => $adresse_utilisateur,
                ],
                "id_utilisateur = '$id_utilisateur'",
                $db
            );
        }

        $update2 = update(
            'compte',
            [
                'email_compte' => $email_compte,
            ],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        if ($update1 && $update2) {
            $output = [
                'success' => true,
                'message' => 'Profil mis à jour !',
            ];
        } else {
            $output = [
                'success' => false,
                'message' => "Une erreur s'est produite !",
            ];
        }
    }
}



echo json_encode($output);
