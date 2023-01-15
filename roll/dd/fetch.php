<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('dd');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_collabo') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND utilisateur.id_utilisateur <> {$_SESSION['id_utilisateur']} 
        AND type_compte <> 'admin' AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";


        $statement = $db->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        $data = array();

        $filtered_rows = $statement->rowCount();


        foreach ($result as $row) {

            $sub_array = array();

            $id_collaborateur = $row['id_collaborateur'];
            $nom = $row['nom_utilisateur'];
            $prenom = $row['prenom_utilisateur'];
            $email = $row['email_utilisateur'];
            $telephone = $row['tel_utilisateur'];

            $statut_compte = $row['statut_compte'];

            $dossiers = select_all_actifs_dossiers_collabo($id_collaborateur, $db);

            switch ($statut_compte) {
                case 'actif':
                    $statut_compte_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_compte_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a data-sorting="{$prenom} {$nom}" href="roll/dd/view_redirect/?action=view_collaborateur&id_view_collaborateur={$id_collaborateur}" 
                    class="fs-6 text-gray-800 text-hover-primary">$prenom $nom</a>
                </div>
            HTML;

            // dossiers
            $sub_array[] = <<<HTML
                <td>
                    <div class="text-dark fw-bold d-block fs-6">$dossiers</div>
                    <span class="text-muted fw-semibold text-muted d-block fs-7">dossiers</span>
                </td>
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            $data[] = $sub_array;
        }

        $output = array(
            "data"                =>    $data
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
