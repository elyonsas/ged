<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('client');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_dossiers') {

        $output = array();
        
        if (isset($_SESSION['data_client_secteur_activite']) && $_POST['data_client'] != '') {
            $result = $_SESSION['data_client_secteur_activite'];
        } else {
            $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND statut_compte <> 'supprime' ORDER BY statut_compte ASC";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
        }

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
                    <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_client</a>
                </div>
            HTML;

            // Matricule
            $sub_array[] = <<<HTML
                $matricule_client
            HTML;

            // Prise en charge
            $sub_array[] = <<<HTML
                $prise_en_charge_client
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_compte_html
            HTML;

            // Action
            switch ($statut_compte) {
                case 'actif':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="edit_client menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_client_modal" data-id_client="{$id_client}">Modification rapide</a>
                                    </div>
                                    <!--end::Menu item-->

                                    $attribuer_a

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="desactiver_compte menu-link px-3" data-id_client="{$id_client}">Désactiver ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'inactif':
                    $action = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">

                                <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="edit_client menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_client_modal" data-id_client="{$id_client}">Modification rapide</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="activer_compte menu-link px-3" data-id_client="{$id_client}">Activer ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
            }

            $sub_array[] = $action;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'collabos_dossier') {

        $id_client = $_SESSION['id_view_client'];

        $query = "SELECT * FROM assoc_client_collabo, client, collaborateur, utilisateur 
        WHERE assoc_client_collabo.id_client = client.id_client AND assoc_client_collabo.id_collaborateur = collaborateur.id_collaborateur 
        AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND client.id_client = $id_client 
        AND statut_assoc_client_collabo = 'actif' ORDER BY updated_at_assoc_client_collabo DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();
        $filtered_rows = $statement->rowCount();
        $i = 1;

        // Ajouter l'associé-gérant et le directeur de département
        $ag = find_ag_cabinet($db);
        foreach ($ag as $row) {
            $sub_array = array();

            $id_utilisateur = $row['id_utilisateur'];
            $id_collaborateur = find_id_collabo_by_id_utilisateur($id_utilisateur, $db);
            $nom_collaborateur = $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur'];
            $email_collaborateur = $row['email_utilisateur'];
            $telephone_collaborateur = $row['tel_utilisateur'];
            $role = "Associé-Gérant";

            // #
            $sub_array[] = $i;

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_collaborateur</a>
                </div>
            HTML;

            // Téléphone
            $sub_array[] = <<<HTML
                $telephone_collaborateur
            HTML;

            // Rôle
            $sub_array[] = <<<HTML
                $role
            HTML;

            // Actions
            $action = <<<HTML

                <td>
                    <div class="d-flex justify-content-end flex-shrink-0">

                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-three-dots fs-3"></i>
                        </button>
                        <!--begin::Menu 3-->
                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="view_detail_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_collabo_modal" data-id_collaborateur="{$id_collaborateur}">Details</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu 3-->
                    </div>
                </td>

            HTML;
            $sub_array[] = $action;

            $data[] = $sub_array;
            $i++;
        }

        $dd = find_dd_dec($db);

        // Begin::Directeur de département row
        $sub_array = array();

        $id_utilisateur = $dd['id_utilisateur'];
        $id_collaborateur = find_id_collabo_by_id_utilisateur($id_utilisateur, $db);
        $nom_collaborateur = $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur'];
        $email_collaborateur = $dd['email_utilisateur'];
        $telephone_collaborateur = $dd['tel_utilisateur'];
        $role = "Directeur de département";

        // #
        $sub_array[] = $i;

        // Collaborateur
        $sub_array[] = <<<HTML
            <div class="d-flex flex-column justify-content-center">
                <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}" 
                class="fs-6 text-gray-800 text-hover-primary">$nom_collaborateur</a>
            </div>
        HTML;

        // Téléphone
        $sub_array[] = <<<HTML
            $telephone_collaborateur
        HTML;

        // Rôle
        $sub_array[] = <<<HTML
            $role
        HTML;

        $data[] = $sub_array;

        // End::Directeur de département row

        foreach ($result as $row) {

            $sub_array = array();

            $id_client = $row['id_client'];
            $id_collaborateur = $row['id_collaborateur'];
            $nom_collaborateur = $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur'];
            $email_collaborateur = $row['email_utilisateur'];
            $telephone_collaborateur = $row['tel_utilisateur'];
            $role_client = $row['role_assoc_client_collabo'];

            // #
            $sub_array[] = $i;

            // Collaborateur
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a href="roll/client/view_redirect/?action=view_client&id_view_client={$id_client}" 
                    class="fs-6 text-gray-800 text-hover-primary">$nom_collaborateur</a>
                </div>
            HTML;

            // Téléphone
            $sub_array[] = <<<HTML
                $telephone_collaborateur
            HTML;

            // Rôle
            switch ($role_client) {
                case 'cm':
                    $role_client = 'Chef de mission';
                    break;

                case 'am':
                    $role_client = 'Assistant mission';
                    break;
            }
            $sub_array[] = <<<HTML
                $role_client
            HTML;

            // Actions
            $action = <<<HTML

                <td>
                    <div class="d-flex justify-content-end flex-shrink-0">

                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-three-dots fs-3"></i>
                        </button>
                        <!--begin::Menu 3-->
                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="view_detail_collabo menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_collabo_modal" data-id_collaborateur="{$id_collaborateur}">Details</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="" class="retirer_dossier menu-link text-hover-danger px-3" data-id_client="{$id_client}" data-id_collaborateur="{$id_collaborateur}">Retirer ce dossier</a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <!-- <div class="separator mt-3 opacity-75"></div> -->
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <!-- <div class="menu-item">
                                <div class="menu-content px-3 py-3">
                                    <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_collaborateur="{$id_collaborateur}">Supprimer définitivement</a>
                                </div>
                            </div> -->
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu 3-->
                    </div>
                </td>

            HTML;
            $sub_array[] = $action;

            $data[] = $sub_array;
            $i++;
        }


        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'documents_juridico_admin') {

        $output = array();
        $query = '';

        $type_dossier_document = $_POST['type_dossier_document'];
        if ($type_dossier_document == 'all') {
            $type_dossier_document_query = "";
        } else {
            $type_dossier_document_query = "AND type_dossier_document = '$type_dossier_document'";
        }

        $query .= "SELECT * FROM document WHERE id_client = {$_SESSION['id_view_client']} $type_dossier_document_query AND aspect_document = 'juridiques_et_administratifs' AND statut_document != 'supprime' AND statut_document != 'demande' ORDER BY updated_at_document DESC";


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

            $id_document = $row['id_document'];
            $n_document = $row['n_document'];
            $matricule_client = find_info_client('matricule_client', $row['id_client'], $db);
            $titre_document = $row['titre_document'];
            $max_titre_document = (strlen($titre_document) > 55) ? substr($titre_document, 0, 55) . '...' : $titre_document;
            $type_document = $row['type_document'];
            $table_document = $row['table_document'];
            $table_info_document = $row['table_info_document'];
            $derniere_modif = date('d/m/Y H:i:s', strtotime($row['updated_at_document']));
            $statut_document = $row['statut_document'];
            $src_scan_document = $row['src_scan_document'];

            $statut_document = $row['statut_document'];
            switch ($statut_document) {
                case 'valide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-success">Validé</span>
                    HTML;
                    break;
                case 'invalide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-danger">Invalidé</span>
                    HTML;
                    break;
            }

            // N° Document
            $sub_array[] = <<<HTML
                $n_document
            HTML;

            // Document
            if ($statut_document == 'valide') {

                if ($src_scan_document != NULL) {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                } else {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                }
            } else {

                $sub_array[] = <<<HTML
                    <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                        class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                    </div>
                HTML;
            }

            // Dernière modification
            $sub_array[] = <<<HTML
                $derniere_modif
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_document_html
            HTML;

            $data[] = $sub_array;
        }


        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'documents_techniques') {

        $output = array();
        $query = '';

        $type_dossier_document = $_POST['type_dossier_document'];
        if ($type_dossier_document == 'all') {
            $type_dossier_document_query = "";
        } else {
            $type_dossier_document_query = "AND type_dossier_document = '$type_dossier_document'";
        }

        $rubrique_document = $_POST['rubrique_document'];
        if ($rubrique_document == 'all') {
            $rubrique_document_query = "";
        } else {
            $rubrique_document_query = "AND rubrique_document = '$rubrique_document'";
        }

        $query .= "SELECT * FROM document WHERE id_client = {$_SESSION['id_view_client']} $type_dossier_document_query $rubrique_document_query AND aspect_document = 'techniques' AND statut_document != 'supprime' AND statut_document != 'demande' ORDER BY updated_at_document DESC";


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

            $id_document = $row['id_document'];
            $n_document = $row['n_document'];
            $matricule_client = find_info_client('matricule_client', $row['id_client'], $db);
            $titre_document = $row['titre_document'];
            $max_titre_document = (strlen($titre_document) > 55) ? substr($titre_document, 0, 55) . '...' : $titre_document;
            $type_document = $row['type_document'];
            $table_document = $row['table_document'];
            $table_info_document = $row['table_info_document'];
            $derniere_modif = date('d/m/Y H:i:s', strtotime($row['updated_at_document']));
            $statut_document = $row['statut_document'];
            $src_scan_document = $row['src_scan_document'];

            $statut_document = $row['statut_document'];
            switch ($statut_document) {
                case 'valide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-success">Validé</span>
                    HTML;
                    break;
                case 'invalide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-danger">Invalidé</span>
                    HTML;
                    break;
            }

            // N° Document
            $sub_array[] = <<<HTML
                $n_document
            HTML;

            // Document
            if ($statut_document == 'valide') {

                if ($src_scan_document != NULL) {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                } else {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                }
            } else {

                $sub_array[] = <<<HTML
                    <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                        class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                    </div>
                HTML;
            }

            // Dernière modification
            $sub_array[] = <<<HTML
                $derniere_modif
            HTML;

            // Statut
            $sub_array[] = <<<HTML
                $statut_document_html
            HTML;

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );
    }

    if ($_POST['datatable'] == 'documents_sommaire') {

        $output = array();

        $query = "SELECT * FROM document WHERE id_client = {$_SESSION['id_view_client']} AND n_document >= 1 AND n_document <= 19 ORDER BY n_document ASC";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();

            $id_document = $row['id_document'];
            $n_document = $row['n_document'];
            $titre_document = $row['titre_document'];
            // Recupérer la chaine de caractère regex (DOC N°\d*-?\d* ) dans le titre du document
            $regex = preg_match('/DOC N°\d*-?\d* /', $titre_document, $document);
            // remplacer regex (DOC N°\d*-?\d* ) par '' dans le titre du document
            $titre_document = preg_replace('/DOC N°\d*-?\d* /', '', $titre_document);
            $max_titre_document = (strlen($titre_document) > 100) ? mb_substr($titre_document, 0, 100) . '...' : $titre_document;
            $type_document = $row['type_document'];
            $table_document = $row['table_document'];
            $table_info_document = $row['table_info_document'];
            $derniere_modif = date('d/m/Y H:i:s', strtotime($row['updated_at_document']));
            $statut_document = $row['statut_document'];
            $src_scan_document = $row['src_scan_document'];

            $statut_document = $row['statut_document'];
            switch ($statut_document) {
                case 'valide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-success">Validé</span>
                    HTML;
                    break;
                case 'invalide':
                    $statut_document_html = <<<HTML
                        <span class="badge badge-light-danger">Invalidé</span>
                    HTML;
                    break;
            }

            // Document
            if ($statut_document == 'valide') {

                if ($src_scan_document != NULL) {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    }
                } else {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                            </div>
                        HTML;
                    }
                }
            } else {

                $sub_array[] = <<<HTML
                    <div style="cursor: not-allowed;" class="d-flex" data-id_document="{$id_document}">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                        class="fs-6 text-gray-800 text-hover-primary min-w-100px">$document[0]</span>
                    </div>
                HTML;
            }

            // Intitulé
            if ($statut_document == 'valide') {

                if ($src_scan_document != NULL) {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_scan d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_scan_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                } else {

                    if ($type_document == 'generate') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'write') {

                        $sub_array[] = <<<HTML
                            <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    } else if ($type_document == 'file') {

                        $sub_array[] = <<<HTML
                            <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                                <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                                class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                            </div>
                        HTML;
                    }
                }
            } else {

                $sub_array[] = <<<HTML
                    <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                        class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                    </div>
                HTML;
            }

            $data[] = $sub_array;
        }

        $output = array(
            "data" => $data
        );

    }
}

