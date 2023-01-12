<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

add_log('consultation', 'Consultation de la page de la facture #' . $_SESSION['id_view_facture'], $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Factures';
$titre_menu = 'Factures';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_saisie_client = "";
$menu_compta = "here show";
$menu_compta_facture = "active";
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
        <div id="kt_app_content_container" class="app-container container-xxl pt-10">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <div class="row">
                        <div class="col-md-4 rounded-3 p-3 mb-5">
                            <div class="card card-flush flex-column flex-stack py-5" style="background: linear-gradient(#f1416c 60%, #f5f8fa);">
                                <div class="text-white text-center fs-2 fw-bold">Facture échues</div>
                                <div class="text-center">
                                    <span id="view_facture_total_echue" class="text-light fw-bold fs-1 d-block">--</span>
                                    <span id="view_facture_nb_echue" class="text-dark fw-semibold fs-3">--</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 rounded-3 p-3 mb-5">
                            <div class="card card-flush bg-primary flex-column flex-stack py-5" style="background: linear-gradient(#009ef7 60%, #f5f8fa);">
                                <div class="text-white text-center fs-2 fw-bold">Facture en cours</div>
                                <div class="text-center">
                                    <span id="view_facture_total_en_cour" class="text-light fw-bold fs-1 d-block">--</span>
                                    <span id="view_facture_nb_en_cour" class="text-dark fw-semibold fs-3">--</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 rounded-3 p-3 mb-5">
                            <div class="card card-flush bg-success flex-column flex-stack py-5" style="background: linear-gradient(#50cd89 60%, #f5f8fa);">
                                <div class="text-white text-center fs-2 fw-bold">Facture soldés</div>
                                <div class="text-center">
                                    <span id="view_facture_total_solde" class="text-light fw-bold fs-1 d-block">--</span>
                                    <span id="view_facture_nb_solde" class="text-dark fw-semibold fs-3">--</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bold">Détail facture</h2>
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div id="actions_detail_facture" class="card-toolbar"></div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">N° Facture :</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a id="view_facture_n" href="#" class="text-gray-800 text-hover-primary">--</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Type de facture :</td>
                                                <td id="view_facture_type" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Objet de la facture :</td>
                                                <td id="view_facture_objet" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Date de creation :</td>
                                                <td id="view_facture_created_at" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Date d'emission :</td>
                                                <td id="view_facture_date_emission" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Echéance :</td>
                                                <td id="view_facture_echeance" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Date d'échance :</td>
                                                <td id="view_facture_date_echeance" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Montant HT :</td>
                                                <td id="view_facture_montant_ht" class="text-gray-800 min-w-200px">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">TVA :</td>
                                                <td id="view_facture_tva" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Montant TTC :</td>
                                                <td id="view_facture_montant_ttc" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Montant réglé :</td>
                                                <td id="view_facture_montant_regle" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Solde :</td>
                                                <td id="view_facture_solde" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Statut :</td>
                                                <td id="view_facture_statut" class="text-gray-800">--</td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Client</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div id="view_facture_avatar" class="symbol symbol-60px symbol-circle me-3"></div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <a id="view_facture_client" href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-2">--</a>
                                        <!--end::Name-->
                                        <!--begin::Email-->
                                        <a id="view_facture_email_client" href="#" class="fw-semibold text-gray-600 text-hover-primary">--</a>
                                        <!--end::Email-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Title-->
                                <h5 class="mb-4">Taux de recouvrement</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <span id="view_facture_taux_recouvrement" class="fw-bold fs-1">--</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-7" style="background-color: #abfdd0;">
                                <!--begin::Title-->
                                <h5 class="mb-4">Total facturé</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <span id="view_facture_total_facture" class="fw-bold fs-1">--</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-7" style="background-color: #abe5fd;">
                                <!--begin::Title-->
                                <h5 class="mb-4">Total réglé</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <span id="view_facture_total_regle" class="fw-bold fs-1">--</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

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
                                <option value="versement">Versement</option>
                                <option value="espece">Espèce</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label class="fs-5 mb-2">Montant TTC</label>
                            <input id="encaisser_paiement_montant_ttc" type="text" class="form-control form-control-solid" placeholder="Montant TTC" name="montant_ttc_paiement" required>
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

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        // Reload all data pages and datatable
        function reload_page() {

            // Fait une réquête AJAX pour récupérer les données de la page
            $.ajax({
                url: "roll/client/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_page_facture'
                },
                dataType: "JSON",
                success: function(data) {

                    id_facture = data.id_facture;
                    avatar_client = `
                        <img alt="Pic" src="assets/media/avatars/${data.avatar_utilisateur}" />
                    `;
                    client_facture = data.nom_utilisateur;
                    client_email_facture = data.email_utilisateur;
                    taux_recouvrement = data.taux_recouvrement;
                    total_facture = amount_format(data.total_facture);
                    total_regle = amount_format(data.total_regle);

                    total_echue = amount_format(data.total_echue);
                    nb_facture_echue = data.nb_facture_echue;
                    total_en_cour = amount_format(data.total_en_cour);
                    nb_facture_en_cour = data.nb_facture_en_cour;
                    total_solde = amount_format(data.total_solde);
                    nb_facture_solde = data.nb_facture_solde;

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
                    echeance_facture = data.echeance_facture + ' jours';
                    date_echeance_facture = date_formatter(data.date_echeance_facture, 'dd/mm/yyyy hh:mm');
                    montant_ht_facture = amount_format(data.montant_ht_facture);
                    tva_facture = amount_format(data.tva_facture);
                    montant_ttc_facture = amount_format(data.montant_ttc_facture);
                    montant_regle_facture = amount_format(data.montant_regle_facture);
                    solde_facture = amount_format(data.solde_facture);
                    created_at_facture = date_formatter(data.created_at_facture, 'dd/mm/yyyy hh:mm:ss');
                    updated_at_facture = date_formatter(data.updated_at_facture, 'dd/mm/yyyy hh:mm:ss');

                    action = '';
                    statut_facture = data.statut_facture;
                    switch (statut_facture) {
                        case 'en attente':
                            action = `
                                <div class="d-flex justify-content-end flex-shrink-0">                            
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="emettre_facture menu-link px-3" data-id_facture="${id_facture}">Émettre la facture</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            `;
                            break;
                        case 'en cour':
                            action = `
                                <div class="d-flex justify-content-end flex-shrink-0">                            
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="encaisser_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#encaisser_facture_modal" data-id_facture="${id_facture}">Encaisser facture</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            `;
                            break;
                        case 'paye':
                            action = `
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            `;
                            break;
                        case 'relance':
                            action = `
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                            `;
                            break;
                    }

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

                    // Affiche les données dans la page
                    $('#view_facture_avatar').html(avatar_client);
                    $('#view_facture_n').html(n_facture);
                    $('#view_facture_type').html(type_facture);
                    $('#view_facture_objet').html(objet_facture);
                    $('#view_facture_created_at').html(created_at_facture);
                    $('#view_facture_date_emission').html(date_emission_facture);
                    $('#view_facture_echeance').html(echeance_facture);
                    $('#view_facture_date_echeance').html(date_echeance_facture);

                    $('#view_facture_montant_ht').html(montant_ht_facture);
                    $('#view_facture_tva').html(tva_facture);
                    $('#view_facture_montant_ttc').html(montant_ttc_facture);
                    $('#view_facture_montant_regle').html(montant_regle_facture);
                    $('#view_facture_solde').html(solde_facture);
                    $('#view_facture_statut').html(statut_facture);

                    $('#view_facture_client').html(client_facture);
                    $('#view_facture_email_client').html(client_email_facture);
                    $('#view_facture_taux_recouvrement').html(taux_recouvrement + '%');
                    $('#view_facture_total_facture').html(total_facture);
                    $('#view_facture_total_regle').html(total_regle);

                    $('#view_facture_total_echue').html(total_echue);
                    $('#view_facture_nb_echue').html('(' + nb_facture_echue + ')');
                    $('#view_facture_total_en_cour').html(total_en_cour);
                    $('#view_facture_nb_en_cour').html('(' + nb_facture_en_cour + ')');
                    $('#view_facture_total_solde').html(total_solde);
                    $('#view_facture_nb_solde').html('(' + nb_facture_solde + ')');

                    $('#actions_detail_facture').html(action);

                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)


                }
            });

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

            if (amount == null || amount == '' || isNaN(amount)) {
                return '--';
            }

            var delimitter_str = "$1" + delimitter;
            return amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, delimitter_str);

        }

        // Fait une réquête AJAX pour récupérer les données de la page
        $.ajax({
            url: "roll/client/comptabilite/facture/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_facture'
            },
            dataType: "JSON",
            success: function(data) {

                id_facture = data.id_facture;
                avatar_client = `
                    <img alt="Pic" src="assets/media/avatars/${data.avatar_utilisateur}" />
                `;
                client_facture = data.nom_utilisateur;
                client_email_facture = data.email_utilisateur;
                taux_recouvrement = data.taux_recouvrement;
                total_facture = amount_format(data.total_facture);
                total_regle = amount_format(data.total_regle);

                total_echue = amount_format(data.total_echue);
                nb_facture_echue = data.nb_facture_echue;
                total_en_cour = amount_format(data.total_en_cour);
                nb_facture_en_cour = data.nb_facture_en_cour;
                total_solde = amount_format(data.total_solde);
                nb_facture_solde = data.nb_facture_solde;

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
                echeance_facture = data.echeance_facture + ' jours';
                date_echeance_facture = date_formatter(data.date_echeance_facture, 'dd/mm/yyyy hh:mm');
                montant_ht_facture = amount_format(data.montant_ht_facture);
                tva_facture = amount_format(data.tva_facture);
                montant_ttc_facture = amount_format(data.montant_ttc_facture);
                montant_regle_facture = amount_format(data.montant_regle_facture);
                solde_facture = amount_format(data.solde_facture);
                created_at_facture = date_formatter(data.created_at_facture, 'dd/mm/yyyy hh:mm:ss');
                updated_at_facture = date_formatter(data.updated_at_facture, 'dd/mm/yyyy hh:mm:ss');

                action = '';
                statut_facture = data.statut_facture;
                switch (statut_facture) {
                    case 'en attente':
                        action = `
                            <div class="d-flex justify-content-end flex-shrink-0">                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="emettre_facture menu-link px-3" data-id_facture="${id_facture}">Émettre la facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        `;
                        break;
                    case 'en cour':
                        action = `
                            <div class="d-flex justify-content-end flex-shrink-0">                            
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="encaisser_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#encaisser_facture_modal" data-id_facture="${id_facture}">Encaisser facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        `;
                        break;
                    case 'paye':
                        action = `
                            <div class="d-flex justify-content-end flex-shrink-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        `;
                        break;
                    case 'relance':
                        action = `
                            <div class="d-flex justify-content-end flex-shrink-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <!--begin::Menu 3-->
                                <div class="drop_action menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="modifier_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#modifier_facture_modal" data-id_facture="${id_facture}">Modifier facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="encaisser_facture menu-link px-3" data-bs-toggle="modal" data-bs-target="#encaisser_facture_modal" data-id_facture="${id_facture}">Encaisser facture</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="" class="supprimer_facture text-hover-danger menu-link px-3" data-id_facture="${id_facture}">Supprimer la facture</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        `;
                        break;
                }

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

                // Affiche les données dans la page
                $('#view_facture_avatar').html(avatar_client);
                $('#view_facture_n').html(n_facture);
                $('#view_facture_type').html(type_facture);
                $('#view_facture_objet').html(objet_facture);
                $('#view_facture_created_at').html(created_at_facture);
                $('#view_facture_date_emission').html(date_emission_facture);
                $('#view_facture_echeance').html(echeance_facture);
                $('#view_facture_date_echeance').html(date_echeance_facture);

                $('#view_facture_montant_ht').html(montant_ht_facture);
                $('#view_facture_tva').html(tva_facture);
                $('#view_facture_montant_ttc').html(montant_ttc_facture);
                $('#view_facture_montant_regle').html(montant_regle_facture);
                $('#view_facture_solde').html(solde_facture);
                $('#view_facture_statut').html(statut_facture);

                $('#view_facture_client').html(client_facture);
                $('#view_facture_email_client').html(client_email_facture);
                $('#view_facture_taux_recouvrement').html(taux_recouvrement + '%');
                $('#view_facture_total_facture').html(total_facture);
                $('#view_facture_total_regle').html(total_regle);

                $('#view_facture_total_echue').html(total_echue);
                $('#view_facture_nb_echue').html('(' + nb_facture_echue + ')');
                $('#view_facture_total_en_cour').html(total_en_cour);
                $('#view_facture_nb_en_cour').html('(' + nb_facture_en_cour + ')');
                $('#view_facture_total_solde').html(total_solde);
                $('#view_facture_nb_solde').html('(' + nb_facture_solde + ')');

                $('#actions_detail_facture').html(action);

                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)


            }
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
                        url: "roll/client/comptabilite/facture/fetch.php",
                        method: "POST",
                        data: {
                            id_facture: id_facture,
                            action: 'emettre_facture'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                // On recharge le datatable
                                reload_page();

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
                url: "roll/client/comptabilite/facture/fetch.php",
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
                url: "roll/client/comptabilite/facture/fetch.php",
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

                            reload_page(); // On recharge le datatable

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
                        url: "roll/client/comptabilite/facture/fetch.php",
                        method: "POST",
                        data: {
                            id_facture: id_facture,
                            action: 'supprimer_facture'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                // On recharge le datatable
                                reload_page();

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

                                // redirect
                                window.location.href = "roll/client/comptabilite/facture/";
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
                url: "roll/client/comptabilite/facture/fetch.php",
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
                url: "roll/client/comptabilite/facture/fetch.php",
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

                            reload_page(); // On recharge le datatable

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