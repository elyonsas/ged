<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

connected('ag');

if (isset($_GET['action'])) {

    if ($_GET['action'] == 'view_collaborateur') {

        $id_collaborateur = $_GET['id_view_collaborateur'];
        $_SESSION['id_view_collaborateur'] = $id_collaborateur;

        header('Location: /ged/roll/ag/collaborateurs/view');
    }
}
