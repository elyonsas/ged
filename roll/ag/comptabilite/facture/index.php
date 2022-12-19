<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Factures';
$titre_menu = 'Factures';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_compta = "here show";
$menu_compta_facture = "active";
$menu_compta_finance = "";

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/sidebar.php');

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
                            <h2>Tous les factures</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar my-1">
                            <!-- begin::add btn facture -->
                            <div id="add_facture" data-bs-toggle="modal" data-bs-target="#add_facture_modal" class="btn btn-sm btn-light btn-active-primary me-3">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>Ajouter une facture
                                <!--end::Svg Icon-->
                            </div>
                            <!-- end::add btn facture -->
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
                            <table id="all_factures" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="">N° Facture</th>
                                        <th class="">Date de créaction</th>
                                        <!-- <th class="">Date d'émission</th> -->
                                        <th class="">Client</th>
                                        <th class="">Échéance</th>
                                        <!-- <th class="">Date d'échéance</th> -->
                                        <!-- <th class="min-w-75px">Montant HT</th> -->
                                        <!-- <th class="min-w-75px">TVA</th> -->
                                        <th class="min-w-75px">Montant TTC</th>
                                        <th class="min-w-75px">Montant réglé</th>
                                        <!-- <th class="min-w-75px">Solde</th> -->
                                        <th class="">Statut</th>
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

    <!-- begin::Modal Ajouter une facture-->
    <div class="modal fade" id="add_facture_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_facture" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter une facture</h4>
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

                <!--begin::Modal body-->
                <div class="modal-body">

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Client</label>
                            <select id="add_facture_client" class="form-select form-select-solid" data-dropdown-parent="#add_facture_modal" data-allow-clear="true" data-control="select2" data-placeholder="Choisissez un client" name="id_client" required></select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Objet de la facture</label>
                            <textarea id="add_facture_objet" class="form-control form-control-solid" name="objet_facture" 
                            rows="3" placeholder="Entrez l'objet de la facture"></textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Type de facture</label>
                            <select id="add_facture_type" class="form-select form-select-solid" data-hide-search="true" data-dropdown-parent="#add_facture_modal" data-allow-clear="true" data-control="select2" data-placeholder="Type de facture" name="type_facture" required>
                                <option value="contrat">Contrat</option>
                                <option value="formation">Formation</option>
                                <option value="autre">Autres</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Échéance</label>
                            <input id="add_facture_echeance" type="number" class="form-control form-control-solid" placeholder="Échéance en (jour)" name="echeance_facture" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="fs-5 mb-2">Montant</label>
                        <div class="input-group">
                            <input id="add_facture_montant_ht" type="text" class="form-control" placeholder="Montant HT" name="montant_ht_facture" required>
                            <span class="input-group-text">-</span>
                            <input id="add_facture_tva" type="text" class="form-control" placeholder="TVA" name="tva_facture" required>
                            <span class="input-group-text">-</span>
                            <input id="add_facture_montant_ttc" type="text" class="form-control" placeholder="Montant TTC" name="montant_ttc_facture" required>
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_facture">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_facture" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
        </div>
    </div>
    <!-- end::Modal Ajouter une facture-->

    <!-- begin::Modal detail-->
    <div class="modal fade" id="detail_facture_modal" tabindex="-1" role="dialog" aria-labelledby="detail_facture_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Détails facture</h4>
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
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">N° Facture :</label>
                                <span id="detail_n_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Type de facture :</label>
                                <span id="detail_type_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Objet de la facture :</label>
                                <span id="detail_objet_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Date de création :</label>
                                <span id="detail_created_at_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Date d'émission :</label>
                                <span id="detail_date_emission_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Client :</label>
                                <span id="detail_client_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Échéance :</label>
                                <span id="detail_echeance_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Date de l'échéance :</label>
                                <span id="detail_date_echeance_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Montant HT :</label>
                                <span id="detail_montant_ht_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">TVA :</label>
                                <span id="detail_tva_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Montant TTC :</label>
                                <span id="detail_montant_ttc_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Montant réglé :</label>
                                <span id="detail_montant_regle_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Solde :</label>
                                <span id="detail_solde_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">Statut :</label>
                                <span id="detail_statut_facture" class="fs-5 text-muted"></span>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4 fw-bold">Document créé par :</label>
                                <div id="detail_doc_created_by" class="fs-6 fst-italic text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4 fw-bold">Dernière modification par :</label>
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

    <!-- begin::Modal Modifier une facture-->
    <div class="modal fade" id="modifier_facture_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_modifier_facture" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Modifier facture</h4>
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

                <!--begin::Modal body-->
                <div class="modal-body">

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Objet de la facture</label>
                            <textarea id="modifier_facture_objet" class="form-control form-control-solid" name="objet_facture" 
                            rows="3" placeholder="Entrez l'objet de la facture"></textarea>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Type de facture</label>
                            <select id="modifier_facture_type" class="form-select form-select-solid" data-hide-search="true" data-dropdown-parent="#modifier_facture_modal" data-allow-clear="true" data-control="select2" data-placeholder="Type de facture" name="type_facture" required>
                                <option value="contrat">Contrat</option>
                                <option value="formation">Formation</option>
                                <option value="autre">Autres</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Échéance</label>
                            <input id="modifier_facture_echeance" type="number" class="form-control form-control-solid" placeholder="Échéance en (jour)" name="echeance_facture" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="fs-5 mb-2">Montant</label>
                        <div class="input-group">
                            <input id="modifier_facture_montant_ht" type="text" class="form-control" placeholder="Montant HT" name="montant_ht_facture" required>
                            <span class="input-group-text">-</span>
                            <input id="modifier_facture_tva" type="text" class="form-control" placeholder="TVA" name="tva_facture" required>
                            <span class="input-group-text">-</span>
                            <input id="modifier_facture_montant_ttc" type="text" class="form-control" placeholder="Montant TTC" name="montant_ttc_facture" required>
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="modifier_facture">
                    <input type="hidden" name="id_facture" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_modifier_facture" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
        </div>
    </div>
    <!-- end::Modal Modifier une facture-->

    <!-- begin::Modal Encaisser une facture-->
    <div class="modal fade" id="encaisser_facture_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_encaisser_facture" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Encaisser facture</h4>
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

                <!--begin::Modal body-->
                <div class="modal-body">

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">N° Facture</label>
                            <select id="encaisser_facture_n" class="not-allowed form-select form-select-solid" data-dropdown-parent="#encaisser_facture_modal" data-allow-clear="true" data-control="select2" data-placeholder="N° Facture" name="n_facture" required disabled></select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Références</label>
                            <input id="encaisser_paiement_reference" type="text" class="form-control form-control-solid" placeholder="Références" name="reference_paiement" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Mode de paiement</label>
                            <select id="encaisser_paiement_mode" class="form-select form-select-solid" data-hide-search="true" data-dropdown-parent="#encaisser_facture_modal" data-allow-clear="true" data-control="select2" data-placeholder="N° Facture" name="mode_paiement" required>
                                <option value="cheque">Chèque</option>
                                <option value="virement">Virement</option>
                                <option value="espece">Espèce</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Montant TTC</label>
                            <input id="encaisser_paiement_montant_ttc" type="text" class="form-control form-control-solid" placeholder="Références" name="montant_ttc_paiement" required>
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="encaisser_facture">
                    <input type="hidden" name="id_facture" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_encaisser_facture" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
        </div>
    </div>
    <!-- end::Modal Encaisser une facture-->

