<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

use Ramsey\Uuid\Uuid;

connected('client');

$output = '';

if (isset($_POST['datatable'])) {

    if ($_POST['datatable'] == 'all_demande') {

        $output = array();
        $id_client = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

        $query = "SELECT * FROM document WHERE id_client = $id_client AND statut_document = 'demande' ORDER BY updated_at_document DESC";


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

            $statut_document = <<<HTML
                <span class="badge badge-light-danger">Invalidé</span>
            HTML;

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
                $statut_document
            HTML;

            // Select table_document
            $query = "SELECT * FROM document, $table_document WHERE document.id_document = $table_document.id_document AND $table_document.id_document = $id_document";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();


            // Action
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
                                    <a href="" class="edit_form_doc_generate menu-link px-3" data-id_document="{$id_document}">Remplir le formulaire</a>
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
                                    <a href="" class="edit_doc_write menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_write_modal" data-id_document="{$id_document}">Rédiger le document</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                        </div>
                    </td>

                HTML;
            } else if ($type_document == 'file') {

                if ($table_document != 'document_file') {
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
                                        <a href="" class="edit_doc_file menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_file_modal" data-id_document="{$id_document}">Importer le document</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </td>

                    HTML;
                } else {
                    if ($table_info_document != NULL) {

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
                                            <a href="" class="edit_doc_file menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_file_modal" data-id_document="{$id_document}">Importer le document</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!-- begin::Menu item -->
                                        <div class="menu-item px-3">
                                            <a href="" class="edit_info_doc_file menu-link px-3" data-id_document="{$id_document}">Ajouter informations</a>
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
                                            <a href="" class="edit_doc_file menu-link px-3" data-bs-toggle="modal" data-bs-target="#edit_doc_file_modal" data-id_document="{$id_document}">Importer le document</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            </td>

                        HTML;
                    }
                }
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
        $description_document = $result['description_document'];

        $statut_document = <<<HTML
            <span class="badge badge-light-danger">Invalidé</span>
        HTML;

        $created_by_document = find_info_utilisateur('prenom_utilisateur', $result['created_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['created_by_document'], $db);
        $created_at_document = si_funct1($result['created_at_document'], date('d/m/Y H:i:s', strtotime($result['created_at_document'])), '');
        $updated_by_document = find_info_utilisateur('prenom_utilisateur', $result['updated_by_document'], $db) . ' ' . find_info_utilisateur('nom_utilisateur', $result['updated_by_document'], $db);
        $updated_at_document = si_funct1($result['updated_at_document'], date('d/m/Y H:i:s', strtotime($result['updated_at_document'])), '');

        $output = [
            'aspect_document' => $aspect_document,
            'code_document' => $code_document,
            'titre_document' => $titre_document,
            'description_document' => $description_document,
            'statut_document' => $statut_document,
            'created_by_document' => $created_by_document,
            'created_at_document' => $created_at_document,
            'updated_by_document' => $updated_by_document,
            'updated_at_document' => $updated_at_document
        ];
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
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/docs/' . $matricule_client . '/' . $src_document;

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
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/docs/' . $matricule_client . '/' . $src_scan_document;

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
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/docs/' . $matricule_client . '/';

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

    $output = $targetFile;
    echo $output;
    die;
}



echo json_encode($output);
