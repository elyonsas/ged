<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_dossiers') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";


        // // pour la recherche
        // if (isset($_POST["search"]["value"])) {
        //     $query .= 'AND (nom_utilisateur LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR prenom_utilisateur LIKE "%'. $_POST["search"]["value"] .'%" ';
        //     $query .= 'OR titre_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR created_at_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR date_valide_client LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR statut_compte LIKE "%' . $_POST["search"]["value"] . '%" ) ';
        // }

        // // Filtrage dans le tableau
        // if (isset($_POST['order'])) {
        //     $query .= 'ORDER BY ' . $colonne[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        // }
        // if ($_POST['length'] != -1) {
        //     $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        // }


        $statement = $db->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        $data = array();


        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $nom_client = $row['nom_utilisateur'];
            $matricule_client = $row['matricule_client'];

            $prise_en_charge_client = $row['prise_en_charge_client'];
            $attribuer_a = '';
            switch ($prise_en_charge_client) {
                case 'oui':
                    $prise_en_charge_client = '<span class="badge badge-success">Oui</span>';
                    $attribuer_a = '';
                    break;

                case 'non':
                    $prise_en_charge_client = '<span class="badge badge-danger">Non</span>';
                    $attribuer_a = <<<HTML
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="" class="attribuer_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_client="{$id_client}">Attribuer à</a>
                        </div>
                        <!--end::Menu item-->
                    HTML;
                    break;
            }

            $statut_compte = $row['statut_compte'];
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

            // Client
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/ag/view_redirect/?action=view_saisie_client&id_view_saisie_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_client</a>
                </div>
            HTML;

            // Matricule
            $sub_array[] = <<<HTML
                $matricule_client
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'saisies_clients') {

        $id_client = $_SESSION['id_view_saisie_client'];

        $query = "SELECT * FROM saisie, client WHERE saisie.id_client = client.id_client 
        AND saisie.id_client = $id_client ORDER BY created_at ASC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        $filtered_rows = $statement->rowCount();

        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $rubrique = $row['rubrique'];

            // Rubrique
            $sub_array[] = <<<HTML
                $rubrique
            HTML;

            //janv_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['janv_c']}</div>
            HTML;

            //janv_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['janv_i']}</div>
            HTML;

            //janv_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['janv_s']}</div>
            HTML;

            //fevr_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['fevr_c']}</div>
            HTML;

            //fevr_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['fevr_i']}</div>
            HTML;

            //fevr_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['fevr_s']}</div>
            HTML;

            //mars_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mars_c']}</div>
            HTML;

            //mars_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mars_i']}</div>
            HTML;

            //mars_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mars_s']}</div>
            HTML;

            //avr_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['avr_c']}</div>
            HTML;

            //avr_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['avr_i']}</div>
            HTML;

            //avr_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['avr_s']}</div>
            HTML;

            //mai_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mai_c']}</div>
            HTML;

            //mai_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mai_i']}</div>
            HTML;

            //mai_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['mai_s']}</div>
            HTML;

            //juin_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juin_c']}</div>
            HTML;

            //juin_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juin_i']}</div>
            HTML;

            //juin_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juin_s']}</div>
            HTML;

            //juil_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juil_c']}</div>
            HTML;

            //juil_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juil_i']}</div>
            HTML;

            //juil_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['juil_s']}</div>
            HTML;

            //aout_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['aout_c']}</div>
            HTML;

            //aout_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['aout_i']}</div>
            HTML;

            //aout_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['aout_s']}</div>
            HTML;

            //sept_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['sept_c']}</div>
            HTML;

            //sept_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['sept_i']}</div>
            HTML;

            //sept_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['sept_s']}</div>
            HTML;

            //oct_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['oct_c']}</div>
            HTML;

            //oct_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['oct_i']}</div>
            HTML;

            //oct_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['oct_s']}</div>
            HTML;

            //nov_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['nov_c']}</div>
            HTML;

            //nov_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['nov_i']}</div>
            HTML;

            //nov_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['nov_s']}</div>
            HTML;

            //dec_c
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['dec_c']}</div>
            HTML;

            //dec_i
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['dec_i']}</div>
            HTML;

            //dec_s
            $sub_array[] = <<<HTML
                <div style="font-size: 11px;" class="text-center text-muted">{$row['dec_s']}</div>
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
