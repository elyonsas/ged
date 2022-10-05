<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'example_key';
// $payload = [
//     'iss' => 'http://example.org',
//     'aud' => 'http://example.com',
//     'iat' => 1356999524,
//     'nbf' => 1357000000
// ];

// /**
//  * IMPORTANT:
//  * You must specify supported algorithms for your application. See
//  * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
//  * for a list of spec-compliant algorithms.
//  */
// $jwt = JWT::encode($payload, $key, 'HS256');
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

$jwt = "eyJhbGciOiJSUzI1NiIsImtpZCI6ImVkMzZjMjU3YzQ3ZWJhYmI0N2I0NTY4MjhhODU4YWE1ZmNkYTEyZGQiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJuYmYiOjE2NjQ5NjQ0NTUsImF1ZCI6IjE3NDUwMTc2NDM3OS1kaWs1YTh1cGJqdHFtOWFlMTFnajJkczJzZ2N1NWxpYS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwMTEyNjM5NDE3MTUzMjUyODM1MSIsImVtYWlsIjoiYXJuYXVkYWRqb3ZpMjc0QGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhenAiOiIxNzQ1MDE3NjQzNzktZGlrNWE4dXBianRxbTlhZTExZ2oyZHMyc2djdTVsaWEuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJuYW1lIjoiQXJuYXVkIEFkam92aSIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS9BTG01d3UyN0k3R19halIwODVEX0VKMDgyaHI5NF94emt0UXozWndxd2ppVj1zOTYtYyIsImdpdmVuX25hbWUiOiJBcm5hdWQiLCJmYW1pbHlfbmFtZSI6IkFkam92aSIsImlhdCI6MTY2NDk2NDc1NSwiZXhwIjoxNjY0OTY4MzU1LCJqdGkiOiIyYjYzNzM3ODI0MzFiMGQ0ZmRiYzI4OWU0NmRmNGNjZDZjY2Y4NWVkIn0.GsWAaatTO3rHpTpUzAkEdmz2mH46nz2kD5z_JeXY53_vPKtqzArAxDj0fQ-u_dgKir2kLSyuNhsZ1jBKaOxvFCDSeMxolKTSRLJjOpXEOoHwhXAq7reTgpllwQHHevWYqfFfHu6rcmgAvQkWsrD-NCbS20kmxE2yjoAp9eRAz9iKCgEAwuXhZFoD_ezKDSqqNbJ0NCJQuqw9_NNaKYf-EM_MO3tVMGk-Ve8O-7DTFRHjuNFnmMehNcgU4C2hgD9ajyw_vdfI_STqXHxxYEypwIS6nPVgXfuGG8wUKIXlyDbGWxjVCPP0tnAjg8qLmxSfgqqTYi9hc1FS-Qu-utk5NA";


dd($decoded);

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

echo json_encode($message);
