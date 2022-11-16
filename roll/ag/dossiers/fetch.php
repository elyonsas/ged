<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

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
                    <a data-sorting="{$nom_client}" href="roll/ag/view_redirect/?action=view_client&id_view_client={$id_client}" 
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
                                
                                <a href="roll/ag/view_redirect/?action=view_client&id_view_client={$id_client}"
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

                                <a href="roll/ag/view_redirect/?action=view_client&id_view_client={$id_client}"
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

    if ($_POST['datatable'] == 'documents_juridico_admin') {

        $output = array();
        $query = '';

        $query .= "SELECT * FROM document WHERE id_client = {$_SESSION['id_view_client']} ORDER BY titre_document ASC";


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
            $titre_document = $row['titre_document'];
            $type_document = $row['type_document'];
            $table_document = $row['table_document'];
            $max_titre_document = (strlen($titre_document) > 55) ? substr($titre_document, 0, 55) . '...' : $titre_document;
            $derniere_modif = date('d/m/Y H:i:s', strtotime($row['updated_at_document']));
            $statut_document = $row['statut_document'];

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
                if ($type_document == 'generate') {

                    $sub_array[] = <<<HTML
                        <div class="preview_doc_generate d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_generate_modal">
                            <span style="cursor: pointer;" data-sorting="{$titre_document}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                            class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                        </div>
                    HTML;
                } else if ($type_document == 'write') {

                    $sub_array[] = <<<HTML
                        <div class="preview_doc_write d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_write_modal">
                            <span style="cursor: pointer;" data-sorting="{$titre_document}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                            class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                        </div>
                    HTML;
                } else if ($type_document == 'file') {

                    $sub_array[] = <<<HTML
                        <div class="preview_doc_file d-flex flex-column justify-content-center" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal">
                            <span style="cursor: pointer;" data-sorting="{$titre_document}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                            class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</span>
                        </div>
                    HTML;
                }
            } else {

                $sub_array[] = <<<HTML
                    <div style="cursor: not-allowed;" class="d-flex flex-column justify-content-center" data-id_document="{$id_document}">
                        <span data-sorting="{$titre_document}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
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


            // Action
            switch ($statut_document) {
                case 'valide':
                    if ($type_document == 'generate') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_generate_modal" 
                                    class="preview_doc_generate btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="bi bi-eye-fill fs-3"></i>
                                    </a>
                                    <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                    </a> -->
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="edit_form_doc_generate menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_form_doc_generate_table_doc_fiche_id_client_modal" 
                                            data-id_document="{$id_document}">Modifier le formulaire</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="edit_doc_generate menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_generate_modal" 
                                            data-id_document="{$id_document}">Modifier le document</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    } else if ($type_document == 'write') {
                        if ($table_document != 'document_write') {
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_write_modal" 
                                        class="preview_doc_write btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="bi bi-eye-fill fs-3"></i>
                                        </a>
                                        <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                        </a> -->
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots fs-3"></i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="edit_doc_write menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_write_modal" data-id_document="{$id_document}">Modifier le document</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="supprimer_doc_autre menu-link px-3 text-hover-danger" data-id_document="{$id_document}">Supprimer</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                </td>

                            HTML;
                        } else {
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_write_modal" 
                                        class="preview_doc_write btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="bi bi-eye-fill fs-3"></i>
                                        </a>
                                        <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                        </a> -->
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots fs-3"></i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="edit_doc_write menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_write_modal" data-id_document="{$id_document}">Modifier le document</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                </td>

                            HTML;
                        }
                    } else if ($type_document == 'file') {
                        if ($table_document != 'document_file') {
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal" 
                                        class="preview_doc_file btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="bi bi-eye-fill fs-3"></i>
                                        </a>
                                        <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                        </a> -->
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots fs-3"></i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="edit_doc_file menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_file_modal" data-id_document="{$id_document}">Modifier le document</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="supprimer_doc_autre menu-link px-3" data-id_document="{$id_document}">Supprimer</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                </td>

                            HTML;
                        } else {
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_doc_file_modal" 
                                        class="preview_doc_file btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="Aperçu" class="bi bi-eye-fill fs-3"></i>
                                        </a>
                                        <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                        </a> -->
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots fs-3"></i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="edit_doc_file menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_file_modal" data-id_document="{$id_document}">Modifier le document</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                </td>

                            HTML;
                        }
                    }
                    break;
                case 'invalide':
                    if ($type_document == 'generate') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <span style="cursor: not-allowed;"
                                        class="btn btn-icon btn-bg-light btn-sm me-1">
                                        <i class="bi bi-eye-fill fs-3"></i>
                                    </span>
                                    <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                    </a> -->
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="remplir_doc_generate menu-link px-3" data-id_document="{$id_document}">Remplir le formulaire</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    } else if ($type_document == 'write') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <span style="cursor: not-allowed;"
                                        class="btn btn-icon btn-bg-light btn-sm me-1">
                                        <i class="bi bi-eye-fill fs-3"></i>
                                    </span>
                                    <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                    </a> -->
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="rediger_doc_write menu-link px-3" data-id_document="{$id_document}">Rédiger le document</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    } else if ($type_document == 'file') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <span style="cursor: not-allowed;"
                                        class="btn btn-icon btn-bg-light btn-sm me-1">
                                        <i class="bi bi-eye-fill fs-3"></i>
                                    </span>
                                    <!-- <a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="bi bi-clipboard2-plus-fill fs-3"></i>
                                    </a> -->
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="view_detail_document menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_document_modal" data-id_document="{$id_document}">Détails</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="importer_doc_file menu-link px-3" data-id_document="{$id_document}">Importer</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    }
                    break;
            }

            $sub_array[] = $action;

            $data[] = $sub_array;
        }


        $output = array(
            "data" => $data
        );
    }
}

