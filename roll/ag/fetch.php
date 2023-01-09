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
                    <div class="symbol symbol-45px me-5">
                        <div class="text-dark fw-bold fs-6" style="--bs-text-opacity:1;">$secteur_activite</div><br>
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                    </div>
                </div>
            HTML;

            // Client
            $sub_array[] = <<<HTML
                <div class="d-flex align-items-center">
                    <style>
                        .text-underline-hover:hover {
                            text-decoration: underline !important;
                        }
                    </style>
                    <div class="symbol symbol-45px me-5">
                        <a class="text-dark text-underline-hover" href="roll/ag/view_redirect/?action=view_of_secteur_activite&id_secteur_activite={$id_secteur_activite}" style="font-size: 13.975px;">$nbr_client client$end_s</a>
                    </div>
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
    if ($_POST['stat_chart'] == 'mixedwidget') {

        $max_moy = 1;
        if (max_mois_client_a_jour($db, 'six month') > max_mois_client_a_jour($db, 'pass month')) {
            $max_moy = max_mois_client_a_jour($db, 'six month');
        } else {
            $max_moy = max_mois_client_a_jour($db, 'pass month');
        }

        $month = date('Y-m');
        $month_1 = date('Y-m', strtotime('-1 month'));
        $month_2 = date('Y-m', strtotime('-2 months'));
        $month_3 = date('Y-m', strtotime('-3 months'));
        $month_4 = date('Y-m', strtotime('-4 months'));
        $month_5 = date('Y-m', strtotime('-5 months'));

        $stat_month = ceil((stat_mois_client_a_jour($db) * 100) / $max_moy);
        $stat_month_1 = ceil((stat_mois_client_a_jour($db, $month_1) * 100) / $max_moy);
        $stat_month_2 = ceil((stat_mois_client_a_jour($db, $month_2) * 100) / $max_moy);
        $stat_month_3 = ceil((stat_mois_client_a_jour($db, $month_3) * 100) / $max_moy);
        $stat_month_4 = ceil((stat_mois_client_a_jour($db, $month_4) * 100) / $max_moy);
        $stat_month_5 = ceil((stat_mois_client_a_jour($db, $month_5) * 100) / $max_moy);

        $stat_array = [
            'stat_month' => $stat_month,
            'stat_month_1' => $stat_month_1,
            'stat_month_2' => $stat_month_2,
            'stat_month_3' => $stat_month_3,
            'stat_month_4' => $stat_month_4,
            'stat_month_5' => $stat_month_5,
            'stat_date' => date('M', strtotime($month)),
            'stat_date_1' => date('M', strtotime($month_1)),
            'stat_date_2' => date('M', strtotime($month_2)),
            'stat_date_3' => date('M', strtotime($month_3)),
            'stat_date_4' => date('M', strtotime($month_4)),
            'stat_date_5' => date('M', strtotime($month_5)),
        ];
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
            add_log('add_secteur_activite_client', "Ajout du secteur d'activité '$nom_secteur_activite' dans le système", $_SESSION['id_utilisateur'], $db);
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
