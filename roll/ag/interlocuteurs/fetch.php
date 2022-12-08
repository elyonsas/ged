<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_interlo') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM utilisateur, compte, interlocuteur WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = interlocuteur.id_utilisateur AND utilisateur.id_utilisateur <> {$_SESSION['id_utilisateur']} 
        AND type_compte <> 'admin' AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";


        // // pour la recherche
        // if (isset($_POST["search"]["value"])) {
        //     $query .= 'AND (nom_utilisateur LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR prenom_utilisateur LIKE "%'. $_POST["search"]["value"] .'%" ';
        //     $query .= 'OR titre_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR created_at_article LIKE "%' . $_POST["search"]["value"] . '%" ';
        //     $query .= 'OR date_valide_article LIKE "%' . $_POST["search"]["value"] . '%" ';
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

        $filtered_rows = $statement->rowCount();


        foreach ($result as $row) {

            $sub_array = array();

            $id_interlocuteur = $row['id_interlocuteur'];
            $id_client = $row['id_client'];
            $id_utilisateur = find_id_utilisateur_by_id_client($id_client, $db);
            $nom = $row['nom_utilisateur'];
            $prenom = $row['prenom_utilisateur'];
            $email = $row['email_utilisateur'];
            $telephone = $row['tel_utilisateur'];

            $statut_compte = $row['statut_compte'];

            $fonction = $row['fonction_interlocuteur'];
            $client = find_info_utilisateur('nom_utilisateur', $id_utilisateur, $db);

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

            // interlocuteur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <div data-sorting="{$prenom} {$nom}" class="fs-6 text-gray-800 text-hover-primary">$prenom $nom</div>
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

            // fonction
            $sub_array[] = <<<HTML
                <td>
                    <div class="text-dark fw-bold d-block fs-6">$fonction</div>
                </td>
            HTML;

            // Client
            $sub_array[] = <<<HTML
                <td>
                    <div class="text-dark fw-bold d-block fs-6">$client</div>
                </td>
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            // Action
            // switch ($statut_compte) {
            //     case 'actif':
            //         $action = <<<HTML

            //             <td>
            //                 <div class="d-flex justify-content-end flex-shrink-0">
                            
            //                     <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            //                         <i class="bi bi-three-dots fs-3"></i>
            //                     </button>
            //                     <!--begin::Menu 3-->
            //                     <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

            //                         <!--begin::Menu item-->
            //                         <div class="menu-item px-3">
            //                             <a href="" class="desactiver_compte menu-link px-3" data-id_interlocuteur="{$id_interlocuteur}">Désactiver ce compte</a>
            //                         </div>
            //                         <!--end::Menu item-->
                                    
            //                         <!--begin::Menu item-->
            //                         <div class="menu-item px-3">
            //                             <a href="" class="attribuer_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#attribuer_modal" data-id_interlocuteur="{$id_interlocuteur}">Attribuer un dossier</a>
            //                         </div>
            //                         <!--end::Menu item-->

            //                         <!--begin::Menu separator-->
            //                         <!-- <div class="separator mt-3 opacity-75"></div> -->
            //                         <!--end::Menu separator-->

            //                         <!--begin::Menu item-->
            //                         <!-- <div class="menu-item">
            //                             <div class="menu-content px-3 py-3">
            //                                 <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_interlocuteur="{$id_interlocuteur}">Supprimer définitivement</a>
            //                             </div>
            //                         </div> -->
            //                         <!--end::Menu item-->
            //                     </div>
            //                     <!--end::Menu 3-->
            //                 </div>
            //             </td>

            //         HTML;
            //         break;
            //     case 'inactif':
            //         $action = <<<HTML

            //             <td>
            //                 <div class="d-flex justify-content-end flex-shrink-0">

            //                     <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            //                         <i class="bi bi-three-dots fs-3"></i>
            //                     </button>
            //                     <!--begin::Menu 3-->
            //                     <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

            //                         <!--begin::Menu item-->
            //                         <div class="menu-item px-3">
            //                             <a href="" class="activer_compte menu-link px-3" data-id_interlocuteur="{$id_interlocuteur}">Activer ce compte</a>
            //                         </div>
            //                         <!--end::Menu item-->

            //                         <!--begin::Menu separator-->
            //                         <!-- <div class="separator mt-3 opacity-75"></div> -->
            //                         <!--end::Menu separator-->

            //                         <!--begin::Menu item-->
            //                         <!-- <div class="menu-item">
            //                             <div class="menu-content px-3 py-3">
            //                                 <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_interlocuteur="{$id_interlocuteur}">Supprimer définitivement</a>
            //                             </div>
            //                         </div> -->
            //                         <!--end::Menu item-->
            //                     </div>
            //                     <!--end::Menu 3-->
            //                 </div>
            //             </td>

            //         HTML;
            //         break;
            // }

            // $sub_array[] = $action;

            $data[] = $sub_array;
        }


        $output = array(
            "data"                =>    $data
        );
    }
}

if (isset($_POST['action'])) {

    // some code

}



echo json_encode($output);