if (isset($_POST['action'])) {

    // espace datatables
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
    if ($_POST['action'] == 'fetch_page_client') {
        $id_client = $_SESSION['id_view_client'];

        // Récupérer les informations de la base de données
        $query = "SELECT * FROM utilisateur, compte, client WHERE utilisateur.id_utilisateur = compte.id_utilisateur
        AND utilisateur.id_utilisateur = client.id_utilisateur AND id_client = $id_client ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

            $id_utilisateur = $row['id_utilisateur'];
            $avatar_client = <<<HTML
                <img src="assets/media/avatars/{$row['avatar_utilisateur']}" alt="image">
            HTML;
            $nom_client = $row['nom_utilisateur'];
            $email_client = $row['email_utilisateur'];
            $matricule_client = $row['matricule_client'];
            $date_naiss_client = si_funct1($row['date_naiss_utilisateur'], date('d-m-Y', strtotime($row['date_naiss_utilisateur'])), '--');
            $tel_client = $row['tel_utilisateur'];
            $adresse_client = $row['adresse_utilisateur'];

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


            $output = array(
                'avatar_client' => $avatar_client,
                'nom_client' => $nom_client,
                'email_client' => $email_client,
                'matricule_client' => $matricule_client,
                'date_naiss_client' => $date_naiss_client,
                'tel_client' => $tel_client,
                'adresse_client' => $adresse_client,
                'statut_client' => $statut_client_html,
                'prise_en_charge_client' => $prise_en_charge_client,
                'action_client' => $action_client,
            );
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

    if ($_POST['action'] == 'view_detail_document') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = array();

        foreach ($result as $row) {

            $aspect_document = $row['aspect_document'];
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


            $code_document = $row['code_document'];
            $titre_document = $row['titre_document'];

            $statut_document = $row['statut_document'];
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

            $created_by_document = find_info_utilisateur('prenom_utilisateur', $row['created_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $row['created_by_document'], $db);
            $created_at_document = si_funct1($row['created_at_document'], date('d/m/Y H:i:s', strtotime($row['created_at_document'])), '');
            $updated_by_document = find_info_utilisateur('prenom_utilisateur', $row['updated_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $row['updated_by_document'], $db);
            $updated_at_document = si_funct1($row['updated_at_document'], date('d/m/Y H:i:s', strtotime($row['updated_at_document'])), '');

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

        $table_document = $result['table_document'];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
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
                'contenu_text_document' => $contenu_text_document
            ],
            "id_document = $id_document",
            $db
        );

        $update2 = update(
            'document',
            [
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
                'message' => 'Une s\'est produite !'
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
    if ($_POST['action'] == 'edit_table_doc_fiche_id_client') {

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
                'updated_at_document' => date('Y-m-d H:i:s'),
                'updated_by_document' => $_SESSION['id_utilisateur']
            ],
            "id_document = $id_document",
            $db
        );

        // update table doc_fiche_id_client
        $update2 = update(
            'doc_fiche_id_client',
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
        if(isset($_POST['activite_client'])){
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
        }else{
            $update3 = true;
            $delete = delete('activite_client', "id_client = $id_client", $db);
        }

        // update table dirigeant_client
        $update4 = false;
        if(isset($_POST['dirigeant_client'])){
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
        }else{
            $update4 = true;
            $delete = delete('dirigeant_client', "id_client = $id_client", $db);
        }

        // update table membre_conseil_client
        $update5 = false;
        if(isset($_POST['membre_conseil_client'])){
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
        }else{
            $update5 = true;
            $delete = delete('membre_conseil_client', "id_client = $id_client", $db);
        }
        
        $update6 = update_contenu_document_table_doc_fiche_id_client($id_document, $db);

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

    if ($_POST['action'] == 'delete_doc_file') {

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
}

if (isset($_FILES['file'])) {

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

    $output = $targetFile;
    echo $output;
    die;
}

echo json_encode($output);
