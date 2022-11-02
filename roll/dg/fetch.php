<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('dg');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_collabo') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur ORDER BY statut_compte ASC";


        // // pour la recherche
        // if (isset($_POST["search"]["value"])) {
        //     $query .= 'AND (nom_utilisateur LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR prenom_utilisateur LIKE "%'. $_POST["search"]["value"] .'%" ';
        //     $query .= 'OR titre_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR created_at_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR date_valide_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR statut_article LIKE "%' . $_POST["search"]["value"] . '%" ) ';
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

        $filtered_rows = $statement->rowCount();


        foreach ($result as $row) {

            $sub_array = array();

            $id_collaborateur = $row['id_collaborateur'];
            $nom = $row['nom_utilisateur'];
            $prenom = $row['prenom_utilisateur'];
            $email = $row['email_utilisateur'];
            $telephone = $row['tel_utilisateur'];

            $dossiers = 50;

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="" class="fs-6 text-gray-800 text-hover-primary">$prenom $nom</a>
                </div>
            HTML;

            // email
            $sub_array[] = <<<HTML
                $email
            HTML;

            // Telephone
            $sub_array[] = <<<HTML
                $telephone
            HTML;

            // dossiers
            $sub_array[] = <<<HTML
                $dossiers
            HTML;

            // Action
            $action = <<<HTML

                <td>
                    <div class="d-flex justify-content-end flex-shrink-0">
                    
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="voir" href="" data-id_collaborateur="{$id_collaborateur}" class="view_article btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="bi bi-eye-fill fs-3"></i>
                        </a>
                        <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                        </a> -->
                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-three-dots fs-3"></i>
                        </button>
                        <!--begin::Menu 3-->
                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Coming soon</a>
                            </div>
                            <!--end::Menu item-->
                            
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Coming soon</a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="menu-link px-3" data-id_collaborateur="{$id_collaborateur}">Coming soon</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu 3-->
                    </div>
                </td>

            HTML;

            $sub_array[] = $action;

            $data[] = $sub_array;
        }

        function get_total_all_records($db)
        {
            $statement = $db->prepare("SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = collaborateur.id_utilisateur ORDER BY statut_compte ASC"); // same query as above
            $statement->execute();
            return $statement->rowCount();
        }


        $output = array(
            "recordsTotal"      =>  $filtered_rows,
            "recordsFiltered"     =>     get_total_all_records($db),
            "data"                =>    $data
        );
    }
}

if (isset($_POST['action'])) {

}



echo json_encode($output);
