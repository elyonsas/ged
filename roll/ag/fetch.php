<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {


}

if (isset($_POST['action'])) {
    
    // Paramêtre de l'application
    if ($_POST['action'] == 'sidebar_minimize'){
        $_SESSION['param_sidebar_minimize'] = $_POST['sidebar_minimize'];
        $output = array(
            'success' => true,
            'message' => 'Sidebar minimize = '. $_SESSION['param_sidebar_minimize']
        );
    }

}



echo json_encode($output);