</div>
<!--end::Content wrapper-->


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/footer_activities.php'); ?>


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

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        function update_data_datatable(data) {

            $("#all_factures").DataTable().destroy();
            var all_factures = $('#all_factures').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": true,
                "order": [],
                "data": data,
                "columnDefs": [{
                    "targets": [4],
                    "orderable": false,
                }, ],
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });
            $('#kt_filter_search').keyup(function() {
                all_factures.search($(this).val()).draw();
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
                url: "roll/ag/comptabilite/facture/fetch.php",
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

        function date_formatter(date, format) {
            if (date == null) {
                return '--';
            }

            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear(),
                hour = ('0' + d.getHours()).slice(-2),
                minute = ('0' + d.getMinutes()).slice(-2),
                second = ('0' + d.getSeconds()).slice(-2);

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
            } else if (format == 'dd/mm/yyyy hh:mm') {
                return [day, month, year].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'mm/dd/yyyy hh:mm') {
                return [month, day, year].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy/mm/dd hh:mm') {
                return [year, month, day].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy/dd/mm hh:mm') {
                return [year, day, month].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-mm-dd hh:mm') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'dd-mm-yyyy hh:mm') {
                return [day, month, year].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'mm-dd-yyyy hh:mm') {
                return [month, day, year].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-mm-dd hh:mm') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-dd-mm hh:mm') {
                return [year, day, month].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'dd/mm/yyyy hh:mm:ss') {
                return [day, month, year].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'mm/dd/yyyy hh:mm:ss') {
                return [month, day, year].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy/mm/dd hh:mm:ss') {
                return [year, month, day].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy/dd/mm hh:mm:ss') {
                return [year, day, month].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-mm-dd hh:mm:ss') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'dd-mm-yyyy hh:mm:ss') {
                return [day, month, year].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'mm-dd-yyyy hh:mm:ss') {
                return [month, day, year].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-mm-dd hh:mm:ss') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-dd-mm hh:mm:ss') {
                return [year, day, month].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else {
                return [day, month, year].join('/');
            }
        }

        function amount_format(amount, delimitter = ' ') {

            if (amount == null || amount == '') {
                return '';
            }

            var delimitter_str = "$1" + delimitter;
            return amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, delimitter_str);

        }

        // Datatable for all factures
        $.ajax({
            url: "roll/ag/comptabilite/facture/fetch.php",
            method: "POST",
            data: {
                datatable: 'all_factures',
            },
            dataType: "JSON",
            success: function(data) {
                var all_factures = $('#all_factures').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": true,
                    "order": [],
                    "data": data.data,
                    "columnDefs": [{
                        "targets": [4],
                        "orderable": false,
                    }, ],
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });
                $('#kt_filter_search').keyup(function() {
                    all_factures.search($(this).val()).draw();
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

        // Lorsqu'on clique sur #add_facture
        $(document).on('click', '#add_facture', function() {
            $('#form_add_facture')[0].reset();

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_client',
                },
                dataType: "JSON",
                success: function(data) {
                    $('#add_facture_client').html(data);
                }
            });
        });

        // Pour l'ajout d'une nouvelle facture
        $(document).on('submit', '#form_add_facture', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_add_facture');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#add_facture_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Facture ajoutée !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_factures'); // On recharge le datatable

                        } else {
                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .view_detail_facture
        $(document).on('click', '.view_detail_facture', function(e) {
            e.preventDefault();
            var id_facture = $(this).data('id_facture');

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    id_facture: id_facture,
                    action: 'view_detail_facture'
                },
                dataType: "JSON",
                success: function(data) {

                    n_facture = data.n_facture;

                    type_facture = data.type_facture;
                    switch (type_facture) {
                        case 'contrat':
                            type_facture = 'Contrat';
                            break;
                        case 'formation':
                            type_facture = 'Formation';
                            break;
                        case 'autre':
                            type_facture = 'Autres';
                            break;
                    }
                    
                    objet_facture = data.objet_facture;
                    created_at_facture = date_formatter(data.created_at_facture, 'dd/mm/yyyy hh:mm');
                    date_emission_facture = date_formatter(data.date_emission_facture, 'dd/mm/yyyy hh:mm');
                    client_facture = data.nom_utilisateur;
                    echeance_facture = data.echeance_facture + ' jours';
                    date_echeance_facture = date_formatter(data.date_echeance_facture, 'dd/mm/yyyy hh:mm');
                    montant_ht_facture = amount_format(data.montant_ht_facture);
                    tva_facture = amount_format(data.tva_facture);
                    montant_ttc_facture = amount_format(data.montant_ttc_facture);
                    montant_regle_facture = amount_format(data.montant_regle_facture);
                    solde_facture = amount_format(data.solde_facture);
                    created_at_facture = date_formatter(data.created_at_facture, 'dd/mm/yyyy hh:mm:ss');
                    updated_at_facture = date_formatter(data.updated_at_facture, 'dd/mm/yyyy hh:mm:ss');

                    statut_facture = data.statut_facture;
                    switch (statut_facture) {
                        case 'en attente':
                            statut_facture = `
                                <span class="badge badge-light-dark">En attente</span>
                            `;
                            break;
                        case 'en cour':
                            statut_facture = `
                                <span class="badge badge-light-primary">En cours</span>
                            `;
                            break;
                        case 'paye':
                            statut_facture = `
                                <span class="badge badge-light-success">Payé</span>
                            `;
                            break;

                        case 'relance':
                            statut_facture = `
                                <span class="badge badge-light-danger">Relance</span>
                            `;
                            break;
                    }

                    $('#detail_n_facture').html(n_facture);
                    $('#detail_type_facture').html(type_facture);
                    $('#detail_objet_facture').html(objet_facture);
                    $('#detail_created_at_facture').html(created_at_facture);
                    $('#detail_date_emission_facture').html(date_emission_facture);
                    $('#detail_client_facture').html(client_facture);
                    $('#detail_echeance_facture').html(echeance_facture);
                    $('#detail_date_echeance_facture').html(date_echeance_facture);
                    $('#detail_montant_ht_facture').html(montant_ht_facture);
                    $('#detail_tva_facture').html(tva_facture);
                    $('#detail_montant_ttc_facture').html(montant_ttc_facture);
                    $('#detail_montant_regle_facture').html(montant_regle_facture);
                    $('#detail_solde_facture').html(solde_facture);
                    $('#detail_statut_facture').html(statut_facture);
                    $('#detail_doc_created_by').html('<u>' + data.created_by_user + '</u>' + ' le ' + created_at_facture);
                    $('#detail_doc_updated_by').html('<u>' + data.updated_by_user + '</u>' + ' le ' + updated_at_facture);

                }
            });

        });

        // Lorsqu'on clique sur .emettre_facture
        $(document).on('click', '.emettre_facture', function(e) {
            e.preventDefault();
            var id_facture = $(this).data('id_facture');

            // Voulez-vous vraiment émettre cette facture ?
            Swal.fire({
                text: "Voulez-vous vraiment émettre cette facture ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, émettre !",
                cancelButtonText: "Non, annuler !",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-light btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "roll/ag/comptabilite/facture/fetch.php",
                        method: "POST",
                        data: {
                            id_facture: id_facture,
                            action: 'emettre_facture'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                // On recharge le datatable
                                reload_datatable('all_factures');

                                // On affiche un message de succès
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, j'ai compris !",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });
                            } else {
                                // On affiche un message d'erreur
                                Swal.fire({
                                    text: data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, j'ai compris !",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });
                            }
                        }
                    });
                }
            });

        });

        // Lorsqu'on clique sur .modifier_facture
        $(document).on('click', '.modifier_facture', function(e) {
            e.preventDefault();
            id_facture = $(this).data('id_facture');
            $('#form_modifier_facture input[name="id_facture"]').val(id_facture);

            // On vide le formulaire
            $('#form_modifier_facture')[0].reset();

            // On récupère les données de la facture
            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    id_facture: id_facture,
                    action: 'fetch_modifier_facture'
                },
                dataType: "JSON",
                success: function(data) {

                    // On remplit le formulaire
                    $('#modifier_facture_type').val(data.type_facture).trigger('change');
                    $('#modifier_facture_objet').val(data.objet_facture);
                    $('#modifier_facture_echeance').val(data.echeance_facture);
                    $('#modifier_facture_montant_ht').val(data.montant_ht_facture);
                    $('#modifier_facture_tva').val(data.tva_facture);
                    $('#modifier_facture_montant_ttc').val(data.montant_ttc_facture);
                }
            });

        });

        // Pour la modification d'une facture
        $(document).on('submit', '#form_modifier_facture', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_modifier_facture');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#modifier_facture_modal').modal('hide');

                            // toastr
                            toastr.success(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });

                            reload_datatable('all_factures'); // On recharge le datatable

                        } else {
                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .supprimer_facture
        $(document).on('click', '.supprimer_facture', function(e) {
            e.preventDefault();
            var id_facture = $(this).data('id_facture');

            // Voulez-vous vraiment supprimer cette facture ?
            Swal.fire({
                text: "Voulez-vous vraiment supprimer cette facture ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, supprimer !",
                cancelButtonText: "Non, annuler !",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-light btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "roll/ag/comptabilite/facture/fetch.php",
                        method: "POST",
                        data: {
                            id_facture: id_facture,
                            action: 'supprimer_facture'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                // On recharge le datatable
                                reload_datatable('all_factures');

                                // On affiche un message de succès
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, j'ai compris !",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });
                            } else {
                                // On affiche un message d'erreur
                                Swal.fire({
                                    text: data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, j'ai compris !",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });
                            }
                        }
                    });
                }
            });

        });

        // Lorsqu'on clique sur .encaisser_facture
        $(document).on('click', '.encaisser_facture', function() {
            $('#form_encaisser_facture')[0].reset();
            id_facture = $(this).data('id_facture');
            $('#form_encaisser_facture input[name="id_facture"]').val(id_facture);

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    id_facture: id_facture,
                    action: 'fetch_n_facture',
                },
                dataType: "JSON",
                success: function(data) {
                    $('#encaisser_facture_n').html(data);
                }
            });
        });

        // Pour l'ensaissement d'un paiement
        $(document).on('submit', '#form_encaisser_facture', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_encaisser_facture');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#encaisser_facture_modal').modal('hide');

                            // toastr
                            toastr.success(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });

                            reload_datatable('all_factures'); // On recharge le datatable

                        } else {
                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

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