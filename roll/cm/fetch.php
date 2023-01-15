<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('cm');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'dossiers_collabo') {

        $id_collaborateur = select_info('id_collaborateur', 'collaborateur', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

        $query = "SELECT * FROM assoc_client_collabo, client, collaborateur, utilisateur 
        WHERE assoc_client_collabo.id_client = client.id_client AND assoc_client_collabo.id_collaborateur = collaborateur.id_collaborateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND collaborateur.id_collaborateur = $id_collaborateur 
        AND statut_assoc_client_collabo = 'actif' ORDER BY updated_at_assoc_client_collabo DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        $filtered_rows = $statement->rowCount();

        $i = 1;
        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $nom_client = $row['nom_utilisateur'];
            $matricule_client = $row['matricule_client'];
            $email_client = $row['email_utilisateur'];
            $telephone_client = $row['tel_utilisateur'];
            $role_client = $row['role_assoc_client_collabo'];

            // #
            $sub_array[] = $i;

            // Client
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/cm/view_redirect/?action=view_client&id_view_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_client</a>
                </div>
            HTML;

            // Matricule
            $sub_array[] = <<<HTML
                $matricule_client
            HTML;

            // Rôle
            switch ($role_client) {
                case 'ag':
                    $role_client = 'Associé Gérant';
                    break;

                case 'dd':
                    $role_client = 'Directeur de département';
                    break;

                case 'dm':
                    $role_client = 'Directeur de mission';
                    break;

                case 'cm':
                    $role_client = 'Chef de mission';
                    break;

                case 'am':
                    $role_client = 'Assistant mission';
                    break;

                case 'stg':
                    $role_client = 'Stagiaire';
                    break;
            }

            $data[] = $sub_array;
            $i++;
        }


        $output = $data;
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
    if ($_POST['action'] == 'sidebar_minimize') {
        $_SESSION['param_sidebar_minimize'] = $_POST['sidebar_minimize'];
        $output = array(
            'success' => true,
            'message' => 'Sidebar minimize = ' . $_SESSION['param_sidebar_minimize']
        );
    }

    if ($_POST['action'] == 'add_secteur_activite_client') {

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

    // Pour les notifications
    if ($_POST['action'] == 'alert_notif_read') {

        $update = update(
            'notification',
            [
                'lu_notification' => 'oui'
            ],
            "type_notification = 'alert' AND id_utilisateur = {$_SESSION['id_utilisateur']}",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'Alerte notif lu'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Erreur notif lu'
            );
        }
    }
    if ($_POST['action'] == 'log_notif_read') {

        $update = update(
            'notification',
            [
                'lu_notification' => 'oui'
            ],
            "type_notification = 'log' AND id_utilisateur = {$_SESSION['id_utilisateur']}",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'Log notif lu'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Erreur notif lu'
            );
        }
    }
}



echo json_encode($output);
