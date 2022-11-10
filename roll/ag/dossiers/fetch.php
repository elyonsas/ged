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
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
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
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
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
            $sub_array[] = <<<HTML
                <div class="d-flex flex-column justify-content-center">
                    <a data-sorting="{$titre_document}" href="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="{$titre_document}"
                    class="fs-6 text-gray-800 text-hover-primary">$max_titre_document</a>
                </div>
            HTML;

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
                                    
                                    <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_modal" 
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
                                            <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="modifier_form_doc_generate menu-link px-3" data-id_document="{$id_document}">Modifier le formulaire</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="modifier_doc_generate menu-link px-3" data-id_document="{$id_document}">Modifier le document</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    }else if ($type_document == 'write') {
                        if ($table_document != 'document_write'){
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_modal" 
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
                                                <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="modifier_doc_autre menu-link px-3" data-id_document="{$id_document}">Modifier le document</a>
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
                        }else{
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_modal" 
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
                                                <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="modifier_doc_write menu-link px-3" data-id_document="{$id_document}">Modifier le document</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                </td>

                            HTML;
                        }
                    }else if ($type_document == 'file') {
                        if ($table_document != 'document_file'){
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_modal" 
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
                                                <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="modifier_doc_autre menu-link px-3" data-id_document="{$id_document}">Modifier le document</a>
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
                        }else{
                            $action = <<<HTML

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        
                                        <a href="" data-id_document="{$id_document}" data-bs-toggle="modal" data-bs-target="#preview_modal" 
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
                                                <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!-- begin::Menu item -->
                                            <div class="menu-item px-3">
                                                <a href="" class="modifier_doc_file menu-link px-3" data-id_document="{$id_document}">Modifier le document</a>
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
                                    
                                    <span style="cursor: not-allowed;" tabindex="-1" aria-disabled="disabled" disabled
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
                                            <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
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
                    }else if ($type_document == 'write') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <span style="cursor: not-allowed;" tabindex="-1" aria-disabled="disabled" disabled
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
                                            <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
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
                    }else if ($type_document == 'file') {
                        $action = <<<HTML

                            <td>
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    
                                    <span style="cursor: not-allowed;" tabindex="-1" aria-disabled="disabled" disabled
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
                                            <a href="" class="view_details menu-link px-3" data-id_document="{$id_document}">Détails</a>
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
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
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
                                        <a href="" class="detail_dossier menu-link px-3" data-bs-toggle="modal" data-bs-target="#detail_dossier_modal" data-id_client="{$id_client}">Détails</a>
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

    if ($_POST['action'] == 'detail_dossier') {

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

        $id_client = $result['id_client'];
        $matricule_client = 'DEC-12007';
        $table_document = $result['table_document'];
        $output = [
            'titre_document' => $result['titre_document'],
            'contenu_document' => '',
        ];

        $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $adresse = $result['adresse'];
        $id_fiscale_client = $result['id_fiscale_client'];
        $exercice_clo_le = si_funct1($result['exercice_clo_le'], date('d/m/Y', strtotime($result['exercice_clo_le'])), '');
        $duree_en_mois = $result['duree_en_mois'];
        $exercice_compta_du = si_funct1($result['exercice_compta_du'], date('d/m/Y', strtotime($result['exercice_compta_du'])), '');
        $exercice_compta_au = si_funct1($result['exercice_compta_au'], date('d/m/Y', strtotime($result['exercice_compta_au'])), '');
        $date_arret_compta = si_funct1($result['date_arret_compta'], date('d/m/Y', strtotime($result['date_arret_compta'])), '');
        $exercice_prev_clos_le = $result['exercice_prev_clos_le'];
        $duree_exercice_prev_en_mois = $result['duree_exercice_prev_en_mois'];
        $greffe = $result['greffe'];
        $num_registre_commerce = $result['num_registre_commerce'];
        $num_repertoire_entite = $result['num_repertoire_entite'];
        $num_caisse_sociale = $result['num_caisse_sociale'];
        $num_code_importateur = $result['num_code_importateur'];
        $code_activite_principale = $result['code_activite_principale'];
        $designation_entite = $result['designation_entite'];
        $sigle = $result['sigle'];
        $telephone = $result['telephone'];
        $email = $result['email'];
        $code = $result['code'];
        $num_code = $result['num_code'];
        $boite_postal = $result['boite_postal'];
        $ville = $result['ville'];
        $adresse_geo_complete = $result['adresse_geo_complete'];
        $designation_activite_principale = $result['designation_activite_principale'];
        $personne_a_contacter = $result['personne_a_contacter'];
        $professionnel_salarie_ou_cabinet = $result['professionnel_salarie_ou_cabinet'];
        $visa_expert = 'CABINET ELYON';
        $etats_financiers_approuves = $result['etats_financiers_approuves'];
        if($etats_financiers_approuves == 'oui'){
            $etats_financiers_approuves_oui = 'X';
            $etats_financiers_approuves_non = '';
        }else{
            $etats_financiers_approuves_oui = '';
            $etats_financiers_approuves_non = 'X';
        }


        $contenu_document = <<<HTML
            <table dir="ltr"
                style="transform: scale(0.9); transform-origin: top left; table-layout: fixed; font-size: 11pt; font-family: Calibri; width: 0px; border-collapse: collapse; border-style: none;"
                border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="13">
                    <col width="39">
                    <col width="6">
                    <col width="6">
                    <col width="6">
                    <col width="6">
                    <col width="29">
                    <col width="29">
                    <col width="18">
                    <col width="57">
                    <col width="29">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="51">
                    <col width="9">
                    <col width="18">
                    <col width="18">
                    <col width="18">
                    <col width="9">
                    <col width="56">
                    <col width="19">
                    <col width="18">
                    <col width="18">
                    <col width="19">
                    <col width="21">
                    <col width="45">
                    <col width="15">
                    <col width="18">
                    <col width="8">
                    <col width="7">
                    <col width="42">
                    <col width="8">
                    <col width="8">
                    <col width="23">
                    <col width="23">
                    <col width="23">
                    <col width="47">
                    <col width="46">
                    <col width="29">
                    <col width="57">
                    <col width="59">
                    <col width="18">
                </colgroup>
                <tbody>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;"
                            colspan="43" rowspan="1"
                            >
                            DOC N&deg;8 FICHE D&rsquo;INDENTIFICATION CLIENT</td>
                    </tr>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 16pt; font-weight: bold; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    </tr>
                    <tr style="height: 22px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 14pt; font-weight: bold;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 481px; left: 3px;">
                                <div style="float: left;">Sous-doc N&deg;8-1 : Informations g&eacute;n&eacute;rales sur le client
                                </div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="32" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="43" rowspan="1"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;#,##0&quot;,&quot;3&quot;:1}"
                            >
                            N&deg; MATRICULE DU CLIENT AU CABINET : $matricule_client</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="6" rowspan="1" >
                            Adresse :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="13" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$adresse</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;"> 
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="9" rowspan="1"
                            >N&deg;
                            d'identification fiscale :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="10" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$id_fiscale_client</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:2,&quot;2&quot;:&quot;0&quot;,&quot;3&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1"
                            >Exercice clos le :
                        </td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="9" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_clo_le</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="3" rowspan="1"
                            >Dur&eacute;e
                            (en mois) :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$duree_en_mois</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:5,&quot;2&quot;:&quot;D/M/YYYY&quot;,&quot;3&quot;:1}">&nbsp;
                        </td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZA</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="8" rowspan="1"
                            >EXERCICE COMPTABLE
                            :</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="3" rowspan="1" >DU:</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px dashed rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_compta_du</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="4" rowspan="1" >AU :</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px dashed rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_compta_au</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZB</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="16" rowspan="1"
                            >
                            DATE D'ARRETE EFFECTIF DES COMPTES :</td>
                        <td style="border-left: 1px solid rgb(0, 0, 0); border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$date_arret_compta</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZC</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="16" rowspan="1"
                            >EXERCICE
                            PRECEDENT CLOS LE :</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$exercice_prev_clos_le</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="15" rowspan="1"
                            >DUREE
                            EXERCICE PRECEDENT EN MOIS:</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$duree_exercice_prev_en_mois</div></td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZD</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$greffe</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_registre_commerce</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="13" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_repertoire_entite</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="5" rowspan="1" >Greffe
                        </td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1"
                            >N&deg;
                            Registre du commerce</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="13" rowspan="1"
                            >
                            N&deg; R&eacute;pertoire des entit&eacute;s</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZE</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_caisse_sociale</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_code_importateur</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$code_activite_principale</div></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="5" rowspan="1"
                            >N&deg; de
                            caisse sociale</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="7" rowspan="1"
                            >N&deg; Code
                            Importateur</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            colspan="7" rowspan="1"
                            >Code
                            activit&eacute; principale</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 18px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZF</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="31" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$designation_entite</div></td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$sigle</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="31" rowspan="1"
                            >
                            D&eacute;signation de l'entit&eacute;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1" >Sigle</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 17px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(255, 255, 255);">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZG</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$telephone</div></td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="7" rowspan="1"><div style="font-weight: bold; text-align: center;">$email</div></td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="4" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$num_code</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="6" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$code</div></td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$boite_postal</div></td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="5" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$ville</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1"
                            >N&deg;
                            de t&eacute;l&eacute;phone</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-decoration-line: underline; color: rgb(5, 99, 193); text-align: center;"
                            colspan="7" rowspan="1" data-sheets-hyperlink="mailto:er@tgur.ji"
                            
                                target="_blank" rel="noopener">email</a></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="6" rowspan="1" >Code</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: bottom; background-color: rgb(255, 255, 255); font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="7" rowspan="1" >
                            Bote postale</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="5" rowspan="1" >Ville</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZH</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 42px; font-weight: bold; text-align: center;">$adresse_geo_complete</div>
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Adresse g&eacute;ographique compl&egrave;te (Immeuble, rue, quartier, ville, pays)</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 42px; font-weight: bold; text-align: center;">$designation_activite_principale</div>
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(192, 192, 192); font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            >ZI</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            D&eacute;signation pr&eacute;cise de l'activit&eacute; principale exerc&eacute;e par l'entit&eacute;
                        </td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$personne_a_contacter</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom, adresse et qualit&eacute; de la personne &agrave; contacter en cas de demande d'informations
                            compl&eacute;mentaires</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$professionnel_salarie_ou_cabinet</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom du professionnel salari&eacute; de l'entit&eacute; ou</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Nom, adresse et t&eacute;l&eacute;phone du cabinet comptable ou du professionnel INSCRIT A L'ORDRE
                            NATIONAL</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            DES EXPERTS COMPTABLES ET DES COMPTABLES AGREES ayant &eacute;tabli les &eacute;tats financiers</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="38" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><div style="font-weight: bold; text-align: center;">$visa_expert</div></td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            colspan="38" rowspan="1"
                            >
                            Visa de l'Expert comptable agr&eacute;e</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="font-size: 20px; text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><b>$etats_financiers_approuves_non</b></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="font-size: 20px; text-align: center; border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}"><b>$etats_financiers_approuves_oui</b></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            >Non</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;"
                            >Oui</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 8pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 350px; left: 3px;">
                                <div style="float: left;">Etats financiers approuv&eacute;s par l'Assembl&eacute;e
                                    G&eacute;n&eacute;rale (cocher la case)</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 27px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="17" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><!--Lorem--></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold; text-align: center;"
                            colspan="16" rowspan="1"
                            >Domiciliations
                            bancaires:</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 275px; left: 3px;">
                                <div style="float: left;">Nom du signataire des &eacute;tats financiers</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="9" rowspan="1" >Banque
                        </td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; font-weight: bold;"
                            colspan="7" rowspan="1"
                            >Num&eacute;ro de
                            compte</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="9" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 49px;"><!--Lorem--></div>
                        </td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="7" rowspan="2" data-sheets-numberformat="{&quot;1&quot;:1}">
                            <div style="max-height: 49px;"><!--Lorem--></div>
                        </td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 28px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle; background-color: rgb(252, 243, 5);"
                            colspan="17" rowspan="1" data-sheets-numberformat="{&quot;1&quot;:1}"><!--Lorem--></td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;"
                            >
                            <div style="white-space: nowrap; overflow: hidden; position: relative; width: 275px; left: 3px;">
                                <div style="float: left;">Nom du signataire des &eacute;tats financiers</div>
                            </div>
                        </td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="border-right: 1px solid transparent; overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px; vertical-align: middle; font-family: Arial; font-size: 12pt;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td
                            style="overflow: hidden; padding: 0px 3px; vertical-align: middle; font-family: Arial; font-size: 12pt; text-align: center;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid transparent; overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td style="border-right: 1px solid rgb(0, 0, 0); border-bottom: 1px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;"
                            data-sheets-numberformat="{&quot;1&quot;:1}">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td style="overflow: hidden; padding: 0px 3px; vertical-align: middle;">&nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                    <tr style="height: 21px;">
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                        <td
                            style="border-right: 2px solid rgb(0, 0, 0); border-bottom: 2px solid rgb(0, 0, 0); overflow: hidden; padding: 0px 3px; vertical-align: middle;">
                            &nbsp;</td>
                    </tr>
                </tbody>
            </table>

        HTML;

        $output['contenu_document'] = $result['contenu_document'];
    }

    if ($_POST['action'] == 'preview_doc_file') {

        $id_document = $_POST['id_document'];

        $query = "SELECT * FROM document WHERE id_document = $id_document";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

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

        $output['iframe_html'] .= <<<HTML
            <iframe class="iframe_html" src="https://view.officeapps.live.com/op/embed.aspx?src=https://raw.githubusercontent.com/elyonsas/ged/main/assets/docs/{$src_document}" width='100%' height='100%' frameborder='0'></iframe>
        HTML;
    }
}

echo json_encode($output);