if (isset($_POST['action'])) {

    // espace datatables

    if ($_POST['action'] == 'add_doc') {

        $id_client = $_SESSION['id_view_client'];

        $titre_document = $_POST['titre_document'];
        $description_document = $_POST['description_document'];
        $type_document = $_POST['type_document'];
        $table_document = 'document_autre';
        $aspect_document = $_POST['aspect'];
        $type_dossier_document = $_POST['type_dossier'];
        $rubrique_document = $_POST['rubrique'];

        $insert1 = insert(
            'document',
            [
                'titre_document' => $titre_document,
                'type_document' => $type_document,
                'table_document' => $table_document,
                'note_aspect_document' => 0,
                'statut_document' => 'invalide',
                'aspect_document' => $aspect_document,
                'type_dossier_document' => $type_dossier_document,
                'rubrique_document' => $rubrique_document,
                'created_at_document' => date('Y-m-d H:i:s'),
                'updated_at_document' => date('Y-m-d H:i:s'),
                'created_by_document' => $_SESSION['id_utilisateur'],
                'updated_by_document' => $_SESSION['id_utilisateur'],
                'id_client' => $id_client
            ],
            $db
        );

        // id_document
        $id_document = $db->lastInsertId();

        $update = update(
            'document',
            [
                'n_document' => $id_document,
                'code_document' => 13000 + $id_document
            ],
            "id_document = '$id_document'",
            $db
        );

        $insert2 = insert(
            'document_autre',
            [
                'src_document' => "",
                'src_temp_document' => "",
                'contenu_document' => "",
                'contenu_text_document' => "",
                'contenu_modele_document' => "",
                'description_document' => $description_document,
                'id_document' => $id_document
            ],
            $db
        );


        if ($insert1 && $insert2 && $update) {
            $output = [
                'success' => true,
                'message' => 'Document ajouté !',
                'id_document' => $id_document,
                'type_document' => $type_document,
                'titre_document' => $titre_document,
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }

    if ($_POST['action'] == 'demander_doc') {

        $id_client = $_SESSION['id_view_client'];
        $id_utilisateur = select_info('id_utilisateur', 'client', "id_client = '$id_client'", $db);
        $nom_client = select_info('nom_utilisateur', 'utilisateur', "id_utilisateur = '$id_utilisateur'", $db);

        $titre_document = $_POST['titre_document'];
        $description_document = $_POST['description_document'];
        $type_document = $_POST['type_document'];
        $table_document = 'document_autre';
        $aspect_document = $_POST['aspect_document'];
        $type_dossier_document = $_POST['type_dossier'];
        $rubrique_document = $_POST['rubrique'];

        // Insertion dans la table document
        $insert1 = insert(
            'document',
            [
                'titre_document' => $titre_document,
                'type_document' => $type_document,
                'table_document' => $table_document,
                'note_aspect_document' => 0,
                'statut_document' => 'demande',
                'aspect_document' => $aspect_document,
                'type_dossier_document' => $type_dossier_document,
                'rubrique_document' => $rubrique_document,
                'created_at_document' => date('Y-m-d H:i:s'),
                'updated_at_document' => date('Y-m-d H:i:s'),
                'created_by_document' => $_SESSION['id_utilisateur'],
                'updated_by_document' => $_SESSION['id_utilisateur'],
                'id_client' => $id_client
            ],
            $db
        );

        // id_document
        $id_document = $db->lastInsertId();
        $code_document = 13000 + $id_document;

        $update = update(
            'document',
            [
                'n_document' => $id_document,
                'code_document' => $code_document
            ],
            "id_document = '$id_document'",
            $db
        );

        // Insertion dans la table document_autre
        $insert2 = insert(
            'document_autre',
            [
                'src_document' => "",
                'src_temp_document' => "",
                'contenu_document' => "",
                'contenu_text_document' => "",
                'contenu_modele_document' => "",
                'description_document' => $description_document,
                'id_document' => $id_document
            ],
            $db
        );

        // Insertion dans la table notification
        $insert3 = add_notif(
            'Demande de document #' . $code_document,
            'Une demande de document a été faite par ' . $_SESSION['nom_utilisateur'] . ' ' . $_SESSION['prenom_utilisateur'] . ' pour le client ' . $nom_client . ' !',
            'alert',
            'important',
            'roll/client/demande/',
            $id_utilisateur,
            $db
        );



        if ($insert1 && $insert2 && $insert3 && $update) {
            $output = [
                'success' => true,
                'message' => 'Le client recevra une notification de cette demande !',
                'id_document' => $id_document,
                'type_document' => $type_document,
                'titre_document' => $titre_document,
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }

    if ($_POST['action'] == 'fetch_secteur_activite') {

        $query = "SELECT * FROM secteur_activite";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '<option></option>';
        foreach ($result as $row) {
            $output .= <<<HTML
                <option value="{$row['id_secteur_activite']}">{$row['code_secteur_activite']} : {$row['nom_secteur_activite']}</option>
            HTML;
        }
    }

    if ($_POST['action'] == 'add_client') {

        // Si le compte existe déjà alors exit
        if (compte_exists($_POST['email_client'], $db)) {
            $output = [
                'success' => false,
                'message' => 'Cet email existe déjà dans GED !'
            ];
            
            echo json_encode($output);
            exit();
            
        }
        
        // Insertion dans la table utilisateur
        $insert1 = insert(
            'utilisateur',
            [
                'nom_utilisateur' => $_POST['nom_client'],
                'adresse_utilisateur' => $_POST['adresse_client'],
                'tel_utilisateur' => $_POST['tel_client'],
                'avatar_utilisateur' => 'compagnie_blank.png',
                'email_utilisateur' => $_POST['email_client'],
                'created_at_utilisateur' => date('Y-m-d H:i:s'),
                'updated_at_utilisateur' => date('Y-m-d H:i:s'),
            ],
            $db
        );

        $id_utilisateur = $db->lastInsertId();

        // Insertion dans la table compte
        $insert2 = insert(
            'compte',
            [
                'pseudo_compte' => $_POST['nom_client'],
                'email_compte' => $_POST['email_client'],
                'mdp_compte' => '12345',
                'statut_compte' => 'inactif',
                'type_compte' => 'client',
                'created_at_compte' => date('Y-m-d H:i:s'),
                'updated_at_compte' => date('Y-m-d H:i:s'),
                'id_utilisateur' => $id_utilisateur,
            ],
            $db
        );

        // Insertion dans la table client
        $insert3 = false;
        $update = false;
        if ($insert1 && $insert2) {

            $uuid = Uuid::uuid1();
            $code_view_client = $uuid->toString();
            $prise_en_charge_client = 'non';
            $relance_auto_client = 'non';
            $id_secteur_activite = $_POST['secteur_activite_client'];
            $id_departement = 1;

            $insert3 = insert(
                'client',
                [
                    'code_view_client' => $code_view_client,
                    'prise_en_charge_client' => $prise_en_charge_client,
                    'relance_auto_client' => $relance_auto_client,
                    'id_secteur_activite' => $id_secteur_activite,
                    'id_departement' => $id_departement,
                    'id_utilisateur' => $id_utilisateur,
                ],
                $db
            );

            $id_client = $db->lastInsertId();
            $sigle_departement = select_info('sigle_departement', 'departement', "id_departement = $id_departement", $db);
            $code = 12000 + $id_client;

            $update1 = update(
                'client',
                [
                    'matricule_client' => $sigle_departement . '-' . $code,
                ],
                "id_client = $id_client",
                $db
            );
        }

        // Insertion dans la table document

        // `id_document`, `code_document`, `n_document`, `titre_document`, `type_document`, `table_document`, 
        // `table_info_document`, `note_aspect_document`, `statut_document`, `aspect_document`, 
        // `type_dossier_document`, `rubrique_document`, `created_at_document`, `updated_at_document`, 
        // `ordre_document`, `src_scan_document`, `src_scan_temp_document`, 
        // `type_scan_document`, `created_by_document`, `updated_by_document`, `id_client`
        $documents = [
            [NULL, NULL, 1, 'DOC N°1 Prospectus du cabinet', 'file', 'document_file', NULL, 0, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-10 16:14:14', '2022-12-08 11:04:14', 0, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 2, 'DOC N°2 Résumé de la prise de connaissance générale du client', 'write', 'document_write', NULL, 2, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-09 18:48:03', '2022-12-30 11:42:31', 1, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 3, 'DOC N°3 Questionnaire d\'acceptation et de maintien d\'une mission', 'generate', 'doc_3_accept_mission', NULL, 3, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-17 01:08:24', '2022-11-23 15:23:34', 7, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 4, 'DOC N°4 Lettre au confrère pour un client le quittant', 'write', 'document_write', NULL, 1, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-20 09:04:16', '2022-11-23 23:23:27', 4, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 5, 'DOC N°5 Lettre à un client hérité', 'write', 'document_write', NULL, 1, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-20 09:52:28', '2022-12-08 10:50:40', 5, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 6, 'DOC N°6 Lettre de mission DEC Validé', 'file', 'document_file', 'doc_6_info_lettre_mission', 3, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-21 14:07:17', '2022-12-11 14:12:17', 8, NULL, NULL, NULL, 2, 2, 7],
            [NULL, NULL, 7, 'DOC N°7 Avenant Lettre de mission DEC VALIDE', 'file', 'document_file', NULL, 0, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-21 14:23:21', '2022-11-21 14:41:17', 9, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 8, 'DOC N°8 Fiche d\'identification client', 'generate', 'doc_8_fiche_id_client', NULL, 3, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-09 18:19:23', '2022-12-23 12:15:17', 2, NULL, '', NULL, 2, 1, 7],
            [NULL, NULL, 9, 'DOC N°9 Fiche de détermination du niveau de risque', 'write', 'document_write', NULL, 2, 'invalide', 'techniques', 'permanent', 'connaissance_generale_client', '2022-11-20 08:40:23', '2022-11-27 17:27:57', 3, NULL, NULL, NULL, 2, 1, 7],
            [NULL, NULL, 9, 'DOC N°9 bis Lettre d’information au client des risques de son dossier', 'write', 'document_write', NULL, 0, 'invalide', 'techniques', 'permanent', 'connaissance_generale_client', '2022-12-29 11:54:37', '2022-12-29 11:55:38', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 10, 'DOC N°10-1 Modèle de chronogramme (échéancier) des impôts et taxes d’une entreprise relevant du régime normal', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:02:02', '2022-12-29 12:53:40', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 10, 'DOC N°10-2 Modèle de chronogramme (échéancier) des impôts et taxes  d’une entreprise à la TPS', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:03:00', '2022-12-29 12:53:19', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 10, 'DOC N°10-3 Modèle de chronogramme (échéancier) des cotisations CNSS d’une entreprise de plus de 20 salariés', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:03:20', '2022-12-29 12:52:38', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 10, 'DOC N°10-4 Modèle de chronogramme (échéancier) des cotisations CNSS d’une entreprise de moins de 20 salariés', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:03:52', '2022-12-29 12:51:05', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 11, 'DOC N°11 Fiche de déclaration d’indépendance des collaborateurs', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:07:38', '2022-12-29 12:54:01', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 12, 'DOC N°12-1 Modèle de lettre aux clients au titre de l’intervention d’autres professionnels (notaire, commissaires-priseurs, etc.)', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:08:24', '2022-12-29 12:54:29', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 12, 'DOC N°12-2 Modèle de lettre à la signature du client à adresser aux autres professionnels', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:08:56', '2022-12-29 12:54:15', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 13, 'DOC N°13-1 Nature des contrôles à effectuer', 'write', 'document_write', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:09:48', '2022-12-29 12:55:18', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 13, 'DOC N°13-2 Tableaux de revue de cohérence et de vraisemblance des éléments du bilan (avec les sous-tableaux N°13-2-1 à 13-2-8)', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:10:19', '2022-12-29 17:59:09', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 14, 'DOC N°14 Tableau de revue de cohérence et de vraisemblance des éléments du compte de résultat avec les données extracomptables', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:11:11', '2022-12-29 12:55:34', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 15, 'DOC N°15 Tableau de revue de cohérence et de vraisemblance du TFT lui-même et du TFT avec les éléments du bilan, du compte de résultat et des notes annexes', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'permanent', '', '2022-12-29 12:11:55', '2022-12-29 12:55:57', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 16, 'DOC N°16 Note de Synthèse d’une Mission du DEC', 'write', 'document_write', NULL, 0, 'invalide', 'techniques', 'general', 'synthese_mission_rapport', '2022-12-29 12:12:30', '2022-12-29 12:56:29', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 17, 'DOC N°17 Modèle d’attestation et de présentation des comptes annuels joints', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'general', 'exam_coherence_vraisemblance', '2022-12-29 12:14:10', '2022-12-29 12:56:51', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 18, 'DOC N°18 Modèle d’attestation de bonne fin d’exécution', 'file', 'document_file', NULL, 0, 'invalide', 'techniques', 'general', 'exam_coherence_vraisemblance', '2022-12-29 12:15:51', '2022-12-29 12:57:12', NULL, NULL, NULL, NULL, 1, 1, 7],
            [NULL, NULL, 19, 'DOC N°19 Questionnaire Lutte Anti Blanchiment', 'generate', 'doc_19_quiz_lcb', NULL, 2, 'invalide', 'juridiques_et_administratifs', 'permanent', 'connaissance_generale_client', '2022-11-20 10:14:20', '2022-12-29 17:47:17', 6, NULL, '', NULL, 2, 1, 7]
        ];

        foreach ($documents as $key => $document) {

            // Insérer les documents
            $insert4 = insert(
                'document',
                [
                    'n_document' => $document[2],
                    'titre_document' => $document[3],
                    'type_document' => $document[4],
                    'table_document' => $document[5],
                    'table_info_document' => $document[6],
                    'note_aspect_document' => $document[7],
                    'statut_document' => $document[8],
                    'aspect_document' => $document[9],
                    'type_dossier_document' => $document[10],
                    'rubrique_document' => $document[11],
                    'created_at_document' => date('Y-m-d H:i:s'),
                    'updated_at_document' => date('Y-m-d H:i:s'),
                    'created_by_document' => $_SESSION['id_utilisateur'],
                    'updated_by_document' => $_SESSION['id_utilisateur'],
                    'id_client' => $id_client
                ],
                $db
            );

            $id_document = $db->lastInsertId();

            $update2 = update(
                'document',
                [
                    'code_document' => 13000 + $id_document,
                ],
                "id_document = $id_document",
                $db
            );

            // S'il existe des table_document, les insérer
            $insert5 = false;
            if ($document[5] != NULL) {
                $insert5 = insert(
                    $document[5],
                    [
                        'id_document' => $id_document,
                    ],
                    $db
                );
            }


        }

        // Créer un dossier pour le client sur le serveur
        $id_departement = select_info('id_departement', 'client', "id_client = $id_client", $db);
        $sigle_departement = select_info('sigle_departement', 'departement', "id_departement = $id_departement", $db);

        $path = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/docs/' . $sigle_departement . '-' . $code;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // if ($insert1 && $insert2 && $insert3 && $insert4 && $update1) {
        if ($insert4 && $insert5 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Le client ajouté avec succès'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du client'
            );
        }
    }

    if ($_POST['action'] == 'fetch_edit_client') {
        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, compte, client, secteur_activite WHERE utilisateur.id_utilisateur = compte.id_utilisateur AND utilisateur.id_utilisateur = client.id_utilisateur
        AND client.id_secteur_activite = secteur_activite.id_secteur_activite AND client.id_client = $id_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }

    if ($_POST['action'] == 'edit_client'){
        $id_client = $_POST['id_client'];
        $id_utilisateur = select_info('id_utilisateur', 'client', "id_client = $id_client", $db);
        $id_secteur_activite = select_info('id_secteur_activite', 'client', "id_client = $id_client", $db);
        $nom_client = select_info('nom_utilisateur', 'utilisateur', "id_utilisateur = $id_utilisateur", $db);

        $update1 = update(
            'utilisateur',
            [
                'nom_utilisateur' => $_POST['nom_client'],
                'adresse_utilisateur' => $_POST['adresse_client'],
                'tel_utilisateur' => $_POST['tel_client'],
                'email_utilisateur' => $_POST['email_client'],
                'updated_at_utilisateur' => date('Y-m-d H:i:s'),
            ],
            "id_utilisateur = $id_utilisateur",
            $db
        );

        $update2 = update(
            'client',
            [
                'id_secteur_activite' => $id_secteur_activite,
            ],
            "id_client = $id_client",
            $db
        );

        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => "Les informations du client <b>$nom_client</b> ont été modifiées !"
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }


    }

    if ($_POST['action'] == 'activer_compte') {
        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_utilisateur = $result['id_utilisateur'];
        $statut_compte = $result['statut_compte'];

        $update = update(
            'compte',
            ['statut_compte' => 'actif'],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'message' => 'Compte activé !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'desactiver_compte') {
        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_utilisateur = $result['id_utilisateur'];
        $statut_compte = $result['statut_compte'];

        $update1 = update(
            'compte',
            ['statut_compte' => 'inactif'],
            "id_utilisateur = '$id_utilisateur'",
            $db
        );

        $update2 = update(
            'client',
            ['prise_en_charge_client' => 'non'],
            "id_client = '$id_client'",
            $db
        );

        $update3 = update(
            'assoc_client_collabo',
            [
                'statut_assoc_client_collabo' => 'inactif',
                'date_fin_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s')
            ],
            "id_client = $id_client",
            $db
        );


        if ($update1 && $update2 && $update3) {
            $output = array(
                'success' => true,
                'message' => 'Compte désactivé !'
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            );
        }
    }

    if ($_POST['action'] == 'fetch_attribuer_collabo') {

        $id_client = $_POST['id_client'];

        // Récupérer les infos du client
        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
        AND utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = '$id_client'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'success' => true,
            'id_client' => $result['id_client'],
            'nom_client' => $result['nom_utilisateur'],
            'dossier_html' => ''
        ];

        if ($result) {
            $query = "SELECT * FROM utilisateur, compte, collaborateur WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = collaborateur.id_utilisateur AND compte.statut_compte = 'actif'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            $output['dossier_html'] .= '<option></option>';
            foreach ($result as $row) {
                $output['dossier_html'] .= <<<HTML
                    <option value="{$row['id_collaborateur']}">collaborateur {$row['code_collaborateur']} : {$row['prenom_utilisateur']} {$row['nom_utilisateur']}</option>
                HTML;
            }
        }
    }

    if ($_POST['action'] == 'edit_attribuer_collabo') {

        $id_collaborateur = $_POST['id_collaborateur'];
        $id_client = $_POST['id_client'];

        $query1 = "SELECT * FROM utilisateur, collaborateur WHERE utilisateur.id_utilisateur = collaborateur.id_utilisateur
        AND collaborateur.id_collaborateur = '$id_collaborateur'";
        $statement1 = $db->prepare($query1);
        $statement1->execute();
        $result1 = $statement1->fetch();

        $query2 = "SELECT * FROM utilisateur, client WHERE utilisateur.id_utilisateur = client.id_utilisateur
        AND client.id_client = '$id_client'";
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $result2 = $statement2->fetch();

        // insert
        $insert = insert(
            'assoc_client_collabo',
            [
                'role_assoc_client_collabo' => 'cm',
                'statut_assoc_client_collabo' => 'actif',
                'date_debut_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'date_fin_assoc_client_collabo' => null,
                'created_at_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'id_client' => $id_client,
                'id_collaborateur' => $id_collaborateur
            ],
            $db
        );

        // update
        $update = update(
            'client',
            ['prise_en_charge_client' => 'oui'],
            "id_client = '$id_client'",
            $db
        );

        if ($insert && $update) {
            $output = array(
                'success' => true,
                'message' => "Le dossier <b>{$result2['nom_utilisateur']}</b> a été attribué à <b>{$result1['prenom_utilisateur']} {$result1['nom_utilisateur']}</b> !"
            );
        }
    }

    // espace client
    if ($_POST['action'] == 'send_mail') {

        if ($_POST['option'] == 'add_doc') {
            // Send email
            $query = "SELECT * FROM document WHERE id_document = {$_POST['id_document']}";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $titre_document = $result['titre_document'];
            $code_document = $result['code_document'];
            $matricule_client = find_info_client('matricule_client', $result['id_client'], $db);
            $nom_client = find_info_client('nom_utilisateur', $result['id_client'], $db);
            $add_by = $_SESSION['prenom_utilisateur'] . ' ' . $_SESSION['nom_utilisateur'];
            $url = "";

            $to = [
                'to' => [],
            ];

            // Ajouter les AG
            $ag = find_ag_cabinet($db);
            foreach ($ag as $row) {
                $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
            }

            // Ajouter le DD DEC
            $dd = find_dd_dec($db);
            $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];

            $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];

            $subject = 'Ajout de document dans GED-ELYON';

            $message = <<<HTML
            
                <!DOCTYPE html>
                <html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
            
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
            
                    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
            
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],
                        /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        /* If the above doesn't work, add a .g-img class to any image in question. */
                        img.g-img+div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you'd like to fix */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u~div .email-container {
                                min-width: 320px !important;
                            }
                        }
            
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u~div .email-container {
                                min-width: 375px !important;
                            }
                        }
            
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u~div .email-container {
                                min-width: 414px !important;
                            }
                        }
                    </style>
            
                    <style>
                        .primary {
                            background: #0078D4;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
            
                        .bg_light {
                            background: #fafafa;
                        }
            
                        .bg_black {
                            background: #000000;
                        }
            
                        .bg_dark {
                            background: rgba(0, 0, 0, .8);
                        }
            
                        .email-section {
                            padding: 20px 15px;
                        }
            
                        /*BUTTON*/
                        .btn {
                            padding: 10px 15px;
                            cursor: pointer;
                            display: inline-block;
                        }
            
                        .btn.btn-primary {
                            border-radius: 5px;
                            background: #0078D4;
                            color: #ffffff;
                        }
            
                        .btn.btn-white {
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
            
                        .btn.btn-white-outline {
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
            
                        .btn.btn-black-outline {
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
            
                        h1,
                        h2,
                        h3,
                        h4,
                        h5,
                        h6 {
                            font-family: 'Lato', sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }
            
                        body {
                            font-family: 'Lato', sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, .4);
                        }
            
                        a {
                            color: #0078D4;
                        }
            
                        .logo h1 {
                            margin: 0;
                        }
            
                        .logo h1 a {
                            color: #0078D4;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: 'Lato', sans-serif;
                        }
            
                        .hero {
                            position: relative;
                            z-index: 0;
                        }
            
                        .hero .text {
                            color: rgba(0, 0, 0, .3);
                        }
            
                        .hero .text h2 {
                            color: #000;
                            font-size: 25px;
                            margin-bottom: 0;
                            font-weight: 400;
                            line-height: 1.4;
                        }
            
                        .hero .text h3 {
                            font-size: 20px;
                            font-weight: 300;
                        }
            
                        .hero .text h2 span {
                            font-weight: 600;
                            color: #0078D4;
                        }
            
                        .heading-section h2 {
                            color: #000000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                            font-weight: 400;
                        }
            
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, .4);
                            position: relative;
                        }
            
                        .heading-section .subheading::after {
                            position: absolute;
                            left: 0;
                            right: 0;
                            bottom: -10px;
                            content: '';
                            width: 100%;
                            height: 2px;
                            background: #0078D4;
                            margin: 0 auto;
                        }
            
                        .heading-section-white {
                            color: rgba(255, 255, 255, .8);
                        }
            
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
            
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, .4);
                        }
            
            
                        ul.social {
                            padding: 0;
                        }
            
                        ul.social li {
                            display: inline-block;
                            margin-right: 10px;
                        }
            
                        .footer {
                            border-top: 1px solid rgba(0, 0, 0, .05);
                            color: rgba(0, 0, 0, .6);
                        }
            
                        .footer .heading {
                            color: #000;
                            font-size: 20px;
                        }
            
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
            
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
            
                        .footer ul li a {
                            color: rgba(0, 0, 0, 1);
                        }
            
            
                        @media screen and (max-width: 500px) {}
                    </style>
            
            
                </head>
            
                <body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
                    <div style="width: 100%; background-color: #f1f1f1;">
                        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="logo" style="text-align: center;">
                                                    <h1>Document Ajouter</h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 1em 0;">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/files/fil007.svg-->
                                        <img style="width: 200px; max-width: 600px; height: auto; margin: auto; display: block; opacity: 0.3;" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/add-doc.png" alt="add-icon">
                                        <!--end::Svg Icon-->
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="text" style="padding: 0 2.5em; text-align: center;">
                                                        <h2>$titre_document</h2>
                                                        <h3>Le document #<b>$code_document</b> <strong><u>$titre_document</u></strong> à été ajouté au dossier client #<b>$matricule_client</b> <strong>$nom_client</strong> par <b><u>$add_by</u></b></h3>
                                                        <p><a href="{$url}" class="btn btn-primary">Cliquez pour consulter</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="middle" class="bg_light footer">
                                        <table>
                                            <tr>
                                                <td width="25%"
                                                    class="padding-bottom-20 padding-left-20 padding-right-20 padding-top-20">
                                                    <img width="130" height="130" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/logo_elyon.png" alt="elyon-icon">
                                                </td>
                                                <td width="75%" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; text-align: left; line-height: 1.5;">
                                                    CABINET ÉLYÔN
                                                    Audit, Expertise comptable, Commissariat aux comptes, Conseils
                                                    09 BP 290 Saint Michel - Cotonou
                                                    Tél: (+229) 21 32 77 78 / 21 03 35 32 / 97 22 19 85 / 90 94 07 99
                                                    Email: c_elyon@yahoo.fr, contact@elyonsas.com
                                                    Cotonou-Bénin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                                    <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                                        Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                                        <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </body>
            
                </html>
            
            HTML;

            $send_mail = send_mail($to, $from, $subject, $message);

            if ($send_mail) {
                $output = [
                    'success' => true,
                    'message' => 'Mail envoyé !',
                ];
                // Ajouter une notification pour les AG
                foreach ($ag as $row) {
                    add_notif(
                        'Ajout de document',
                        "Le document #$code_document à été ajouté au dossier client #$matricule_client",
                        'alert',
                        'important',
                        'roll/client/dossiers/',
                        $row['id_utilisateur'],
                        $db
                    );
                }

                // Ajouter une notification pour DD
                add_notif(
                    'Ajout de document',
                    "Le document #$code_document à été ajouté au dossier client #$matricule_client",
                    'alert',
                    'important',
                    'roll/client/dossiers/',
                    $dd['id_utilisateur'],
                    $db
                );

            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite ! !',
                ];
            }
        }
        if ($_POST['option'] == 'delete_doc') {
            // Send email
            $query = "SELECT * FROM document WHERE id_document = {$_POST['id_document']}";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $titre_document = $result['titre_document'];
            $code_document = $result['code_document'];
            $matricule_client = find_info_client('matricule_client', $result['id_client'], $db);
            $nom_client = find_info_client('nom_utilisateur', $result['id_client'], $db);
            $delete_by = $_SESSION['prenom_utilisateur'] . ' ' . $_SESSION['nom_utilisateur'];
            $url = "";

            $to = [
                'to' => [],
            ];

            // Ajouter les AG
            $ag = find_ag_cabinet($db);
            foreach ($ag as $row) {
                $to['to'][] = [$row['email_utilisateur'], $row['prenom_utilisateur'] . ' ' . $row['nom_utilisateur']];
            }

            // Ajouter le DD DEC
            $dd = find_dd_dec($db);
            $to['to'][] = [$dd['email_utilisateur'], $dd['prenom_utilisateur'] . ' ' . $dd['nom_utilisateur']];

            $from = ['c_elyon@yahoo.fr', 'Cabinet Elyon'];

            $subject = 'Suppression de document dans GED-ELYON';

            $message = <<<HTML
            
                <!DOCTYPE html>
                <html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
            
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
            
                    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
            
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
            
                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
            
                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
            
                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
            
                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
            
                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }
            
                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],
                        /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
            
                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
            
                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }
            
                        /* If the above doesn't work, add a .g-img class to any image in question. */
                        img.g-img+div {
                            display: none !important;
                        }
            
                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you'd like to fix */
            
                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u~div .email-container {
                                min-width: 320px !important;
                            }
                        }
            
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u~div .email-container {
                                min-width: 375px !important;
                            }
                        }
            
                        /* iPhone 6+, 7+, and 8+ */
                        @media only screen and (min-device-width: 414px) {
                            u~div .email-container {
                                min-width: 414px !important;
                            }
                        }
                    </style>
            
                    <style>
                        .primary {
                            background: #0078D4;
                        }
            
                        .bg_white {
                            background: #ffffff;
                        }
            
                        .bg_light {
                            background: #fafafa;
                        }
            
                        .bg_black {
                            background: #000000;
                        }
            
                        .bg_dark {
                            background: rgba(0, 0, 0, .8);
                        }
            
                        .email-section {
                            padding: 20px 15px;
                        }
            
                        /*BUTTON*/
                        .btn {
                            padding: 10px 15px;
                            cursor: pointer;
                            display: inline-block;
                        }
            
                        .btn.btn-primary {
                            border-radius: 5px;
                            background: #0078D4;
                            color: #ffffff;
                        }
            
                        .btn.btn-white {
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
            
                        .btn.btn-white-outline {
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
            
                        .btn.btn-black-outline {
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
            
                        h1,
                        h2,
                        h3,
                        h4,
                        h5,
                        h6 {
                            font-family: 'Lato', sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }
            
                        body {
                            font-family: 'Lato', sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, .4);
                        }
            
                        a {
                            color: #0078D4;
                        }
            
                        .logo h1 {
                            margin: 0;
                        }
            
                        .logo h1 a {
                            color: #0078D4;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: 'Lato', sans-serif;
                        }
            
                        .hero {
                            position: relative;
                            z-index: 0;
                        }
            
                        .hero .text {
                            color: rgba(0, 0, 0, .3);
                        }
            
                        .hero .text h2 {
                            color: #000;
                            font-size: 25px;
                            margin-bottom: 0;
                            font-weight: 400;
                            line-height: 1.4;
                        }
            
                        .hero .text h3 {
                            font-size: 20px;
                            font-weight: 300;
                        }
            
                        .hero .text h2 span {
                            font-weight: 600;
                            color: #0078D4;
                        }
            
                        .heading-section h2 {
                            color: #000000;
                            font-size: 28px;
                            margin-top: 0;
                            line-height: 1.4;
                            font-weight: 400;
                        }
            
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, .4);
                            position: relative;
                        }
            
                        .heading-section .subheading::after {
                            position: absolute;
                            left: 0;
                            right: 0;
                            bottom: -10px;
                            content: '';
                            width: 100%;
                            height: 2px;
                            background: #0078D4;
                            margin: 0 auto;
                        }
            
                        .heading-section-white {
                            color: rgba(255, 255, 255, .8);
                        }
            
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
            
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, .4);
                        }
            
            
                        ul.social {
                            padding: 0;
                        }
            
                        ul.social li {
                            display: inline-block;
                            margin-right: 10px;
                        }
            
                        .footer {
                            border-top: 1px solid rgba(0, 0, 0, .05);
                            color: rgba(0, 0, 0, .6);
                        }
            
                        .footer .heading {
                            color: #000;
                            font-size: 20px;
                        }
            
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
            
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
            
                        .footer ul li a {
                            color: rgba(0, 0, 0, 1);
                        }
            
            
                        @media screen and (max-width: 500px) {}
                    </style>
            
            
                </head>
            
                <body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
                    <div style="width: 100%; background-color: #f1f1f1;">
                        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td class="logo" style="text-align: center;">
                                                    <h1>Document supprimer</h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 1em 0;">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/files/fil007.svg-->
                                        <img style="width: 200px; max-width: 600px; height: auto; margin: auto; display: block; opacity: 0.3;" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/delete-doc.png" alt="delete-icon">
                                        <!--end::Svg Icon-->
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="text" style="padding: 0 2.5em; text-align: center;">
                                                        <h2>$titre_document</h2>
                                                        <h3>Le document #<b>$code_document</b> <strong><u>$titre_document</u></strong> à été supprimé du dossier client #<b>$matricule_client</b> <strong>$nom_client</strong> par <b><u>$delete_by</u></b></h3>
                                                        <p><a href="{$url}" class="btn btn-primary">Cliquez pour consulter</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" style="margin: auto;">
                                <tr>
                                    <td valign="middle" class="bg_light footer">
                                        <table>
                                            <tr>
                                                <td width="25%"
                                                    class="padding-bottom-20 padding-left-20 padding-right-20 padding-top-20">
                                                    <img width="130" height="130" src="https://elyonsas.github.io/ged-assets/assets/media/ged-mail/logo_elyon.png" alt="elyon-icon">
                                                </td>
                                                <td width="75%" colspan="2"
                                                    style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; text-align: left; line-height: 1.5;">
                                                    CABINET ÉLYÔN
                                                    Audit, Expertise comptable, Commissariat aux comptes, Conseils
                                                    09 BP 290 Saint Michel - Cotonou
                                                    Tél: (+229) 21 32 77 78 / 21 03 35 32 / 97 22 19 85 / 90 94 07 99
                                                    Email: c_elyon@yahoo.fr, contact@elyonsas.com
                                                    Cotonou-Bénin
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="margin: 0px auto; border-collapse: collapse; border-top: 1px solid rgba(0, 0, 0, .05); font-size: 0px; padding: 16px 0px 8px; word-break: break-word;">
                                                    <div style="font-family: system-ui, 'Segoe UI', sans-serif; font-size: 11px; line-height: 1.6; text-align: center; color: rgb(147, 149, 152);">
                                                        Cet email à été automatiquement générer par le logiciel GED-ELYON.
                                                        <a href="https://ged-elyon.com" style="color: rgb(0, 0, 0); text-decoration: none; background-color: transparent;">https://ged-elyon.com</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </body>
            
                </html>
            
            HTML;

            $send_mail = send_mail($to, $from, $subject, $message);

            if ($send_mail) {
                $output = [
                    'success' => true,
                    'message' => 'Mail envoyé !',
                ];

                // Ajouter une notification pour les AG
                foreach ($ag as $row) {
                    add_notif(
                        'Suppression de document',
                        "Le document #$code_document à été supprimé au dossier client #$matricule_client",
                        'alert',
                        'danger',
                        'roll/client/dossiers/',
                        $row['id_utilisateur'],
                        $db
                    );
                }

                // Ajouter une notification pour DD
                add_notif(
                    'Suppression de document',
                    "Le document #$code_document à été supprimé au dossier client #$matricule_client",
                    'alert',
                    'danger',
                    'roll/client/dossiers/',
                    $dd['id_utilisateur'],
                    $db
                );
            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite ! !',
                ];
            }
        }
        
    }

    if ($_POST['action'] == 'fetch_page_client') {
        $id_client = $_SESSION['id_view_client'];

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = client.id_utilisateur AND id_client = $id_client ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

            $query = "SELECT * FROM document, doc_8_fiche_id_client, client WHERE document.id_document = doc_8_fiche_id_client.id_document
            AND document.id_client = client.id_client AND document.id_client = $id_client";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $id_utilisateur = $row['id_utilisateur'];
            $avatar_client = <<<HTML
                <img src="assets/media/avatars/{$row['avatar_utilisateur']}" alt="image">
            HTML;
            $nom_client = $row['nom_utilisateur'];
            $email_client = $row['email_utilisateur'];
            $matricule_client = $row['matricule_client'];
            $date_naiss_client = si_funct1($row['date_naiss_utilisateur'], date('d/m/Y', strtotime($row['date_naiss_utilisateur'])), '--');
            $tel_client = $row['tel_utilisateur'];
            $adresse_client = $row['adresse_utilisateur'];

            $designation_entite = $result['designation_entite'] ?? $nom_client;
            $ifu_entite = $result['id_fiscale_client'] ?? '--';
            $boite_postal = isset($result['boite_postal']) ? $result['num_code'] . ' ' . $result['code'] . ' ' . $result['boite_postal'] : '--';
            $designation_activite_principale = $result['designation_activite_principale'] ?? '--';
            $adresse_geo_complete = $result['adresse_geo_complete'] ?? '--';

            $statut_client = $row['statut_compte'];
            switch ($statut_client) {
                case 'actif':
                    $statut_client_html = <<<HTML
                        <span class="badge badge-light-success">Actif</span>
                    HTML;
                    break;
                case 'inactif':
                    $statut_client_html = <<<HTML
                        <span class="badge badge-light-danger">Inactif</span>
                    HTML;
                    break;
            }

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

            $action_client = '';
            switch ($statut_client) {
                case 'actif':
                    $action_client = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="edit_client menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_client_modal" data-id_client="{$id_client}">Modification rapide</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
                case 'inactif':
                    $action_client = <<<HTML

                        <td>
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="view_detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="edit_client menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_client_modal" data-id_client="{$id_client}">Modification rapide</a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="activer_compte menu-link px-3" data-id_client="{$id_client}">Activer ce compte</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <!-- <div class="separator mt-3 opacity-75"></div> -->
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item">
                                        <div class="menu-content px-3 py-3">
                                            <a href="" class="supprimer_definitivement btn btn-light-danger px-4 w-100" data-id_client="{$id_client}">Supprimer définitivement</a>
                                        </div>
                                    </div> -->
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                    break;
            }

            // Validation des aspects
            $nbr_doc_ready_juridiques_et_administratifs = 0;
            $nbr_doc_ready_techniques = 0;
            $nbr_doc_ready_comptables_et_financiers = 0;

            $query = "SELECT * FROM document WHERE statut_document != 'supprime' AND id_client = '$id_client'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            foreach ($result as $row) {
                $table_document = $row['table_document'];
                $aspect_document = $row['aspect_document'];

                if ($aspect_document == 'juridiques_et_administratifs') {
                    switch ($table_document) {
                        case 'doc_3_accept_mission':
                            if ($row['statut_document'] == 'valide')
                                $nbr_doc_ready_juridiques_et_administratifs++;
                            break;
    
                        case 'doc_19_quiz_lcb':
                            if ($row['statut_document'] == 'valide')
                                $nbr_doc_ready_juridiques_et_administratifs++;
                            break;
    
                        case 'doc_8_fiche_id_client':
                            if ($row['statut_document'] == 'valide')
                                $nbr_doc_ready_juridiques_et_administratifs++;
                            break;
    
                        case 'document_file':
                            if ($row['table_info_document'] == 'doc_6_info_lettre_mission')
                                if ($row['statut_document'] == 'valide')
                                    $nbr_doc_ready_juridiques_et_administratifs++;
                            break;
    
                        default:
                            # code...
                            break;
                    }
                }else if ($aspect_document == 'techniques') {
                    if ($row['statut_document'] == 'valide')
                        $nbr_doc_ready_techniques++;
                }
                    
            }

            if ($nbr_doc_ready_juridiques_et_administratifs >= 4) {
                $ready_icon_juridiques_et_administratifs = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
            }else{
                $ready_icon_juridiques_et_administratifs = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-danger">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                            <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
            }

            if ($nbr_doc_ready_juridiques_et_administratifs >= 4 && $nbr_doc_ready_techniques >= 1) {
                $ready_icon_techniques = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
                $ready_icon_comptables_et_financiers = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
            }else{
                $ready_icon_techniques = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-danger">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                            <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
                $ready_icon_comptables_et_financiers = <<<HTML
                    <span class="svg-icon svg-icon-4 svg-icon-danger">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
                            <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                            <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                        </svg>
                    </span>
                HTML;
            }


            $output = array(
                'avatar_client' => $avatar_client,
                'nom_client' => $nom_client,
                'email_client' => $email_client,
                'matricule_client' => $matricule_client,
                'date_naiss_client' => $date_naiss_client,
                'tel_client' => $tel_client,
                'adresse_client' => $adresse_client,

                'designation_entite' => $designation_entite,
                'ifu_entite' => $ifu_entite,
                'boite_postal' => $boite_postal,
                'designation_activite_principale' => $designation_activite_principale,
                'adresse_geo_complete' => $adresse_geo_complete,

                'statut_client' => $statut_client_html,
                'prise_en_charge_client' => $prise_en_charge_client,
                'action_client' => $action_client,
                'ready_icon_juridiques_et_administratifs' => $ready_icon_juridiques_et_administratifs,
                'ready_icon_techniques' => $ready_icon_techniques,
                'ready_icon_comptables_et_financiers' => $ready_icon_comptables_et_financiers,
                'nbr_doc_ready_juridiques_et_administratifs' => $nbr_doc_ready_juridiques_et_administratifs,
                'nbr_doc_ready_techniques' => $nbr_doc_ready_techniques,
                'nbr_doc_ready_comptables_et_financiers' => $nbr_doc_ready_comptables_et_financiers,
            );

            // Récupérer les informations de la base de données
            $query = "SELECT SUM(montant_ttc_facture) as total_facture,  SUM(montant_regle_facture) as total_regle
            FROM facture WHERE id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $output['total_facture'] = $result['total_facture'];
            $output['query_total_facture'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";
            
            $output['total_regle'] = $result['total_regle'];
            $output['query_total_regle'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";
            
            $total_regle = $result['total_regle'];
            $total_facture = ($result['total_facture'] == 0) ? 1 : $result['total_facture'];
            $output['taux_recouvrement'] = round(($total_regle / $total_facture) * 100, 2);

            $output['stat_contrat'] = stat_ca_contrat_client($db, $id_client);
            $output['query_stat_contrat'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur 
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND type_facture = 'contrat' AND statut_facture <> 'supprimer'";
            
            $output['stat_facture'] = stat_ca_facture_client($db, $id_client);
            $output['query_stat_facture'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";
            
            $output['stat_non_facture'] = stat_ca_all_client($db, $id_client) - stat_ca_facture_client($db, $id_client);
            $output['query_stat_non_facture'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture = 'en attente' AND statut_facture <> 'supprimer'";
            
            $output['stat_encaisse'] = stat_ca_encaisse_client($db, $id_client);
            $output['query_stat_encaisse'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";

            $output['stat_creance'] = stat_ca_creance_client($db, $id_client);
            $output['query_stat_creance'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture <> 'en attente' AND statut_facture <> 'supprimer'";


            // Récupérer les informations de la base de données
            $query = "SELECT SUM(montant_ttc_facture) as total_echue, COUNT(*) as nb_facture_echue 
            FROM facture WHERE id_client = $id_client AND statut_facture = 'relance'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $output['total_echue'] = $result['total_echue'] ?? '--';
            $output['nb_facture_echue'] = $result['nb_facture_echue'];
            $output['query_total_echue'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture = 'relance'";

            // Récupérer les informations de la base de données
            $query = "SELECT SUM(montant_ttc_facture) as total_en_cour, COUNT(*) as nb_facture_en_cour 
            FROM facture WHERE id_client = $id_client AND statut_facture = 'en cour'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $output['total_en_cour'] = $result['total_en_cour'] ?? '--';
            $output['nb_facture_en_cour'] = $result['nb_facture_en_cour'];
            $output['query_total_en_cour'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture = 'en cour'";

            // Récupérer les informations de la base de données
            $query = "SELECT SUM(montant_ttc_facture) as total_solde, COUNT(*) as nb_facture_solde 
            FROM facture WHERE id_client = $id_client AND statut_facture = 'paye'";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $output['total_solde'] = $result['total_solde'] ?? '--';
            $output['nb_facture_solde'] = $result['nb_facture_solde'];
            $output['query_total_solde'] = "SELECT * FROM utilisateur, compte, client, facture WHERE utilisateur.id_utilisateur = compte.id_utilisateur
            AND utilisateur.id_utilisateur = client.id_utilisateur AND facture.id_client = client.id_client AND client.id_client = $id_client AND statut_facture = 'paye'";
        }
    }
    if ($_POST['action'] == 'fetch_table') {
        $table = $_POST['table'];
        $condition = $_POST['condition'];

        $query = "SELECT * FROM $table WHERE $condition";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = $result;
    }

    if ($_POST['action'] == 'view_detail_collabo') {

        $id_collaborateur = $_POST['id_collaborateur'];

        $query = "SELECT * FROM utilisateur, collaborateur WHERE utilisateur.id_utilisateur = collaborateur.id_utilisateur 
        AND collaborateur.id_collaborateur = $id_collaborateur";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'collaborateur' => $result['prenom_utilisateur'] . ' ' . $result['nom_utilisateur'],
            'code_collaborateur' => $result['code_collaborateur'],
            'telephone_collaborateur' => $result['email_utilisateur'],
            'email_collaborateur' => $result['tel_utilisateur'],
            'adresse_collaborateur' => $result['adresse_utilisateur'],
        ];
    }
    if ($_POST['action'] == 'view_detail_document') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = array();

        $aspect_document = $result['aspect_document'];
        switch ($aspect_document) {
            case 'juridiques_et_administratifs':
                $aspect_document = 'Juridiques et administratifs';
                break;
            case 'techniques':
                $aspect_document = 'Techniques';
                break;
            case 'comptables_et_financiers':
                $aspect_document = 'Comptables et financiers';
                break;
        }

        $code_document = $result['code_document'];
        $titre_document = $result['titre_document'];

        $statut_document = $result['statut_document'];
        switch ($statut_document) {
            case 'valide':
                $statut_document = <<<HTML
                    <span class="badge badge-light-success">Validé</span>
                HTML;
                break;
            case 'invalide':
                $statut_document = <<<HTML
                    <span class="badge badge-light-danger">Invalidé</span>
                HTML;
                break;
        }

        $created_by_document = find_info_utilisateur('prenom_utilisateur', $result['created_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['created_by_document'], $db);
        $created_at_document = si_funct1($result['created_at_document'], date('d/m/Y H:i:s', strtotime($result['created_at_document'])), '');
        $updated_by_document = find_info_utilisateur('prenom_utilisateur', $result['updated_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['updated_by_document'], $db);
        $updated_at_document = si_funct1($result['updated_at_document'], date('d/m/Y H:i:s', strtotime($result['updated_at_document'])), '');

        $output = [
            'aspect_document' => $aspect_document,
            'code_document' => $code_document,
            'titre_document' => $titre_document,
            'statut_document' => $statut_document,
            'created_by_document' => $created_by_document,
            'created_at_document' => $created_at_document,
            'updated_by_document' => $updated_by_document,
            'updated_at_document' => $updated_at_document
        ];
    }
    if ($_POST['action'] == 'view_detail_dossier') {

        $id_client = $_POST['id_client'];

        $query = "SELECT * FROM utilisateur, client WHERE utilisateur.id_utilisateur = client.id_utilisateur AND client.id_client = $id_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'nom_client' => $result['nom_utilisateur'],
            'matricule_client' => $result['matricule_client'],
            'tel_client' => $result['tel_utilisateur'],
            'email_client' => $result['email_utilisateur'],
            'adresse_client' => $result['adresse_utilisateur'],
        ];
    }

    if ($_POST['action'] == 'preview_doc_write') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];
        $output = [
            'titre_document' => $result['titre_document'],
            'contenu_document' => '',
        ];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['contenu_document'] = $result['contenu_document'];
    }
    if ($_POST['action'] == 'preview_doc_generate') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];
        $output = [
            'titre_document' => $result['titre_document'],
            'contenu_document' => '',
        ];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output['contenu_document'] = $result['contenu_document'];
    }
    if ($_POST['action'] == 'preview_doc_file') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);
        $table_document = $result['table_document'];
        $output = [
            'titre_document' => $result['titre_document'],
            'iframe_html' => ''
        ];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $src_document = $result['src_document'];
        $type_document = $result['type_document'];

        // Si le type du document est dans le tableau ['docx','.ppt','.pptx','.doc','.xls','.xlsx']
        if (in_array($type_document, ['.docx', '.ppt', '.pptx', '.doc', '.xls', '.xlsx'])) {
            $output['iframe_html'] .= <<<HTML
                <iframe class="iframe_html" src="https://view.officeapps.live.com/op/embed.aspx?src=https://raw.githubusercontent.com/elyonsas/ged/main/assets/docs/{$matricule_client}/{$src_document}" width='100%' height='100%' frameborder='0'></iframe>
            HTML;
        } else if ($type_document == '.pdf') {
            $output['iframe_html'] .= <<<HTML
                <iframe class="iframe_html" src="assets/docs/{$matricule_client}/{$src_document}" width='100%' height='100%' frameborder='0'></iframe>
            HTML;
        } else {
            $output['iframe_html'] = <<<HTML
                <iframe class="iframe_html" src="https://docs.google.com/gview?url=https://raw.githubusercontent.com/elyonsas/ged/main/assets/docs/{$matricule_client}/{$src_document}&embedded=true" width="100%" height="100%" frameborder="0"></iframe>
            HTML;
        }
    }

    if ($_POST['action'] == 'preview_doc_scan') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);
        $output = [
            'titre_document' => $result['titre_document'],
            'iframe_html' => ''
        ];

        $src_document = $result['src_scan_document'];
        $type_document = $result['type_scan_document'];

        // Si le type du document est dans le tableau ['docx','.ppt','.pptx','.doc','.xls','.xlsx']
        if (in_array($type_document, ['.docx', '.ppt', '.pptx', '.doc', '.xls', '.xlsx'])) {
            $output['iframe_html'] .= <<<HTML
                <iframe class="iframe_html" src="https://view.officeapps.live.com/op/embed.aspx?src=https://raw.githubusercontent.com/elyonsas/ged/main/assets/docs/{$matricule_client}/{$src_document}" width='100%' height='100%' frameborder='0'></iframe>
            HTML;
        } else if ($type_document == '.pdf') {
            $output['iframe_html'] .= <<<HTML
                <iframe class="iframe_html" src="assets/docs/{$matricule_client}/{$src_document}" width='100%' height='100%' frameborder='0'></iframe>
            HTML;
        } else {
            $output['iframe_html'] = <<<HTML
                <iframe class="iframe_html" src="https://docs.google.com/gview?url=https://raw.githubusercontent.com/elyonsas/ged/main/assets/docs/{$matricule_client}/{$src_document}&embedded=true" width="100%" height="100%" frameborder="0"></iframe>
            HTML;
        }
    }

    if ($_POST['action'] == 'fetch_edit_doc_write') {
        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'titre_document' => $result['titre_document'],
            'contenu_document' => $result['contenu_document']
        ];
    }
    if ($_POST['action'] == 'fetch_edit_doc_file') {
        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'titre_document' => $result['titre_document'],
        ];
    }
    if ($_POST['action'] == 'fetch_edit_doc_scan') {
        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = [
            'titre_document' => $result['titre_document'],
        ];
    }
    if ($_POST['action'] == 'fetch_edit_doc_generate') {
        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }
    if ($_POST['action'] == 'fetch_edit_info_doc_file') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_info_document = $result['table_info_document'];

        $query = "SELECT * FROM document, $table_info_document WHERE document.id_document = $table_info_document.id_document AND $table_info_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }
    if ($_POST['action'] == 'fetch_info_relance') {

        $id_client = $_SESSION['id_view_client'];

        $query = "SELECT * FROM client WHERE id_client = $id_client";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $output = $result;
    }

    if ($_POST['action'] == 'edit_doc_write') {

        $id_document = $_POST['id_document'];
        $contenu_document = $_POST['contenu_document'];
        $contenu_text_document = $_POST['contenu_text_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];

        $update1 = update(
            $table_document,
            [
                'contenu_document' => $contenu_document,
                'contenu_text_document' => $contenu_text_document,
                'contenu_modele_document' => $contenu_document
            ],
            "id_document = $id_document",
            $db
        );

        $update2 = update(
            'document',
            [
                'statut_document' => 'valide',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        if ($update1 && $update2) {
            $output = [
                'success' => true,
                'message' => 'Document enregistré !'
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_doc_file') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);
        $table_document = $result['table_document'];
        $titre_document = $result['titre_document'];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $src_document = $result['src_document'];
        $src_temp_document = $result['src_temp_document'];

        if ($src_temp_document == '') {
            $output = [
                'success' => false,
                'message' => 'Vous devez sélectionner un fichier !'
            ];
        } else {

            $infoPath = pathinfo($src_temp_document);
            $type_document = '.' . $infoPath['extension'];
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/docs/' . $matricule_client . '/' . $src_document;

            if (is_file($file_path)) {
                unlink($file_path);
            }

            $update1 = update(
                $table_document,
                [
                    'src_document' => $src_temp_document,
                    'src_temp_document' => '',
                    'type_document' => $type_document
                ],
                "id_document = $id_document",
                $db
            );

            $update2 = update(
                'document',
                [
                    'statut_document' => 'valide',
                    'updated_at_document' => date('Y-m-d H:i:s'),
                    'updated_by_document' => $_SESSION['id_utilisateur']
                ],
                "id_document = $id_document",
                $db
            );

            if ($update1 && $update2) {
                $output = [
                    'success' => true,
                    'message' => "Un nouveau document <b>$titre_document</b> à été bien enregistré !"
                ];
            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite !'
                ];
            }
        }
    }
    if ($_POST['action'] == 'edit_doc_scan') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);
        $table_document = $result['table_document'];
        $titre_document = $result['titre_document'];

        $src_scan_document = $result['src_scan_document'];
        $src_scan_temp_document = $result['src_scan_temp_document'];

        if ($src_scan_temp_document == '') {
            $output = [
                'success' => false,
                'message' => 'Vous devez sélectionner un fichier !'
            ];
        } else {

            $infoPath = pathinfo($src_scan_temp_document);
            $type_scan_document = '.' . $infoPath['extension'];
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/docs/' . $matricule_client . '/' . $src_scan_document;

            if (is_file($file_path)) {
                unlink($file_path);
            }

            $update = update(
                'document',
                [
                    'src_scan_document' => $src_scan_temp_document,
                    'src_scan_temp_document' => '',
                    'type_scan_document' => $type_scan_document,
                    'updated_at_document' => date('Y-m-d H:i:s'),
                    'updated_by_document' => $_SESSION['id_utilisateur']
                ],
                "id_document = $id_document",
                $db
            );

            if ($update) {
                $output = [
                    'success' => true,
                    'message' => "Un nouveau document scanné <b>$titre_document</b> à été bien enregistré !"
                ];
            } else {
                $output = [
                    'success' => false,
                    'message' => 'Une erreur s\'est produite !'
                ];
            }
        }
    }
    if ($_POST['action'] == 'edit_doc_generate') {

        $id_document = $_POST['id_document'];
        $contenu_document = $_POST['contenu_document'];
        $contenu_text_document = $_POST['contenu_text_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];

        $update1 = update(
            $table_document,
            [
                'contenu_document' => $contenu_document,
            ],
            "id_document = $id_document",
            $db
        );

        $update2 = update(
            'document',
            [
                'statut_document' => 'valide',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        if ($update1 && $update2) {
            $output = [
                'success' => true,
                'message' => 'Document enregistré !'
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_table_doc_8_fiche_id_client') {

        $id_document = $_POST['id_document'];
        $adresse = $_POST['adresse'];
        $id_fiscale_client = $_POST['id_fiscale_client'];
        $exercice_clos_le = si_funct($_POST['exercice_clos_le'], "", NULL, $_POST['exercice_clos_le']);
        $duree_en_mois = $_POST['duree_en_mois'];
        $exercice_compta_du = si_funct($_POST['exercice_compta_du'], "", NULL, $_POST['exercice_compta_du']);
        $exercice_compta_au = si_funct($_POST['exercice_compta_au'], "", NULL, $_POST['exercice_compta_au']);
        $date_arret_compta = si_funct($_POST['date_arret_compta'], "", NULL, $_POST['date_arret_compta']);
        $exercice_prev_clos_le = si_funct($_POST['exercice_prev_clos_le'], "", NULL, $_POST['exercice_prev_clos_le']);
        $duree_exercice_prev_en_mois = $_POST['duree_exercice_prev_en_mois'];
        $greffe = $_POST['greffe'];
        $num_registre_commerce = $_POST['num_registre_commerce'];
        $num_repertoire_entite = $_POST['num_repertoire_entite'];
        $num_caisse_sociale = $_POST['num_caisse_sociale'];
        $num_code_importateur = $_POST['num_code_importateur'];
        $code_activite_principale = $_POST['code_activite_principale'];
        $designation_entite = $_POST['designation_entite'];
        $sigle = $_POST['sigle'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $num_code = $_POST['num_code'];
        $code = $_POST['code'];
        $boite_postal = $_POST['boite_postal'];
        $ville = $_POST['ville'];
        $adresse_geo_complete = $_POST['adresse_geo_complete'];
        $designation_activite_principale = $_POST['designation_activite_principale'];
        $personne_a_contacter = $_POST['personne_a_contacter'];
        $professionnel_salarie_ou_cabinet = $_POST['professionnel_salarie_ou_cabinet'];
        // $visa_expert = $_POST['visa_expert'];
        $etats_financiers_approuves = $_POST['etats_financiers_approuves'];
        $forme_juridique_1 = $_POST['forme_juridique_1'];
        $forme_juridique_2 = $_POST['forme_juridique_2'];
        $regime_fiscal_1 = $_POST['regime_fiscal_1'];
        $regime_fiscal_2 = $_POST['regime_fiscal_2'];
        $pays_siege_social_1 = $_POST['pays_siege_social_1'];
        $pays_siege_social_2 = $_POST['pays_siege_social_2'];
        $nbr_etablissement_in = $_POST['nbr_etablissement_in'];
        $nbr_etablissement_out = $_POST['nbr_etablissement_out'];
        $prem_annee_exercice_in = $_POST['prem_annee_exercice_in'];
        $controle_entite = $_POST['controle_entite'];

        $duree_vie_societe = $_POST['duree_vie_societe'];
        $date_dissolution = si_funct($_POST['date_dissolution'], "", NULL, $_POST['date_dissolution']);
        $capital_social = $_POST['capital_social'];
        $siege_social = $_POST['siege_social'];
        $site_internet = $_POST['site_internet'];
        $nombre_de_salarie = $_POST['nombre_de_salarie'];
        $ca_3_derniers_exercices_n_1 = $_POST['ca_3_derniers_exercices_n_1'];
        $ca_3_derniers_exercices_n_2 = $_POST['ca_3_derniers_exercices_n_2'];
        $ca_3_derniers_exercices_n_3 = $_POST['ca_3_derniers_exercices_n_3'];

        $date_ouverture_dossier = si_funct($_POST['date_ouverture_dossier'], "", NULL, $_POST['date_ouverture_dossier']);
        $nom_cabinet_confrere = $_POST['nom_cabinet_confrere'];
        $dossier_herite_confrere = $_POST['dossier_herite_confrere'];


        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);
        $titre_document = $result['titre_document'];




        // update table document
        $update1 = update(
            'document',
            [
                'statut_document' => 'valide',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        // update table doc_8_fiche_id_client
        $update2 = update(
            'doc_8_fiche_id_client',
            [
                'adresse' => $adresse,
                'id_fiscale_client' => $id_fiscale_client,
                'exercice_clos_le' => $exercice_clos_le,
                'duree_en_mois' => $duree_en_mois,
                'exercice_compta_du' => $exercice_compta_du,
                'exercice_compta_au' => $exercice_compta_au,
                'date_arret_compta' => $date_arret_compta,
                'exercice_prev_clos_le' => $exercice_prev_clos_le,
                'duree_exercice_prev_en_mois' => $duree_exercice_prev_en_mois,
                'greffe' => $greffe,
                'num_registre_commerce' => $num_registre_commerce,
                'num_repertoire_entite' => $num_repertoire_entite,
                'num_caisse_sociale' => $num_caisse_sociale,
                'num_code_importateur' => $num_code_importateur,
                'code_activite_principale' => $code_activite_principale,
                'designation_entite' => $designation_entite,
                'sigle' => $sigle,
                'telephone' => $telephone,
                'email' => $email,
                'num_code' => $num_code,
                'code' => $code,
                'boite_postal' => $boite_postal,
                'ville' => $ville,
                'adresse_geo_complete' => $adresse_geo_complete,
                'designation_activite_principale' => $designation_activite_principale,
                'personne_a_contacter' => $personne_a_contacter,
                'professionnel_salarie_ou_cabinet' => $professionnel_salarie_ou_cabinet,
                // 'visa_expert' => $visa_expert,
                'etats_financiers_approuves' => $etats_financiers_approuves,
                'forme_juridique_1' => $forme_juridique_1,
                'forme_juridique_2' => $forme_juridique_2,
                'regime_fiscal_1' => $regime_fiscal_1,
                'regime_fiscal_2' => $regime_fiscal_2,
                'pays_siege_social_1' => $pays_siege_social_1,
                'pays_siege_social_2' => $pays_siege_social_2,
                'nbr_etablissement_in' => $nbr_etablissement_in,
                'nbr_etablissement_out' => $nbr_etablissement_out,
                'prem_annee_exercice_in' => $prem_annee_exercice_in,
                'controle_entite' => $controle_entite,
                'duree_vie_societe' => $duree_vie_societe,
                'date_dissolution' => $date_dissolution,
                'capital_social' => $capital_social,
                'siege_social' => $siege_social,
                'site_internet' => $site_internet,
                'nombre_de_salarie' => $nombre_de_salarie,
                'ca_3_derniers_exercices_n_1' => $ca_3_derniers_exercices_n_1,
                'ca_3_derniers_exercices_n_2' => $ca_3_derniers_exercices_n_2,
                'ca_3_derniers_exercices_n_3' => $ca_3_derniers_exercices_n_3,
                'date_ouverture_dossier' => $date_ouverture_dossier,
                'nom_cabinet_confrere' => $nom_cabinet_confrere,
                'dossier_herite_confrere' => $dossier_herite_confrere
            ],
            "id_document = $id_document",
            $db
        );

        // update table activite_client
        $update3 = false;
        if (isset($_POST['activite_client'])) {
            $activites_clients = $_POST['activite_client'];

            $delete = delete('activite_client', "id_client = $id_client", $db);
            foreach ($activites_clients as $activite_client) {
                $update3 = insert(
                    'activite_client',
                    [
                        'designation_activite_client' => $activite_client['designation_activite_client'],
                        'code_nomenclature_activite_client' => $activite_client['code_nomenclature_activite_client'],
                        'chiffre_affaires_ht_activite_client' => $activite_client['chiffre_affaires_ht_activite_client'],
                        'percent_activite_in_ca_activite_client' => $activite_client['percent_activite_in_ca_activite_client'],
                        'id_client' => $id_client
                    ],
                    $db
                );
            }
        } else {
            $update3 = true;
            $delete = delete('activite_client', "id_client = $id_client", $db);
        }

        // update table dirigeant_client
        $update4 = false;
        if (isset($_POST['dirigeant_client'])) {
            $dirigeants_clients = $_POST['dirigeant_client'];

            $delete = delete('dirigeant_client', "id_client = $id_client", $db);
            foreach ($dirigeants_clients as $dirigeant_client) {
                $update4 = insert(
                    'dirigeant_client',
                    [
                        'nom_dirigeant_client' => $dirigeant_client['nom_dirigeant_client'],
                        'prenom_dirigeant_client' => $dirigeant_client['prenom_dirigeant_client'],
                        'qualite_dirigeant_client' => $dirigeant_client['qualite_dirigeant_client'],
                        'id_fiscal_dirigeant_client' => $dirigeant_client['id_fiscal_dirigeant_client'],
                        'tel_dirigeant_client' => $dirigeant_client['tel_dirigeant_client'],
                        'mail_dirigeant_client' => $dirigeant_client['mail_dirigeant_client'],
                        'adresse_dirigeant_client' => $dirigeant_client['adresse_dirigeant_client'],
                        'id_client' => $id_client
                    ],
                    $db
                );
            }
        } else {
            $update4 = true;
            $delete = delete('dirigeant_client', "id_client = $id_client", $db);
        }

        // update table membre_conseil_client
        $update5 = false;
        if (isset($_POST['membre_conseil_client'])) {
            $membres_conseils_clients = $_POST['membre_conseil_client'];

            $delete = delete('membre_conseil_client', "id_client = $id_client", $db);
            foreach ($membres_conseils_clients as $membre_conseil_client) {
                $update5 = insert(
                    'membre_conseil_client',
                    [
                        'nom_membre_conseil_client' => $membre_conseil_client['nom_membre_conseil_client'],
                        'prenom_membre_conseil_client' => $membre_conseil_client['prenom_membre_conseil_client'],
                        'qualite_membre_conseil_client' => $membre_conseil_client['qualite_membre_conseil_client'],
                        'tel_membre_conseil_client' => $membre_conseil_client['tel_membre_conseil_client'],
                        'mail_membre_conseil_client' => $membre_conseil_client['mail_membre_conseil_client'],
                        'adresse_membre_conseil_client' => $membre_conseil_client['adresse_membre_conseil_client'],
                        'fonction_membre_conseil_client' => $membre_conseil_client['fonction_membre_conseil_client'],
                        'id_client' => $id_client
                    ],
                    $db
                );
            }
        } else {
            $update5 = true;
            $delete = delete('membre_conseil_client', "id_client = $id_client", $db);
        }

        $update6 = update_contenu_document_table_doc_8_fiche_id_client($id_document, $db);

        if ($update1 && $update2 && $update3 && $update4 && $update5 && $update6) {
            $output = [
                'success' => true,
                'message' => "La fiche d'identification de <b>$nom_client</b> à été mise à jour !"
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_table_doc_3_accept_mission') {

        $id_document = $_POST['id_document'];
        $quiz1 = $_POST['quiz1'] ?? NULL;
        $observ1 = $_POST['observ1'];
        $quiz2 = $_POST['quiz2'] ?? NULL;
        $quiz3 = $_POST['quiz3'] ?? NULL;
        $quiz4 = $_POST['quiz4'] ?? NULL;
        $quiz5 = $_POST['quiz5'] ?? NULL;
        $quiz6 = $_POST['quiz6'] ?? NULL;
        $quiz7 = $_POST['quiz7'] ?? NULL;
        $quiz8 = $_POST['quiz8'] ?? NULL;
        $quiz9 = $_POST['quiz9'] ?? NULL;
        $quiz10 = $_POST['quiz10'] ?? NULL;
        $observ10 = $_POST['observ10'];
        $quiz11 = $_POST['quiz11'] ?? NULL;
        $observ11 = $_POST['observ11'];
        $quiz12 = $_POST['quiz12'] ?? NULL;
        $observ12 = $_POST['observ12'];
        $quiz13 = $_POST['quiz13'] ?? NULL;
        $observ13 = $_POST['observ13'];
        $quiz14 = $_POST['quiz14'] ?? NULL;
        $observ14 = $_POST['observ14'];
        $quiz15 = $_POST['quiz15'] ?? NULL;
        $observ15 = $_POST['observ15'];
        $quiz16 = $_POST['quiz16'] ?? NULL;
        $observ16 = $_POST['observ16'];
        $quiz17 = $_POST['quiz17'] ?? NULL;
        $observ17 = $_POST['observ17'];
        $quiz18 = $_POST['quiz18'] ?? NULL;
        $observ18 = $_POST['observ18'];
        $quiz19 = $_POST['quiz19'] ?? NULL;
        $observ19 = $_POST['observ19'];
        $quiz20 = $_POST['quiz20'] ?? NULL;
        $observ20 = $_POST['observ20'];
        $accept_mission = $_POST['accept_mission'] ?? NULL;
        // $signature_responsable = $_POST['signature_responsable'];
        $observation = $_POST['observation'];


        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);
        $titre_document = $result['titre_document'];

        // update table document
        $update1 = update(
            'document',
            [
                'statut_document' => 'valide',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        // update table doc_3_accept_mission
        $update2 = update(
            'doc_3_accept_mission',
            [
                'quiz1' => $quiz1,
                'observ1' => $observ1,
                'quiz2' => $quiz2,
                'quiz3' => $quiz3,
                'quiz4' => $quiz4,
                'quiz5' => $quiz5,
                'quiz6' => $quiz6,
                'quiz7' => $quiz7,
                'quiz8' => $quiz8,
                'quiz9' => $quiz9,
                'quiz10' => $quiz10,
                'observ10' => $observ10,
                'quiz11' => $quiz11,
                'observ11' => $observ11,
                'quiz12' => $quiz12,
                'observ12' => $observ12,
                'quiz13' => $quiz13,
                'observ13' => $observ13,
                'quiz14' => $quiz14,
                'observ14' => $observ14,
                'quiz15' => $quiz15,
                'observ15' => $observ15,
                'quiz16' => $quiz16,
                'observ16' => $observ16,
                'quiz17' => $quiz17,
                'observ17' => $observ17,
                'quiz18' => $quiz18,
                'observ18' => $observ18,
                'quiz19' => $quiz19,
                'observ19' => $observ19,
                'quiz20' => $quiz20,
                'observ20' => $observ20,
                'accept_mission' => $accept_mission,
                // 'signature_responsable' => $signature_responsable,
                'observation' => $observation,
            ],
            "id_document = $id_document",
            $db
        );


        $update3 = update_contenu_document_table_doc_3_accept_mission($id_document, $db);

        if ($update1 && $update2 && $update3) {
            $output = [
                'success' => true,
                'message' => "Le questionnaire à été mise à jour !"
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_table_doc_19_quiz_lcb') {

        $id_document = $_POST['id_document'];
        $quiz1 = $_POST['quiz1'] ?? NULL;
        $impact1 = $_POST['impact1'] ?? NULL;
        $observ1 = $_POST['observ1'];
        $quiz2 = $_POST['quiz2'] ?? NULL;
        $impact2 = $_POST['impact2'] ?? NULL;
        $observ2 = $_POST['observ2'];
        $quiz3 = $_POST['quiz3'] ?? NULL;
        $impact3 = $_POST['impact3'] ?? NULL;
        $observ3 = $_POST['observ3'];
        $quiz4 = $_POST['quiz4'] ?? NULL;
        $impact4 = $_POST['impact4'] ?? NULL;
        $observ4 = $_POST['observ4'];
        $quiz5 = $_POST['quiz5'] ?? NULL;
        $impact5 = $_POST['impact5'] ?? NULL;
        $observ5 = $_POST['observ5'];
        $quiz6 = $_POST['quiz6'] ?? NULL;
        $impact6 = $_POST['impact6'] ?? NULL;
        $observ6 = $_POST['observ6'];
        $quiz7 = $_POST['quiz7'] ?? NULL;
        $impact7 = $_POST['impact7'] ?? NULL;
        $observ7 = $_POST['observ7'];
        $quiz8 = $_POST['quiz8'] ?? NULL;
        $impact8 = $_POST['impact8'] ?? NULL;
        $observ8 = $_POST['observ8'];
        $quiz9 = $_POST['quiz9'] ?? NULL;
        $impact9 = $_POST['impact9'] ?? NULL;
        $observ9 = $_POST['observ9'];
        $quiz10 = $_POST['quiz10'] ?? NULL;
        $impact10 = $_POST['impact10'] ?? NULL;
        $observ10 = $_POST['observ10'];
        $quiz11 = $_POST['quiz11'] ?? NULL;
        $impact11 = $_POST['impact11'] ?? NULL;
        $observ11 = $_POST['observ11'];
        $quiz12 = $_POST['quiz12'] ?? NULL;
        $impact12 = $_POST['impact12'] ?? NULL;
        $observ12 = $_POST['observ12'];
        $quiz13 = $_POST['quiz13'] ?? NULL;
        $impact13 = $_POST['impact13'] ?? NULL;
        $observ13 = $_POST['observ13'];
        $quiz14 = $_POST['quiz14'] ?? NULL;
        $impact14 = $_POST['impact14'] ?? NULL;
        $observ14 = $_POST['observ14'];
        $quiz15 = $_POST['quiz15'] ?? NULL;
        $impact15 = $_POST['impact15'] ?? NULL;
        $observ15 = $_POST['observ15'];
        $quiz16 = $_POST['quiz16'] ?? NULL;
        $impact16 = $_POST['impact16'] ?? NULL;
        $observ16 = $_POST['observ16'];
        $quiz17 = $_POST['quiz17'] ?? NULL;
        $impact17 = $_POST['impact17'] ?? NULL;
        $observ17 = $_POST['observ17'];
        $quiz18 = $_POST['quiz18'] ?? NULL;
        $impact18 = $_POST['impact18'] ?? NULL;
        $observ18 = $_POST['observ18'];
        $quiz19 = $_POST['quiz19'] ?? NULL;
        $impact19 = $_POST['impact19'] ?? NULL;
        $observ19 = $_POST['observ19'];
        $quiz20 = $_POST['quiz20'] ?? NULL;
        $impact20 = $_POST['impact20'] ?? NULL;
        $observ20 = $_POST['observ20'];
        $quiz21 = $_POST['quiz21'] ?? NULL;
        $impact21 = $_POST['impact21'] ?? NULL;
        $observ21 = $_POST['observ21'];
        $conclusion = $_POST['conclusion'];


        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);
        $titre_document = $result['titre_document'];

        // update table document
        $update1 = update(
            'document',
            [
                'statut_document' => 'valide',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        // update table doc_19_quiz_lcb
        $update2 = update(
            'doc_19_quiz_lcb',
            [
                'quiz1' => $quiz1,
                'impact1' => $impact1,
                'observ1' => $observ1,
                'quiz2' => $quiz2,
                'impact2' => $impact2,
                'observ2' => $observ2,
                'quiz3' => $quiz3,
                'impact3' => $impact3,
                'observ3' => $observ3,
                'quiz4' => $quiz4,
                'impact4' => $impact4,
                'observ4' => $observ4,
                'quiz5' => $quiz5,
                'impact5' => $impact5,
                'observ5' => $observ5,
                'quiz6' => $quiz6,
                'impact6' => $impact6,
                'observ6' => $observ6,
                'quiz7' => $quiz7,
                'impact7' => $impact7,
                'observ7' => $observ7,
                'quiz8' => $quiz8,
                'impact8' => $impact8,
                'observ8' => $observ8,
                'quiz9' => $quiz9,
                'impact9' => $impact9,
                'observ9' => $observ9,
                'quiz10' => $quiz10,
                'impact10' => $impact10,
                'observ10' => $observ10,
                'quiz11' => $quiz11,
                'impact11' => $impact11,
                'observ11' => $observ11,
                'quiz12' => $quiz12,
                'impact12' => $impact12,
                'observ12' => $observ12,
                'quiz13' => $quiz13,
                'impact13' => $impact13,
                'observ13' => $observ13,
                'quiz14' => $quiz14,
                'impact14' => $impact14,
                'observ14' => $observ14,
                'quiz15' => $quiz15,
                'impact15' => $impact15,
                'observ15' => $observ15,
                'quiz16' => $quiz16,
                'impact16' => $impact16,
                'observ16' => $observ16,
                'quiz17' => $quiz17,
                'impact17' => $impact17,
                'observ17' => $observ17,
                'quiz18' => $quiz18,
                'impact18' => $impact18,
                'observ18' => $observ18,
                'quiz19' => $quiz19,
                'impact19' => $impact19,
                'observ19' => $observ19,
                'quiz20' => $quiz20,
                'impact20' => $impact20,
                'observ20' => $observ20,
                'quiz21' => $quiz21,
                'impact21' => $impact21,
                'observ21' => $observ21,
                'conclusion' => $conclusion,
            ],
            "id_document = $id_document",
            $db
        );


        $update3 = update_contenu_document_table_doc_19_quiz_lcb($id_document, $db);

        if ($update1 && $update2 && $update3) {
            $output = [
                'success' => true,
                'message' => "Le questionnaire à été mise à jour !"
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_table_doc_6_info_lettre_mission') {

        $id_document = $_POST['id_document'];
        $duree = si_funct($_POST['duree'], "", NULL, $_POST['duree']);
        $renouvellement = si_funct($_POST['renouvellement'], "", NULL, $_POST['renouvellement']);
        $date_debut_duree = si_funct($_POST['date_debut_duree'], "", NULL, $_POST['date_debut_duree']);
        $date_debut_renouvellement = si_funct($_POST['date_debut_renouvellement'], "", NULL, $_POST['date_debut_renouvellement']);
        $frais_ouverture = si_funct($_POST['frais_ouverture'], "", NULL, $_POST['frais_ouverture']);
        $montant_honoraires_ht = si_funct($_POST['montant_honoraires_ht'], "", NULL, $_POST['montant_honoraires_ht']);
        $montant_honoraires_ttc = si_funct($_POST['montant_honoraires_ttc'], "", NULL, $_POST['montant_honoraires_ttc']);

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);
        $titre_document = $result['titre_document'];

        // update table document
        $update1 = update(
            'document',
            [
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        // update table doc_6_info_lettre_mission
        $update2 = update(
            'doc_6_info_lettre_mission',
            [
                'duree' => $duree,
                'renouvellement' => $renouvellement,
                'date_debut_duree' => $date_debut_duree,
                'date_debut_renouvellement' => $date_debut_renouvellement,
                'frais_ouverture' => $frais_ouverture,
                'montant_honoraires_ht' => $montant_honoraires_ht,
                'montant_honoraires_ttc' => $montant_honoraires_ttc,
            ],
            "id_document = $id_document",
            $db
        );

        // update table mission_client
        $update3 = false;
        $delete = false;
        if (isset($_POST['mission'])) {

            $mission = $_POST['mission'];
            $delete = delete('mission_client', "id_client = $id_client", $db);

            foreach ($mission as $mission_item) {

                $update3 = insert(
                    'mission_client',
                    [
                        'nature_mission' => $mission_item['nature_mission'],
                        'sous_mission' => 'non',
                        'id_client' => $id_client
                    ],
                    $db
                );

                // last insert id
                $id_mission = $db->lastInsertId();

                if (isset($mission_item['sous_mission'])) {

                    $sous_mission = $mission_item['sous_mission'];

                    foreach ($sous_mission as $sous_mission_item) {

                        $update3 = insert(
                            'mission_client',
                            [
                                'nature_mission' => $sous_mission_item['nature_sous_mission'],
                                'sous_mission' => 'oui',
                                'id_parent_mission' => $id_mission,
                                'id_client' => $id_client,
                            ],
                            $db
                        );
                    }
                }
            }
        } else {
            $update3 = true;
            $delete = delete('mission_client', "id_client = $id_client", $db);
        }

        if ($update1 && $update2 && $update3 && $delete) {
            $output = [
                'success' => true,
                'message' => "La lettre de mission de <b>$nom_client</b> à été mise à jour !"
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }
    if ($_POST['action'] == 'edit_info_relance') {

        $id_client = $_SESSION['id_view_client'];
        $nom_client = find_info_client('nom_utilisateur', $id_client, $db);


        if (isset($_POST['relance_auto_client'])) {
            $update = update(
                'client',
                [
                    'relance_auto_client' => 'oui',
                    'nom_responsable_client' => $_POST['nom_responsable_client'],
                    'prenom_responsable_client' => $_POST['prenom_responsable_client'],
                    'civilite_responsable_client' => $_POST['civilite_responsable_client'],
                    'role_responsable_client' => $_POST['role_responsable_client'],
                ],
                "id_client = $id_client",
                $db
            );
        } else {
            $update = update(
                'client',
                [
                    'relance_auto_client' => 'non',
                ],
                "id_client = $id_client",
                $db
            );
        }

        if ($update) {
            $output = [
                'success' => true,
                'message' => "Les informations de relance de <b>$nom_client</b> à été mise à jour !"
            ];
        } else {
            $output = [
                'success' => false,
                'message' => 'Une erreur s\'est produite !'
            ];
        }
    }

    if ($_POST['action'] == 'exporter_doc') {
        
        if (isset($_POST['header_export'])) {
            $header_export = 'oui';
        } else {
            $header_export = 'non';
        }

        if (isset($_POST['footer_export'])) {
            $footer_export = 'oui';
        } else {
            $footer_export = 'non';
        }

        if (isset($_POST['bg_export'])) {
            $bg_export = 'oui';
        } else {
            $bg_export = 'non';
        }

        $id_document = $_POST['id_document'];
        $mode_export = $_POST['mode_export'];

        $redirect_url = "roll/client/dossiers/docs/export/index.php?id_document={$id_document}&header_export={$header_export}&footer_export={$footer_export}&bg_export={$bg_export}&mode_export={$mode_export}";
        
        $output = [
            'success' => true,
            'message' => 'ok',
            'redirect_url' => $redirect_url
        ];

    }

    if ($_POST['action'] == 'retirer_dossier') {

        $id_collaborateur = $_POST['id_collaborateur'];
        $id_client = $_POST['id_client'];

        $update1 = update(
            'assoc_client_collabo',
            [
                'statut_assoc_client_collabo' => 'inactif',
                'date_fin_assoc_client_collabo' => date('Y-m-d H:i:s'),
                'updated_at_assoc_client_collabo' => date('Y-m-d H:i:s')
            ],
            "id_collaborateur = $id_collaborateur AND role_assoc_client_collabo = 'cm' AND statut_assoc_client_collabo = 'actif' AND id_client = $id_client",
            $db
        );

        $update2 = update(
            'client',
            [
                'prise_en_charge_client' => 'non',
            ],
            "id_client = $id_client",
            $db
        );

        if ($update1 && $update2) {
            $output = array(
                'success' => true,
                'message' => 'Dossier retiré au collaborateur !',
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !',
            );
        }
    }
    if ($_POST['action'] == 'delete_doc') {

        $id_document = $_POST['id_document'];

        $update = update(
            'document',
            [
                'statut_document' => 'supprime',
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        if ($update) {
            $output = array(
                'success' => true,
                'id_document' => $id_document,
                'message' => 'Document supprimé !',
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Une erreur s\'est produite !',
            );
        }
    }
    if ($_POST['action'] == 'delete_doc_file_upload') {

        $id_document = $_POST['id_document'];
        $file_path = $_POST['file_path'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];

        $update = update(
            $table_document,
            [
                'src_temp_document' => '',
            ],
            "id_document = $id_document",
            $db
        );

        if (is_file($file_path)) {
            unlink($file_path);
        }
    }
    if ($_POST['action'] == 'delete_doc_scan_upload') {

        $id_document = $_POST['id_document'];
        $file_path = $_POST['file_path'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $update = update(
            'document',
            [
                'src_scan_temp_document' => '',
            ],
            "id_document = $id_document",
            $db
        );

        if (is_file($file_path)) {
            unlink($file_path);
        }
    }
}

if (isset($_FILES['file'])) {

    if ($_GET['action'] == 'doc_file_upload') {

        $id_document = $_GET['id_document'];
        $titre_document = $_GET['titre_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);

        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/docs/' . $matricule_client . '/';

        $uuid = Uuid::uuid1();
        $uniq_str = $uuid->toString();
        $infoPath = pathinfo($_FILES['file']['name']);

        $targetFile =  $targetPath . $titre_document . '_' .  $uniq_str . '.' . $infoPath['extension'];
        move_uploaded_file($tempFile, $targetFile);

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $table_document = $result['table_document'];
        $update = update(
            $table_document,
            [
                'src_temp_document' => $titre_document . '_' .  $uniq_str . '.' . $infoPath['extension'],
            ],
            "id_document = $id_document",
            $db
        );
    }

    if ($_GET['action'] == 'doc_scan_upload') {

        $id_document = $_GET['id_document'];
        $titre_document = $_GET['titre_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $id_client = $result['id_client'];
        $matricule_client = find_info_client('matricule_client', $id_client, $db);

        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/ged/assets/docs/' . $matricule_client . '/';

        $uuid = Uuid::uuid1();
        $uniq_str = $uuid->toString();
        $infoPath = pathinfo($_FILES['file']['name']);

        $targetFile =  $targetPath . 'SCAN_' .  $titre_document . '_' .  $uniq_str . '.' . $infoPath['extension'];
        move_uploaded_file($tempFile, $targetFile);

        $update = update(
            'document',
            [
                'src_scan_temp_document' =>     'SCAN_' . $titre_document . '_' .  $uniq_str . '.' . $infoPath['extension'],
            ],
            "id_document = $id_document",
            $db
        );
    }

    $output = $targetFile;
    echo $output;
    die;
}

echo json_encode($output);
