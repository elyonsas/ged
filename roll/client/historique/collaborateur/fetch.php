<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'historiques') {

        $output = array();

        $id_client = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

        $query = "SELECT * FROM assoc_client_collabo, collaborateur, client, utilisateur, compte 
        WHERE assoc_client_collabo.id_client = client.id_client AND assoc_client_collabo.id_collaborateur = collaborateur.id_collaborateur
        AND utilisateur.id_utilisateur = compte.id_utilisateur AND utilisateur.id_utilisateur = collaborateur.id_utilisateur 
        AND client.id_client = $id_client ORDER BY updated_at_assoc_client_collabo DESC";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();

        foreach ($result as $row) {

            $sub_array = array();

            $id_collaborateur = $row['id_collaborateur'];
            $id_client = $row['id_client'];
            $id_utilisateur = find_id_utilisateur_by_id_client($id_client, $db);
            $client = find_info_utilisateur('nom_utilisateur', $id_utilisateur, $db);


            $nom = $row['nom_utilisateur'];
            $prenom = $row['prenom_utilisateur'];

            $fonction = $row['role_assoc_client_collabo'];

            $telephone = $row['tel_utilisateur'];

            $statut_assoc_client_collabo = $row['statut_assoc_client_collabo'];
            switch ($statut_assoc_client_collabo) {
                case 'actif':
                    $statut_assoc_client_collabo_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_assoc_client_collabo_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

            $debut = date('d/m/Y', strtotime($row['date_debut_assoc_client_collabo']));
            $fin = si_funct1($row['date_fin_assoc_client_collabo'], date('d/m/Y', strtotime($row['date_fin_assoc_client_collabo'])), '--');

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <div class="fs-6 text-gray-800">$prenom $nom</div>
                </div>
            HTML;

            // fonction
            $sub_array[] = <<<HTML
                <td>
                    <div class="text-dark fw-bold d-block fs-6">$fonction</div>
                </td>
            HTML;

            // Telephone
            $sub_array[] = <<<HTML
                $telephone
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_assoc_client_collabo_html
            HTML;

            // Debut
            $sub_array[] = <<<HTML
                $debut
            HTML;

            // Fin
            $sub_array[] = <<<HTML
                $fin
            HTML;

            $data[] = $sub_array;
        }


        $output = array(
            "data" => $data
        );
    }
}

if (isset($_POST['action'])) {

    // some code

}



echo json_encode($output);
