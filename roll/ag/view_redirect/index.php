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

    if ($_GET['action'] == 'view_client') {

        $id_client = $_GET['id_view_client'];
        $_SESSION['id_view_client'] = $id_client;

        header('Location: /ged/roll/ag/dossiers/view');
    }

    if ($_GET['action'] == 'view_saisie_client') {

        $id_client = $_GET['id_view_saisie_client'];
        $_SESSION['id_view_saisie_client'] = $id_client;

        header('Location: /ged/roll/ag/saisies-clients/view');
    }

    if ($_GET['action'] == 'view_facture') {

        $id_facture = $_GET['id_view_facture'];
        $_SESSION['id_view_facture'] = $id_facture;

        header('Location: /ged/roll/ag/comptabilite/facture/view');
    }
}
