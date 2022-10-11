<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

$message = '';

// Vérifie un credential est envoyé
if (isset($_POST['credential'])) {

    // Récupère le credential
    $credential = $_POST['credential'];

    $client = new Google_Client(['client_id' => GOOGLE_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($credential);

    if ($payload) {

        // récuperer les infos
        $userid = $payload['sub'];
        $email = $payload['email'];
        $nom = $payload['family_name'];
        $prenom = $payload['given_name'];
        $picture = $payload['picture'];

        // Si le compte existe, connecter
        if (compte_exists($email, $db)) {


            $query = "SELECT * FROM compte, utilisateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur AND compte.email_compte = '$email'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $_SESSION['id_compte'] = $result['id_compte'];
            $_SESSION['type_compte'] = $result['type_compte'];
            $_SESSION['id_utilisateur'] = $result['id_utilisateur'];
            $_SESSION['pseudo_compte'] = $result['pseudo_compte'];
            $_SESSION['statut_compte'] = $result['statut_compte'];

            $_SESSION['nom_utilisateur'] = $result['nom_utilisateur'];
            $_SESSION['prenom_utilisateur'] = $result['prenom_utilisateur'];
            $_SESSION['email_utilisateur'] = $result['email_utilisateur'];
            $_SESSION['tel_utilisateur'] = $result['tel_utilisateur'];
            $_SESSION['avatar_utilisateur'] = $result['avatar_utilisateur'];


            if ($result['type_compte'] == "dg") {
                $message = "parametres corrects - dg";
            }

            if ($result['type_compte'] == "dd") {
                $message = "parametres corrects - dd";
            }

            if ($result['type_compte'] == "dm") {
                $message = "parametres corrects - dm";
            }

            if ($result['type_compte'] == "cm") {
                $message = "parametres corrects - cm";
            }

            if ($result['type_compte'] == "am") {
                $message = "parametres corrects - am";
            }

            if ($result['type_compte'] == "stg") {
                $message = "parametres corrects - stg";
            }
        } else {
            $message = 'compte inexistant';
        }
    } else {
        // Invalid ID token
    }
} else {

    //Vérifie si le formulaire a été envoyé
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "
        SELECT * 
        FROM compte
        INNER JOIN utilisateur
        ON compte.id_utilisateur = utilisateur.id_utilisateur
        WHERE email_compte = '$email'
        ";
    $message = '';

    $statement = $db->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();

    if ($count > 0  && $email != 'null' && $password != 'null') {

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        //Si le compte est Actif
        if ($data['statut_compte'] == 'actif') {

            //Si le mot de passe de l'admin correspond 
            if ($password == $data['mdp_compte']) {

                //update('utilisateur', ['etat_personne' => 'connecte'], "email_personne = '$email'", $db);
                //On créé une session pour stocker l'id de l'admin et son role

                $_SESSION['id_compte'] = $data['id_compte'];
                $_SESSION['type_compte'] = $data['type_compte'];
                $_SESSION['id_utilisateur'] = $data['id_utilisateur'];
                $_SESSION['pseudo_compte'] = $data['pseudo_compte'];
                $_SESSION['statut_compte'] = $data['statut_compte'];

                $_SESSION['nom_utilisateur'] = $data['nom_utilisateur'];
                $_SESSION['prenom_utilisateur'] = $data['prenom_utilisateur'];
                $_SESSION['email_utilisateur'] = $data['email_utilisateur'];
                $_SESSION['tel_utilisateur'] = $data['tel_utilisateur'];
                $_SESSION['avatar_utilisateur'] = $data['avatar_utilisateur'];


                if ($data['type_compte'] == "dg") {
                    $message = "parametres corrects - dg";
                }

                if ($data['type_compte'] == "dd") {
                    $message = "parametres corrects - dd";
                }

                if ($data['type_compte'] == "dm") {
                    $message = "parametres corrects - dm";
                }

                if ($data['type_compte'] == "cm") {
                    $message = "parametres corrects - cm";
                }

                if ($data['type_compte'] == "am") {
                    $message = "parametres corrects - am";
                }

                if ($data['type_compte'] == "stg") {
                    $message = "parametres corrects - stg";
                }
            } else {

                $message = "Mot de passe erroné";
            }
        } else {

            $message = "Compte désactivé";
        }
    } else {
        $message = "Email invalide";
    }
}

echo json_encode($message);
