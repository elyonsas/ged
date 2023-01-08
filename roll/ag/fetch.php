<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'secteur_activite_client') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM secteur_activite";

        $statement = $db->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        $data = array();


        foreach ($result as $row) {

            $sub_array = array();

            $id_secteur_activite = $row['id_secteur_activite'];
            $secteur_activite = $row['nom_secteur_activite'];
            $nbr_client = stat_client($db, null, $id_secteur_activite);
            $end_s = end_s($nbr_client);

            // Secteur activité
            $sub_array[] = <<<HTML
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-5"><a href="#" class="text-dark fw-bold text-hover-primary fs-6" style="--bs-text-opacity:1;">$secteur_activite</a><br></div>
                    <div class="d-flex justify-content-start flex-column">
                    </div>
                </div>
            HTML;

            // Client
            $sub_array[] = <<<HTML
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-5"><span style="font-size: 13.975px;">$nbr_client client$end_s</span></div>
                    <div class="d-flex justify-content-start flex-column">
                    </div>
                </div>
            HTML;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }

}

if (isset($_POST['stat_chart'])) {

    $stat_array = [];
    if ($_POST['stat_chart'] == 'list_chart') {

        $dec = stat_client($db, 1);
        $dac = stat_client($db, 2);
        $dc = stat_client($db, 3);

        $stat_array = array(
            'dec' => $dec,
            'dac' => $dac,
            'dc' => $dc
        );
        
    }

    $output = $stat_array;
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

    if ($_POST['action'] == 'add_secteur_activite_client'){
        
        $nom_secteur_activite = $_POST['nom_secteur_activite'];
        $description_secteur_activite = $_POST['description_secteur_activite'];

        $insert = insert(
            'secteur_activite',
            [
                'nom_secteur_activite' => $nom_secteur_activite,
                'description_secteur_activite' => $description_secteur_activite
            ],
            $db
        );

        $id = $db->lastInsertId();

        $update = update(
            'secteur_activite',
            [
                'code_secteur_activite' => 14000 + $id
            ],
            "id_secteur_activite = $id",
            $db
        );

        if ($insert && $update) {
            $output = array(
                'success' => true,
                'message' => ''
            );
        } else {
            $output = array(
                'success' => false,
                'message' => ''
            );
        }
        
    }

}



echo json_encode($output);
