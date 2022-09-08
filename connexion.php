<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/fonctions.php');
require_once(__DIR__ . '/fonctions-sql.php');

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

if ($count > 0) {

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

            $_SESSION['nom_utilisateur'] = $data['nom_utilisateur'];
            $_SESSION['prenom_utilisateur'] = $data['prenom_utilisateur'];
            $_SESSION['email_utilisateur'] = $data['email_utilisateur'];
            $_SESSION['tel_utilisateur'] = $data['tel_utilisateur'];
            $_SESSION['avatar_utilisateur'] = $data['avatar_utilisateur'];

            // Menu session active
            $_SESSION['menu_view_articles'] = 'all';
            $_SESSION['menu_add_articles'] = 'add_public';

            $_SESSION['menu_view_clients'] = 'all';
            $_SESSION['menu_add_clients'] = 'add_clients';

            $_SESSION['menu_view_redacteurs'] = 'all';
            $_SESSION['menu_add_redacteurs'] = 'add_redacteurs';

            $_SESSION['menu_view_correcteurs'] = 'all';
            $_SESSION['menu_add_correcteurs'] = 'add_correcteurs';

            $_SESSION['menu_view_equipe'] = 'all';
            $_SESSION['menu_add_equipe'] = 'add_equipe';

            $_SESSION['menu_view_missions'] = 'all';
            

            if ($data['type_compte'] == "client") {
                $message = "parametres corrects - client";
            }

            if ($data['type_compte'] == "fournisseur") {
                $message = "parametres corrects - fournisseur";
            }

            if ($data['type_compte'] == "redacteur") {
                $message = "parametres corrects - redacteur";
            }

            if ($data['type_compte'] == "correcteur") {
                $message = "parametres corrects - correcteur";
            }

        } else {

            $message = "Mot de passe erroné";
        }
    } else {

        $message = "Compte désactivé";
    }
}else{
    $message = "Email invalide";
}

echo json_encode($message);
