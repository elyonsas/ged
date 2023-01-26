<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

// Variables en sessions
$_SESSION['id_view_saisie_client'] = select_info('id_client', 'client', "id_utilisateur = {$_SESSION['id_utilisateur']}", $db);

add_log('consultation', 'Consultation de la page la saisie du client #' . $_SESSION['id_view_saisie_client'], $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - MAJ comptabilité';
$titre_menu = 'Evolution de la mise à jour de la comptabilité';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_demande = "";
$menu_saisie_client = "active";
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
                        <!--begin::option-->
                        <div class="align-items-start flex-column">
                            <!--begin::Select-->
                            <div class="me-6">
                                <select id="filter_annee_saisie" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm">
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <!--end::Select-->
                        </div>
                        <!--end::option-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar my-1">
                        </div>
                        <!--begin::Card toolbar-->

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <style>
                                .table>:not(caption)>*>* {
                                    padding: 0.3rem 0.3rem !important;
                                }

                                .table.table-bordered tr {
                                    border: 1px solid var(--kt-border-color);
                                }

                                .table.table-bordered tr:last-child td {
                                    border-bottom: 1px solid var(--kt-border-color) !important;
                                }

                                /* table{
                                    overflow: hidden;
                                } */

                                /* select the first td of line*/
                                td:first-child {
                                    line-height: 1.2;
                                }

                                /* select all td without the first td of line */
                                td:not(:first-child) {
                                    cursor: pointer;
                                    position: relative;
                                    box-sizing: border-box !important;
                                    min-width: 30px;
                                    font-size: 11px;
                                    text-align: center;
                                    color: var(--kt-text-muted);
                                }

                                /* le td doit apparaitre en premier plan de tout */
                                td .tooltip-saisie {
                                    min-width: 150px;
                                    position: absolute;
                                    z-index: 9999999;
                                    bottom: 100%;
                                    left: calc(-75px + 15px);
                                    margin: 0px auto 10px;
                                    opacity: 0;
                                    pointer-events: none;
                                    background: #fff;
                                    -webkit-transform: translateY(10px);
                                    -moz-transform: translateY(10px);
                                    -ms-transform: translateY(10px);
                                    -o-transform: translateY(10px);
                                    transform: translateY(10px);
                                    -webkit-transition: all .25s ease-out;
                                    -moz-transition: all .25s ease-out;
                                    -ms-transition: all .25s ease-out;
                                    -o-transition: all .25s ease-out;
                                    transition: all .25s ease-out;
                                    -webkit-box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.28);
                                    -moz-box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.28);
                                    -ms-box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.28);
                                    -o-box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.28);
                                    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.28);
                                }

                                /* This bridges the gap so you can mouse into the tooltip-saisie without it disappearing */
                                td .tooltip-saisie:before {
                                    bottom: -20px;
                                    content: " ";
                                    display: block;
                                    height: 20px;
                                    left: 0;
                                    position: absolute;
                                    width: 100%;
                                }

                                /* CSS Triangles - see Trevor's post */
                                td .tooltip-saisie:after {
                                    border-left: solid transparent 10px;
                                    border-right: solid transparent 10px;
                                    border-top: solid #fff 10px;
                                    bottom: -10px;
                                    content: " ";
                                    height: 0;
                                    left: 50%;
                                    margin-left: -13px;
                                    position: absolute;
                                    width: 0;
                                }

                                /* td:hover .tooltip-saisie {
                                    opacity: 1;
                                    pointer-events: auto;
                                    -webkit-transform: translateY(0px);
                                    -moz-transform: translateY(0px);
                                    -ms-transform: translateY(0px);
                                    -o-transform: translateY(0px);
                                    transform: translateY(0px);
                                } */

                                /* IE can just show/hide with no transition */
                                .lte8 td .tooltip-saisie {
                                    display: none;
                                }

                                .lte8 td:hover .tooltip-saisie {
                                    display: block;
                                }
                            </style>
                            <table id="saisies_clients" class="table table-bordered align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="min-w-100px"></th>
                                        <th colspan="3" class="text-center">Janv</th>
                                        <th colspan="3" class="text-center">Fevr</th>
                                        <th colspan="3" class="text-center">Mars</th>
                                        <th colspan="3" class="text-center">Avr</th>
                                        <th colspan="3" class="text-center">Mai</th>
                                        <th colspan="3" class="text-center">Juin</th>
                                        <th colspan="3" class="text-center">Juil</th>
                                        <th colspan="3" class="text-center">Août</th>
                                        <th colspan="3" class="text-center">Sept</th>
                                        <th colspan="3" class="text-center">Oct</th>
                                        <th colspan="3" class="text-center">Nov</th>
                                        <th colspan="3" class="text-center">DEC</th>
                                    </tr>
                                    <tr>
                                        <th class=""></th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                    </tr>
                                </thead>
                                <!--end::Head-->
                                <!--begin::Body-->
                                <tbody>

                                </tbody>
                                <!--end::Body-->
                            </table>
                            <!--end::Table-->
                            <!--begin::NB-->
                            <div class="d-flex fw-semibold me-5 mb-5">
                                <div class="fs-5 text-muted ms-3 fst-italic">
                                    <u>NB</u>: Si vous n'êtes pas satisfait, veuillez nous adressez un mail
                                </div>
                            </div>
                            <!--end::NB-->
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

    <!-- begin::Modal Ajouter une rubrique-->
    <div class="modal fade" id="add_rubrique_saisie_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_rubrique_saisie" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter une rubrique</h4>
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
                            <label class="fs-5 mb-2">Rubrique</label>
                            <input id="add_rubrique_saisie_nom" type="text" class="form-control form-control-solid" placeholder="Entrez une rubrique" name="rubrique_saisie" required>
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_rubrique_saisie">
                    <input type="hidden" name="annee_saisie" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_rubrique_saisie" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Ajouter une rubrique-->

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

        function update_data_datatable(data) {

            $("#saisies_clients").DataTable().destroy();
            var saisies_clients = $('#saisies_clients').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": false,
                "order": [],
                "data": data,
                "columnDefs": [],
                "pageLength": 15,
                "lengthMenu": [15, 20, 25, 50, 100],
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });

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
                url: "roll/client/saisies-clients/fetch.php",
                method: "POST",
                data: {
                    datatable: datatable,
                    annee_saisie: $('#filter_annee_saisie').val(),
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable(data.data);
                }
            })
        }

        // Fait une réquête AJAX pour récupérer les données
        $.ajax({
            url: "roll/client/saisies-clients/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_saisie'
            },
            dataType: "JSON",
            success: function(data) {

                // Affiche les données dans la page
                pageTitle = $('.page-title h1').html();
                $('.page-title h1').html(pageTitle + ' (' + data.nom_utilisateur + ')');

                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
            }
        });

        // Mettre la bonne année dans #filter_annee_saisie
        var date = new Date();
        var annee = date.getFullYear();
        $('#filter_annee_saisie').val(annee).trigger('change');

        // Datatable for saisies-clients
        $.ajax({
            url: "roll/client/saisies-clients/fetch.php",
            method: "POST",
            data: {
                datatable: 'saisies_clients',
                annee_saisie: $('#filter_annee_saisie').val(),
            },
            dataType: "JSON",
            success: function(data) {
                var saisies_clients = $('#saisies_clients').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": false,
                    "order": [],
                    "data": data.data,
                    "columnDefs": [],
                    "pageLength": 15,
                    "lengthMenu": [15, 20, 25, 50, 100],
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });

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

        // Lorsqu'on change la valeur de #filter_annee_saisie
        $('#filter_annee_saisie').on('change', function(event) {
            reload_datatable('saisies_clients');
        })

    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>