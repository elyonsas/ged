<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

add_log('consultation', 'Consultation de la listes des demandes', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Demandes clients';
$titre_menu = 'Demandes clients';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "active";
$menu_demande = "";
$menu_saisie_client = "";
$menu_compta = "";
$menu_compta_facture = "";
$menu_compta_relance = "";
$menu_hist = "";
$menu_hist_interlo = "";
$menu_hist_collabo = "";

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/sidebar.php');

?>



<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">

                <!--begin::Card-->
                <div class="card card-flush mt-6 mt-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header mt-5">
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h2>Toutes les demandes</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar my-1">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" id="kt_filter_search" class="form-control form-control-solid form-select-sm w-150px ps-9" placeholder="Rechercher...">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table id="all_demande" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="">#</th>
                                        <th class="min-w-200px">Document</th>
                                        <th class="">Dernière modification</th>
                                        <th class="">statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <!--end::Head-->
                                <!--begin::Body-->
                                <tbody class="fs-6">

                                </tbody>
                                <!--end::Body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <style>
        /* Pour permettre aux instances de tinymce d'avoir une hauteur max */
        .doc-content>.fv-row.row,
        .doc-content>.fv-row.row>.tox.tox-tinymce {
            height: 100% !important;
        }
    </style>

    <!-- begin::Modal detail-->
    <div class="modal fade" id="detail_document_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Détail du document</h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <div class="modal-body">

                    <div class="">
                        <div id="equipe_detail_area" class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Aspect : <span id="detail_doc_aspect" class="fs-5 text-muted">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Code document : <span id="detail_doc_code" class="fs-5 text-muted">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Titre du document :</label>
                                <div id="detail_doc_titre" class="fs-6 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Description :</label>
                                <div id="detail_doc_description" class="fs-6 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Statut document : <span id="detail_doc_statut" class="">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Document créé par :</label>
                                <div id="detail_doc_created_by" class="fs-6 fst-italic text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Dernière modification par :</label>
                                <div id="detail_doc_updated_by" class="fs-6 fst-italic text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end::Modal detail-->

    <!-- begin::Modal edit_doc_write -->
    <div class="modal fade" id="edit_doc_write_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_write_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_write_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_write_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_write" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_write" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_write_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_write">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_write -->

    <!-- begin::Modal edit_doc_other_write -->
    <div class="modal fade" id="edit_doc_other_write_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_other_write_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_other_write_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_other_write_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_other_write" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_other_write" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_other_write_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_write">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_other_write -->

    <!-- begin::Modal edit_doc_file -->
    <div class="modal fade" id="edit_doc_file_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_file" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #file_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="file_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_file">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_file" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_file -->

    <!-- begin::Modal edit_doc_other_file -->
    <div class="modal fade" id="edit_doc_other_file_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_other_file" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #other_file_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="other_file_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_file">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_other_file" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_other_file -->

    <!-- begin::Modal edit_doc_scan -->
    <div class="modal fade" id="edit_doc_scan_modal" tabindex="-1">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_scan" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #scan_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="scan_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_scan">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_scan" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_scan -->

    <!-- begin::Modal edit_doc_generate -->
    <div class="modal fade" id="edit_doc_generate_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_generate_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_generate_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_generate_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_generate" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_generate" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_generate_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_generate">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_generate -->

</div>
<!--end::Content wrapper-->


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/footer_activities.php'); ?>


<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used by this page)-->
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/widgets.bundle.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/custom/apps/chat/chat.js"></script>
<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="assets/js/custom/utilities/modals/create-app.js"></script>
<script src="assets/js/custom/utilities/modals/new-target.js"></script>
<script src="assets/js/custom/utilities/modals/users-search.js"></script>
<script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        function update_data_datatable(data) {

            $("#all_demande").DataTable().destroy();
            var all_demande = $('#all_demande').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": true,
                "order": [],
                "data": data,
                "columnDefs": [],
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });
            $('#kt_filter_search').keyup(function() {
                all_demande.search($(this).val()).draw();
                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
            })

            $('.dataTables_paginate').click(function() {
                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)				
            })

            $('.sorting').click(function() {
                setTimeout(() => {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }, 1000);
            })
        }

        function reload_datatable(datatable) {
            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    datatable: datatable,
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable(data.data);
                }
            })
        }

        // Datatable for all demandes
        $.ajax({
            url: "roll/client/demandes/fetch.php",
            method: "POST",
            data: {
                datatable: 'all_demande',
            },
            dataType: "JSON",
            success: function(data) {
                var all_demande = $('#all_demande').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": true,
                    "order": [],
                    "data": data.data,
                    "columnDefs": [],
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });
                $('#kt_filter_search').keyup(function() {
                    all_demande.search($(this).val()).draw();
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                })

                $('.dataTables_paginate').click(function() {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)				
                })

                $('.sorting').click(function() {
                    setTimeout(() => {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }, 1000);
                })
            }
        });

        // Pour l'affichage des détails d'un document
        $(document).on('click', '.view_detail_document', function () {
            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'view_detail_document'
                },
                dataType: "JSON",
                success: function (data) {

                    $('#detail_doc_aspect').html(data.aspect_document);
                    $('#detail_doc_code').html(data.code_document);
                    $('#detail_doc_titre').html(data.titre_document);
                    $('#detail_doc_description').html(data.description_document);
                    $('#detail_doc_statut').html(data.statut_document);
                    $('#detail_doc_created_by').html('<u>' + data.created_by_document + '</u>' + ' le ' + data.created_at_document);
                    $('#detail_doc_updated_by').html('<u>' + data.updated_by_document + '</u>' + ' le ' + data.updated_at_document);

                }
            })
        });

        /* -----------------Données docs juridico admin---------------- */
        function save_doc_write() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_write = tinymce.get('id_edit_doc_write').getContent({
                format: 'text'
            });
            $('#id_edit_doc_write_text').val(docs_write);

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_write').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                        reload_datatable('all_demande');
                    } else {
                        toastr.error(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    }
                }
            })
        }

        function save_doc_other_write() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_write = tinymce.get('id_edit_doc_other_write').getContent({
                format: 'text'
            });
            $('#id_edit_doc_other_write_text').val(docs_write);

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_other_write').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                        reload_datatable('all_demande');
                    } else {
                        toastr.error(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    }
                }
            })
        }

        function save_doc_generate() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_generate = tinymce.get('id_edit_doc_generate').getContent({
                format: 'text'
            });
            $('#id_edit_doc_generate_text').val(docs_generate);

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_generate').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    } else {
                        toastr.error(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    }
                }
            })
        }

        /* -----------------Modification d'un document write---------------- */
        //Lorsqu'on clique sur .edit_doc_write
        $(document).on('click', '.edit_doc_write', function() {

            var id_document = $(this).data('id_document');
            $('#edit_doc_write_modal .loader').show();

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_write'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_write_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_write_modal .modal-title').html(data.titre_document);

                    // Initialiser l'éditeur graphique tinymce pour la modification d'un document generate (une fois)
                    if (typeof tinymce_write == 'undefined') {
                        $('#edit_doc_write_modal .modal-body #id_edit_doc_write').html(data.contenu_document);

                        tinymce_write = tinymce.init({
                            selector: '#id_edit_doc_write',
                            menubar: false,
                            language: 'fr_FR',
                            content_css: 'document',
                            plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                            toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | numlist bullist | outdent indent | pagebreak | table',
                            pagebreak_separator: '<div style="page-break-after: always;"></div>',
                            save_onsavecallback: save_doc_write,
                        });
                        // Prevent Bootstrap dialog from blocking focusin for TinyMCE
                        document.addEventListener('focusin', (e) => {
                            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                                e.stopImmediatePropagation();
                            }
                        });

                        setTimeout(function() {
                            $('#edit_doc_write_modal .loader').hide();
                        }, 2000);
                    } else {

                        // Reset editor and set a new content
                        tinymce.get('id_edit_doc_write').resetContent(data.contenu_document);

                        setTimeout(function() {
                            $('#edit_doc_write_modal .loader').hide();
                        }, 2000);
                    }

                }
            })
        });

        /* -----------------Modification d'un document generate---------------- */
        //Lorsqu'on clique sur .edit_doc_generate
        $(document).on('click', '.edit_doc_generate', function() {

            var id_document = $(this).data('id_document');
            $('#edit_doc_generate_modal .loader').show();

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_generate'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_generate_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_generate_modal .modal-title').html(data.titre_document);

                    // Initialiser l'éditeur graphique tinymce pour la modification d'un document generate (une fois)
                    if (typeof tinymce_generate == 'undefined') {
                        $('#edit_doc_generate_modal .modal-body #id_edit_doc_generate').html(data.contenu_document);

                        tinymce_generate = tinymce.init({
                            selector: '#id_edit_doc_generate',
                            menubar: false,
                            language: 'fr_FR',
                            content_css: 'document',
                            content_style: 'body { padding: 25px !important; max-width: 1050px !important; min-height: 75% !important;}',
                            plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                            toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | numlist bullist | outdent indent | pagebreak | table',
                            pagebreak_separator: '<div style="page-break-after: always;"></div>',
                            save_onsavecallback: save_doc_generate,
                        });
                        // Prevent Bootstrap dialog from blocking focusin for TinyMCE
                        document.addEventListener('focusin', (e) => {
                            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                                e.stopImmediatePropagation();
                            }
                        });

                        setTimeout(function() {
                            $('#edit_doc_generate_modal .loader').hide();
                        }, 2000);
                    } else {

                        // Reset editor and set a new content
                        tinymce.get('id_edit_doc_generate').resetContent(data.contenu_document);

                        setTimeout(function() {
                            $('#edit_doc_generate_modal .loader').hide();
                        }, 2000);
                    }

                }
            })
        });

        /* -----------------Modification d'un document file---------------- */
        //Variable contenant les fichiers joint
        fileList = [];
        fileListPath = [];
        fileListName = [];
        // set the dropzone container id
        const id = "#file_upload_zone";
        const dropzone = document.querySelector(id);

        // Lorsqu'on clique sur .edit_doc_file
        $(document).on('click', '.edit_doc_file', function() {

            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_file'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_file_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_file_modal .modal-title').html(data.titre_document);


                    /* -----------------Mise en place du plugin dropzonejs---------------- */
                    // set the preview element template
                    var previewTemplate = `
                        <div class="dropzone-item">
                            <!--begin::File-->
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                    <span data-dz-name>some_image_file_name.jpg</span>
                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                </div>

                                <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                    `;
                    var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
                        url: "roll/client/demandes/fetch.php?titre_document=" + data.titre_document + "&id_document=" + id_document + "&action=doc_file_upload", // Set the url for your upload script location
                        parallelUploads: 20,
                        maxFilesize: 10, // Max filesize in MB
                        maxFiles: 1,
                        previewTemplate: previewTemplate,
                        previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                        clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
                    });

                    // When added file
                    myDropzone.on("addedfile", function(file) {
                        // Hookup the start button
                        const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
                        dropzoneItems.forEach(dropzoneItem => {
                            dropzoneItem.style.display = '';
                        });
                    });
                    // Packaging of files in array
                    myDropzone.on("success", function(file, serverFileName) {
                        fileList.push({
                            "serverPath": serverFileName,
                            "uploadId": file.upload.uuid
                        });
                        fileListPath.push(serverFileName);
                        fileListName.push(file.name);

                    });
                    // Remove file from the list
                    myDropzone.on("removedfile", function(file) {
                        for (let i = 0; i < fileList.length; i++) {
                            if (file.upload.uuid == fileList[i].uploadId) {
                                $.ajax({
                                    url: "roll/client/demandes/fetch.php",
                                    method: "POST",
                                    data: {
                                        action: 'delete_doc_file_upload',
                                        id_document: id_document,
                                        file_path: fileList[i].serverPath,
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        // do something
                                    }
                                })
                                fileList.splice(i, 1)
                                fileListPath.splice(i, 1)
                                fileListName.splice(i, 1)
                            }
                        }

                        // var server_file = $(file.previewTemplate).children('.server_file').text();
                        // alert(server_file);
                        // // Do a post request and pass this path and use server-side language to delete the file
                        // $.post("delete.php", {
                        // 	file_to_be_deleted: server_file
                        // });
                    });
                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function(progress) {
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.width = progress + "%";
                        });
                    });
                    // Sending files to server
                    myDropzone.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.opacity = "1";
                        });
                    });
                    // Hide the total progress bar when nothing"s uploading anymore
                    myDropzone.on("complete", function(progress) {
                        const progressBars = dropzone.querySelectorAll('.dz-complete');

                        setTimeout(function() {
                            progressBars.forEach(progressBar => {
                                progressBar.querySelector('.progress-bar').style.opacity = "0";
                                progressBar.querySelector('.progress').style.opacity = "0";
                            });
                        }, 300);
                    });

                    // Si on quitte le modal
                    $('#edit_doc_file_modal').on('hidden.bs.modal', function() {
                        // Supprimer l'instance de dropzone
                        myDropzone.destroy();

                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_file_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                    //Lorsque l'utilisateur tente de quitter la page
                    $(window).on('beforeunload', function() {
                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_file_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                }
            })
        });

        // Lorsqu'on soumet le formulaire d'édition d'un document file
        $(document).on('submit', '#form_edit_doc_file', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_doc_file');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#edit_doc_file_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Document enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            // Vider les fileLists
                            fileList = [];
                            fileListPath = [];
                            fileListName = [];

                            reload_datatable('all_demande'); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        /* -----------------Modification d'un document scan---------------- */
        //Variable contenant les fichiers joint
        fileList = [];
        fileListPath = [];
        fileListName = [];
        // set the dropzone container id
        const id1 = "#scan_upload_zone";
        const dropzone1 = document.querySelector(id1);

        // Lorsqu'on clique sur .edit_doc_scan
        $(document).on('click', '.edit_doc_scan', function() {

            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_scan'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_scan_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_scan_modal .modal-title').html(data.titre_document);


                    /* -----------------Mise en place du plugin dropzonejs---------------- */
                    // set the preview element template
                    var previewTemplate = `
                        <div class="dropzone-item">
                            <!--begin::File-->
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                    <span data-dz-name>some_image_file_name.jpg</span>
                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                </div>

                                <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                    `;
                    var myDropzone = new Dropzone(id1, { // Make the whole body a dropzone
                        url: "roll/client/demandes/fetch.php?titre_document=" + data.titre_document + "&id_document=" + id_document + "&action=doc_scan_upload", // Set the url for your upload script location
                        parallelUploads: 20,
                        maxFilesize: 10, // Max filesize in MB
                        maxFiles: 1,
                        previewTemplate: previewTemplate,
                        previewsContainer: id1 + " .dropzone-items", // Define the container to display the previews
                        clickable: id1 + " .dropzone-select" // Define the element that should be used as click trigger to select files.
                    });

                    // When added file
                    myDropzone.on("addedfile", function(file) {
                        // Hookup the start button
                        const dropzoneItems = dropzone1.querySelectorAll('.dropzone-item');
                        dropzoneItems.forEach(dropzoneItem => {
                            dropzoneItem.style.display = '';
                        });
                    });
                    // Packaging of files in array
                    myDropzone.on("success", function(file, serverFileName) {
                        fileList.push({
                            "serverPath": serverFileName,
                            "uploadId": file.upload.uuid
                        });
                        fileListPath.push(serverFileName);
                        fileListName.push(file.name);

                    });
                    // Remove file from the list
                    myDropzone.on("removedfile", function(file) {
                        for (let i = 0; i < fileList.length; i++) {
                            if (file.upload.uuid == fileList[i].uploadId) {
                                $.ajax({
                                    url: "roll/client/demandes/fetch.php",
                                    method: "POST",
                                    data: {
                                        action: 'delete_doc_scan_upload',
                                        id_document: id_document,
                                        file_path: fileList[i].serverPath,
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        // do something
                                    }
                                })
                                fileList.splice(i, 1)
                                fileListPath.splice(i, 1)
                                fileListName.splice(i, 1)
                            }
                        }

                        // var server_file = $(file.previewTemplate).children('.server_file').text();
                        // alert(server_file);
                        // // Do a post request and pass this path and use server-side language to delete the file
                        // $.post("delete.php", {
                        // 	file_to_be_deleted: server_file
                        // });
                    });
                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function(progress) {
                        const progressBars = dropzone1.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.width = progress + "%";
                        });
                    });
                    // Sending files to server
                    myDropzone.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        const progressBars = dropzone1.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.opacity = "1";
                        });
                    });
                    // Hide the total progress bar when nothing"s uploading anymore
                    myDropzone.on("complete", function(progress) {
                        const progressBars = dropzone1.querySelectorAll('.dz-complete');

                        setTimeout(function() {
                            progressBars.forEach(progressBar => {
                                progressBar.querySelector('.progress-bar').style.opacity = "0";
                                progressBar.querySelector('.progress').style.opacity = "0";
                            });
                        }, 300);
                    });

                    // Si on quitte le modal
                    $('#edit_doc_scan_modal').on('hidden.bs.modal', function() {
                        // Supprimer l'instance de dropzone
                        myDropzone.destroy();

                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_scan_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                    //Lorsque l'utilisateur tente de quitter la page
                    $(window).on('beforeunload', function() {
                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_scan_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                }
            })
        });

        // Lorsqu'on soumet le formulaire d'édition d'un document file
        $(document).on('submit', '#form_edit_doc_scan', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_doc_scan');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#edit_doc_scan_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Document enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            // Vider les fileLists
                            fileList = [];
                            fileListPath = [];
                            fileListName = [];

                            reload_datatable('all_demande'); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });


        /* -----------------Modification d'un formulaire docs generate---------------- */
        function date_formatter(date, format) {
            if (date == null) {
                return '';
            }

            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            if (format == 'dd/mm/yyyy') {
                return [day, month, year].join('/');
            } else if (format == 'mm/dd/yyyy') {
                return [month, day, year].join('/');
            } else if (format == 'yyyy/mm/dd') {
                return [year, month, day].join('/');
            } else if (format == 'yyyy/dd/mm') {
                return [year, day, month].join('/');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'dd-mm-yyyy') {
                return [day, month, year].join('-');
            } else if (format == 'mm-dd-yyyy') {
                return [month, day, year].join('-');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'yyyy-dd-mm') {
                return [year, day, month].join('-');
            }
        }

        // Lorsqu'on clique sur .edit_form_doc_generate
        init_repeater_count_edit_form_doc_generate = 0;
        $(document).on('click', '.edit_form_doc_generate', function(e) {
            e.preventDefault();
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_generate'
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.table_document == 'doc_8_fiche_id_client') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;
                        adresse = data.adresse;
                        id_fiscale_client = data.id_fiscale_client;
                        exercice_clos_le = date_formatter(data.exercice_clos_le, 'yyyy-mm-dd');
                        duree_en_mois = data.duree_en_mois;
                        exercice_compta_du = date_formatter(data.exercice_compta_du, 'yyyy-mm-dd');
                        exercice_compta_au = date_formatter(data.exercice_compta_au, 'yyyy-mm-dd');
                        date_arret_compta = date_formatter(data.date_arret_compta, 'yyyy-mm-dd');
                        exercice_prev_clos_le = date_formatter(data.exercice_prev_clos_le, 'yyyy-mm-dd');
                        duree_exercice_prev_en_mois = data.duree_exercice_prev_en_mois;
                        greffe = data.greffe;
                        num_registre_commerce = data.num_registre_commerce;
                        num_repertoire_entite = data.num_repertoire_entite;
                        num_caisse_sociale = data.num_caisse_sociale;
                        num_code_importateur = data.num_code_importateur;
                        code_activite_principale = data.code_activite_principale;
                        designation_entite = data.designation_entite;
                        sigle = data.sigle;
                        telephone = data.telephone;
                        email = data.email;
                        num_code = data.num_code;
                        code = data.code;
                        boite_postal = data.boite_postal;
                        ville = data.ville;
                        adresse_geo_complete = data.adresse_geo_complete;
                        designation_activite_principale = data.designation_activite_principale;
                        personne_a_contacter = data.personne_a_contacter;
                        professionnel_salarie_ou_cabinet = data.professionnel_salarie_ou_cabinet;
                        visa_expert = data.visa_expert;
                        etats_financiers_approuves = data.etats_financiers_approuves;

                        forme_juridique_1 = data.forme_juridique_1;
                        forme_juridique_2 = data.forme_juridique_2;
                        regime_fiscal_1 = data.regime_fiscal_1;
                        regime_fiscal_2 = data.regime_fiscal_2;
                        pays_siege_social_1 = data.pays_siege_social_1;
                        pays_siege_social_2 = data.pays_siege_social_2;
                        nbr_etablissement_in = data.nbr_etablissement_in;
                        nbr_etablissement_out = data.nbr_etablissement_out;
                        prem_annee_exercice_in = data.prem_annee_exercice_in;
                        controle_entite = data.controle_entite;

                        duree_vie_societe = data.duree_vie_societe;
                        date_dissolution = date_formatter(data.date_dissolution, 'yyyy-mm-dd');
                        capital_social = data.capital_social;
                        siege_social = data.siege_social;
                        site_internet = data.site_internet;
                        nombre_de_salarie = data.nombre_de_salarie;
                        ca_3_derniers_exercices_n_1 = data.ca_3_derniers_exercices_n_1;
                        ca_3_derniers_exercices_n_2 = data.ca_3_derniers_exercices_n_2;
                        ca_3_derniers_exercices_n_3 = data.ca_3_derniers_exercices_n_3;

                        date_ouverture_dossier = date_formatter(data.date_ouverture_dossier, 'yyyy-mm-dd');
                        nom_cabinet_confrere = data.nom_cabinet_confrere;
                        dossier_herite_confrere = data.dossier_herite_confrere;


                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal .modal-title').html(titre_document);

                        $('#table_doc_8_fiche_id_client_adresse').val(adresse);
                        $('#table_doc_8_fiche_id_client_id_fiscale_client').val(id_fiscale_client);
                        $('#table_doc_8_fiche_id_client_exercice_clos_le').val(exercice_clos_le);
                        $('#table_doc_8_fiche_id_client_duree_en_mois').val(duree_en_mois);
                        $('#table_doc_8_fiche_id_client_exercice_compta_du').val(exercice_compta_du);
                        $('#table_doc_8_fiche_id_client_exercice_compta_au').val(exercice_compta_au);
                        $('#table_doc_8_fiche_id_client_date_arret_compta').val(date_arret_compta);
                        $('#table_doc_8_fiche_id_client_exercice_prev_clos_le').val(exercice_prev_clos_le);
                        $('#table_doc_8_fiche_id_client_duree_exercice_prev_en_mois').val(duree_exercice_prev_en_mois);
                        $('#table_doc_8_fiche_id_client_greffe').val(greffe);
                        $('#table_doc_8_fiche_id_client_num_registre_commerce').val(num_registre_commerce);
                        $('#table_doc_8_fiche_id_client_num_repertoire_entite').val(num_repertoire_entite);
                        $('#table_doc_8_fiche_id_client_num_caisse_sociale').val(num_caisse_sociale);
                        $('#table_doc_8_fiche_id_client_num_code_importateur').val(num_code_importateur);
                        $('#table_doc_8_fiche_id_client_code_activite_principale').val(code_activite_principale);
                        $('#table_doc_8_fiche_id_client_designation_entite').val(designation_entite);
                        $('#table_doc_8_fiche_id_client_sigle').val(sigle);
                        $('#table_doc_8_fiche_id_client_telephone').val(telephone);
                        $('#table_doc_8_fiche_id_client_email').val(email);
                        $('#table_doc_8_fiche_id_client_num_code').val(num_code);
                        $('#table_doc_8_fiche_id_client_code').val(code);
                        $('#table_doc_8_fiche_id_client_boite_postal').val(boite_postal);
                        $('#table_doc_8_fiche_id_client_ville').val(ville);
                        $('#table_doc_8_fiche_id_client_adresse_geo_complete').val(adresse_geo_complete);
                        $('#table_doc_8_fiche_id_client_designation_activite_principale').val(designation_activite_principale);
                        $('#table_doc_8_fiche_id_client_personne_a_contacter').val(personne_a_contacter);
                        $('#table_doc_8_fiche_id_client_professionnel_salarie_ou_cabinet').val(professionnel_salarie_ou_cabinet);
                        $('#table_doc_8_fiche_id_client_visa_expert').val(visa_expert);
                        if (etats_financiers_approuves == 'oui') {
                            $('#table_doc_8_fiche_id_client_etats_financiers_approuves_oui').prop('checked', true);
                        } else {
                            $('#table_doc_8_fiche_id_client_etats_financiers_approuves_non').prop('checked', true);
                        }


                        $('#table_doc_8_fiche_id_client_forme_juridique_1').val(forme_juridique_1);
                        $('#table_doc_8_fiche_id_client_forme_juridique_2').val(forme_juridique_2);
                        $('#table_doc_8_fiche_id_client_regime_fiscal_1').val(regime_fiscal_1);
                        $('#table_doc_8_fiche_id_client_regime_fiscal_2').val(regime_fiscal_2);
                        $('#table_doc_8_fiche_id_client_pays_siege_social_1').val(pays_siege_social_1);
                        $('#table_doc_8_fiche_id_client_pays_siege_social_2').val(pays_siege_social_2);
                        $('#table_doc_8_fiche_id_client_nbr_etablissement_in').val(nbr_etablissement_in);
                        $('#table_doc_8_fiche_id_client_nbr_etablissement_out').val(nbr_etablissement_out);
                        $('#table_doc_8_fiche_id_client_prem_annee_exercice_in').val(prem_annee_exercice_in);
                        if (controle_entite == 'public') {
                            $('#table_doc_8_fiche_id_client_controle_entite_public').prop('checked', true);
                        } else if (controle_entite == 'prive_national') {
                            $('#table_doc_8_fiche_id_client_controle_entite_prive_national').prop('checked', true);
                        } else if (controle_entite == 'prive_etranger') {
                            $('#table_doc_8_fiche_id_client_controle_entite_prive_etranger').prop('checked', true);
                        }

                        $('#table_doc_8_fiche_id_client_duree_vie_societe').val(duree_vie_societe);
                        $('#table_doc_8_fiche_id_client_date_dissolution').val(date_dissolution);
                        $('#table_doc_8_fiche_id_client_capital_social').val(capital_social);
                        $('#table_doc_8_fiche_id_client_siege_social').val(siege_social);
                        $('#table_doc_8_fiche_id_client_site_internet').val(site_internet);
                        $('#table_doc_8_fiche_id_client_nombre_de_salarie').val(nombre_de_salarie);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_1').val(ca_3_derniers_exercices_n_1);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_2').val(ca_3_derniers_exercices_n_2);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_3').val(ca_3_derniers_exercices_n_3);


                        $('#table_doc_8_fiche_id_client_date_ouverture_dossier').val(date_ouverture_dossier);
                        $('#table_doc_8_fiche_id_client_nom_cabinet_confrere').val(nom_cabinet_confrere);
                        $('#table_doc_8_fiche_id_client_dossier_herite_confrere').val(dossier_herite_confrere);

                        init_repeater_count_edit_form_doc_generate++;
                        if (init_repeater_count_edit_form_doc_generate == 1) {
                            // Fetch data for activite_client (Repeater)
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'activite_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-2">
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">Designation</label>
                                                    <input name="designation_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Désignation de l'activité" /> -->
                                                    <div class="form-floating">
                                                        <input name="designation_activite_client" type="text" class="form-control" placeholder="Désignation de l'activité"/>
                                                        <label>Designation</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <label class="form-label">Nomenclature</label>
                                                    <input name="code_nomenclature_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Code nomenclature d'activité" /> -->
                                                    <div class="form-floating">
                                                        <input name="code_nomenclature_activite_client" type="text" class="form-control" placeholder="Code nomenclature d'activité"/>
                                                        <label>Nomenclature</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">Chiffre d'affaires HT</label>
                                                    <input name="chiffre_affaires_ht_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Chiffre d'affaires HT" /> -->
                                                    <div class="form-floating">
                                                        <input name="chiffre_affaires_ht_activite_client" type="number" class="form-control" placeholder="Chiffre d'affaires HT"/>
                                                        <label>Chiffre d'affaires HT</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">% activité dans le CA</label>
                                                    <input name="percent_activite_in_ca_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="% activité dans le CA HT" /> -->
                                                    <div class="form-floating">
                                                        <input name="percent_activite_in_ca_activite_client" type="number" class="form-control" placeholder="% activité dans le CA HT"/>
                                                        <label>% activité dans le CA</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="designation_activite_client"]').val(data[i].designation_activite_client);
                                        $(parent + ' ' + 'input[name="code_nomenclature_activite_client"]').val(data[i].code_nomenclature_activite_client);
                                        $(parent + ' ' + 'input[name="chiffre_affaires_ht_activite_client"]').val(data[i].chiffre_affaires_ht_activite_client);
                                        $(parent + ' ' + 'input[name="percent_activite_in_ca_activite_client"]').val(data[i].percent_activite_in_ca_activite_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_activite_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });


                                }
                            });

                            // Fetch data for dirigeant_client (Repeater)
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'dirigeant_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="nom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Nom"/>
                                                        <label>Nom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="prenom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Prénom"/>
                                                        <label>Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="qualite_dirigeant_client" type="text" class="form-control mb-2" placeholder="Qualité"/>
                                                        <label>Qualité</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="id_fiscal_dirigeant_client" type="number" class="form-control mb-2" placeholder="N° identification fiscale"/>
                                                        <label>N° identification fiscale</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="tel_dirigeant_client" type="text" class="form-control mb-2" placeholder="Téléphone"/>
                                                        <label>Téléphone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="mail_dirigeant_client" type="email" class="form-control mb-2" placeholder="Mail"/>
                                                        <label>Mail</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="adresse_dirigeant_client" type="text" class="form-control mb-2" placeholder="Adresse"/>
                                                        <label>Adresse</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="nom_dirigeant_client"]').val(data[i].nom_dirigeant_client);
                                        $(parent + ' ' + 'input[name="prenom_dirigeant_client"]').val(data[i].prenom_dirigeant_client);
                                        $(parent + ' ' + 'input[name="qualite_dirigeant_client"]').val(data[i].qualite_dirigeant_client);
                                        $(parent + ' ' + 'input[name="id_fiscal_dirigeant_client"]').val(data[i].id_fiscal_dirigeant_client);
                                        $(parent + ' ' + 'input[name="tel_dirigeant_client"]').val(data[i].tel_dirigeant_client);
                                        $(parent + ' ' + 'input[name="mail_dirigeant_client"]').val(data[i].mail_dirigeant_client);
                                        $(parent + ' ' + 'input[name="adresse_dirigeant_client"]').val(data[i].adresse_dirigeant_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_dirigeant_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });

                                }
                            });

                            // Fetch data for membre_conseil_client (Repeater)
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'membre_conseil_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="nom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Nom"/>
                                                        <label>Nom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="prenom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Prénom"/>
                                                        <label>Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="qualite_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Qualité"/>
                                                        <label>Qualité</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="tel_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Téléphone"/>
                                                        <label>Téléphone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="mail_membre_conseil_client" type="email" class="form-control mb-2" placeholder="Mail"/>
                                                        <label>Mail</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="adresse_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Adresse"/>
                                                        <label>Adresse</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <textarea name="fonction_membre_conseil_client" class="form-control mb-2" placeholder="Fonction"></textarea>
                                                        <label>Fonction</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="nom_membre_conseil_client"]').val(data[i].nom_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="prenom_membre_conseil_client"]').val(data[i].prenom_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="qualite_membre_conseil_client"]').val(data[i].qualite_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="tel_membre_conseil_client"]').val(data[i].tel_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="mail_membre_conseil_client"]').val(data[i].mail_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="adresse_membre_conseil_client"]').val(data[i].adresse_membre_conseil_client);
                                        $(parent + ' ' + 'textarea[name="fonction_membre_conseil_client"]').val(data[i].fonction_membre_conseil_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });

                                }
                            });
                        }

                    }

                    if (data.table_document == 'doc_3_accept_mission') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;

                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal .modal-title').html(titre_document);

                        // quiz1
                        if (data.quiz1 == 'oui') {
                            $('#table_doc_3_accept_mission_quiz1_oui').prop('checked', true);
                        } else if (data.quiz1 == 'non') {
                            $('#table_doc_3_accept_mission_quiz1_non').prop('checked', true);
                        }
                        // observ1
                        $('#table_doc_3_accept_mission_observ1').val(data.observ1);

                        // quiz2 à 9
                        for (let i = 2; i <= 9; i++) {
                            if (data['quiz' + i] == 'e') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_e').prop('checked', true);
                            } else if (data['quiz' + i] == 'm') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_m').prop('checked', true);
                            } else if (data['quiz' + i] == 'f') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_f').prop('checked', true);
                            }
                        }

                        // quiz10 à 20
                        for (let i = 10; i <= 20; i++) {
                            // quiz
                            if (data['quiz' + i] == 'oui') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_oui').prop('checked', true);
                            } else if (data['quiz' + i] == 'non') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_non').prop('checked', true);
                            }

                            // observ
                            $('#table_doc_3_accept_mission_observ' + i).val(data['observ' + i]);
                        }

                        // accept_mission
                        if (data.accept_mission == 'oui') {
                            $('#table_doc_3_accept_mission_accept_mission_oui').prop('checked', true);
                        } else if (data.accept_mission == 'non') {
                            $('#table_doc_3_accept_mission_accept_mission_non').prop('checked', true);
                        }
                        // observation
                        $('#table_doc_3_accept_mission_observation').val(data.observation);


                    }

                    if (data.table_document == 'doc_19_quiz_lcb') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;

                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal .modal-title').html(titre_document);

                        // quiz1 à 21
                        for (let i = 1; i <= 21; i++) {
                            // quiz
                            if (data['quiz' + i] == 'oui') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_oui').prop('checked', true);
                            } else if (data['quiz' + i] == 'non') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_non').prop('checked', true);
                            } else if (data['quiz' + i] == 'na') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_na').prop('checked', true);
                            }
                            // impact
                            if (data['impact' + i] == 'e') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('e').trigger('change');
                            } else if (data['impact' + i] == 'm') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('m').trigger('change');
                            } else if (data['impact' + i] == 'f') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('f').trigger('change');
                            }
                            // observ
                            $('#table_doc_19_quiz_lcb_observ' + i).val(data['observ' + i]);
                        }

                        // conclusion
                        $('#table_doc_19_quiz_lcb_conclusion').val(data.conclusion);


                    }



                }
            })
        });

        // Lorsqu'on clique sur .edit_info_doc_file
        init_repeater_count_edit_info_doc_file = 0;
        $(document).on('click', '.edit_info_doc_file', function(e) {
            e.preventDefault();
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/client/demandes/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_info_doc_file'
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.table_info_document == 'doc_6_info_lettre_mission') {

                        // Show modal
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;
                        duree = data.duree;
                        renouvellement = data.renouvellement;
                        date_debut_duree = date_formatter(data.date_debut_duree, 'yyyy-mm-dd');
                        date_debut_renouvellement = date_formatter(data.date_debut_renouvellement, 'yyyy-mm-dd');
                        frais_ouverture = data.frais_ouverture;
                        montant_honoraires_ht = data.montant_honoraires_ht;
                        montant_honoraires_ttc = data.montant_honoraires_ttc;


                        // On rempli les champs du modal
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal input[name="id_document"]').val(id_document);
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal .modal-title').html(titre_document);

                        $('#table_doc_6_info_lettre_mission_duree').val(duree);
                        $('#table_doc_6_info_lettre_mission_renouvellement').val(renouvellement);
                        $('#table_doc_6_info_lettre_mission_date_debut_duree').val(date_debut_duree);
                        $('#table_doc_6_info_lettre_mission_date_debut_renouvellement').val(date_debut_renouvellement);
                        $('#table_doc_6_info_lettre_mission_frais_ouverture').val(frais_ouverture);
                        $('#table_doc_6_info_lettre_mission_montant_honoraires_ht').val(montant_honoraires_ht);
                        $('#table_doc_6_info_lettre_mission_montant_honoraires_ttc').val(montant_honoraires_ttc);

                        init_repeater_count_edit_info_doc_file++;
                        if (init_repeater_count_edit_info_doc_file == 1) {
                            // Fetch data for mission_client (Repeater)
                            $.ajax({
                                url: "roll/client/demandes/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'mission_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-10">
                                                    <label class="fs-5 form-label">Nature de la mission</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0" placeholder="Précisez la nature de la mission en se référant au prospectus du cabinet" name="nature_mission" />
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                        <i class="la la-trash-o fs-3"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-10 ms-10 mt-5">
                                                    <div class="inner-repeater">
                                                        <div data-repeater-list="sous_mission" class="mb-5">
                                                            <div data-repeater-item>
                                                                <label class="fs-6 form-label">Nature de la sous mission</label>
                                                                <div class="input-group pb-3">
                                                                    <input type="text" class="form-control" placeholder="Précisez la nature de la sous mission" name="nature_sous_mission" />
                                                                    <button class="border border-secondary btn btn-icon btn-light-danger" data-repeater-delete type="button">
                                                                        <i class="la la-trash-o fs-3"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-sm btn-light-primary" data-repeater-create type="button">
                                                            <i class="la la-plus"></i> Ajouter une sous mission
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $template_inner = `
                                    
                                        <div data-repeater-item>
                                            <label class="fs-6 form-label">Nature de la sous mission</label>
                                            <div class="input-group pb-3">
                                                <input type="text" class="form-control" placeholder="Précisez la nature de la sous mission" name="nature_sous_mission" />
                                                <button class="border border-secondary btn btn-icon btn-light-danger" data-repeater-delete type="button">
                                                    <i class="la la-trash-o fs-3"></i>
                                                </button>
                                            </div>
                                        </div>

                                    `;

                                    // vider le contenu de #table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission
                                    $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"]').html('');
                                    init_repeater_inner_count_edit_info_doc_file = 0;
                                    for (let i = 0; i < data.length; i++) {
                                        if (data[i].sous_mission == 'non') {

                                            $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"]').append($template);
                                            parent = '#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"] div[data-repeater-item]:last-child';

                                            $(parent + ' ' + 'input[name="nature_mission"]').val(data[i].nature_mission);

                                            init_repeater_inner_count_edit_info_doc_file = 0;
                                        } else {

                                            if (init_repeater_inner_count_edit_info_doc_file == 0) {
                                                $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last').html('');
                                            }

                                            $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last').append($template_inner);
                                            parent = '#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last div[data-repeater-item]:last-child';

                                            $(parent + ' ' + 'input[name="nature_sous_mission"]').val(data[i].nature_mission);

                                            init_repeater_inner_count_edit_info_doc_file++;

                                        }
                                    }



                                    $('#table_doc_6_info_lettre_mission_repeater').repeater({
                                        initEmpty: false,

                                        repeaters: [{
                                            initEmpty: false,

                                            selector: '.inner-repeater',
                                            show: function() {
                                                $(this).slideDown();
                                            },

                                            hide: function(deleteElement) {
                                                $(this).slideUp(deleteElement);
                                            }
                                        }],

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        }
                                    });


                                }
                            });
                        }

                    }

                }
            })
        });


    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>