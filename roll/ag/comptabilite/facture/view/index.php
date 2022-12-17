<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Comptabilité';
$titre_menu = 'Comptabilité';
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
        <div id="kt_app_content_container" class="app-container container-xxl pt-10">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bold">Détail facture</h2>
                            </div>
                            <!--begin::Card title-->
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
                                    <span class="fw-bold fs-1">--</span>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Moyen de paiement</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <!--begin::Card info-->
                                    <div class="fw-semibold text-gray-600 d-flex align-items-center">Mastercard
                                        <img src="assets/media/svg/card-logos/mastercard.svg" class="w-35px ms-2" alt="" />
                                    </div>
                                    <!--end::Card info-->
                                    <!--begin::Card expiry-->
                                    <div class="fw-semibold text-gray-600">Expires Dec 2024</div>
                                    <!--end::Card expiry-->
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

        // Reload all data pages and datatable
        function reloadPage() {

            // Fait une réquête AJAX pour récupérer les données de la page
            $.ajax({
                url: "roll/ag/comptabilite/facture/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_page_facture'
                },
                dataType: "JSON",
                success: function(data) {

                    // Affiche les données dans la page

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

            if (amount == null || amount == '') {
                return '';
            }

            var delimitter_str = "$1" + delimitter;
            return amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, delimitter_str);

        }

        // Fait une réquête AJAX pour récupérer les données de la page
        $.ajax({
            url: "roll/ag/comptabilite/facture/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_facture'
            },
            dataType: "JSON",
            success: function(data) {

                avatar_client = `
                    <img alt="Pic" src="assets/media/avatars/${data.avatar_utilisateur}" />
                `;
                client_facture = data.nom_utilisateur;
                client_email_facture = data.email_utilisateur;

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

                
            }
        });



    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>