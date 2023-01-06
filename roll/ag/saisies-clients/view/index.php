<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - MAJ comptabilité';
$titre_menu = 'Evolution de la mise à jour de la comptabilité';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_saisie_client = "active";
$menu_compta = "";
$menu_compta_facture = "";
$menu_compta_relance = "";

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

                        <!--begin::title-->
                        <div class="text-dark">
                            <h2 id="saisie_page_title">--</h2>
                        </div>
                        <!--begin::title-->
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

                                .wrapper-saisie {
                                    cursor: pointer;
                                    position: relative;
                                    box-sizing: border-box;
                                    min-width: 20px;
                                }

                                .wrapper-saisie .tooltip-saisie {
                                    min-width: 150px;
                                    position: absolute;
                                    bottom: 100%;
                                    left: calc(-75px + 10px);
                                    margin: 0px auto 15px;
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
                                .wrapper-saisie .tooltip-saisie:before {
                                    bottom: -20px;
                                    content: " ";
                                    display: block;
                                    height: 20px;
                                    left: 0;
                                    position: absolute;
                                    width: 100%;
                                }

                                /* CSS Triangles - see Trevor's post */
                                .wrapper-saisie .tooltip-saisie:after {
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

                                /* .wrapper-saisie:hover .tooltip-saisie {
                                    opacity: 1;
                                    pointer-events: auto;
                                    -webkit-transform: translateY(0px);
                                    -moz-transform: translateY(0px);
                                    -ms-transform: translateY(0px);
                                    -o-transform: translateY(0px);
                                    transform: translateY(0px);
                                } */

                                /* IE can just show/hide with no transition */
                                .lte8 .wrapper-saisie .tooltip-saisie {
                                    display: none;
                                }

                                .lte8 .wrapper-saisie:hover .tooltip-saisie {
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
                url: "roll/ag/saisies-clients/fetch.php",
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

        // Datatable for saisies-clients
        $.ajax({
            url: "roll/ag/saisies-clients/fetch.php",
            method: "POST",
            data: {
                datatable: 'saisies_clients',
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

        // Lorsqu'on clique sur .wrapper-saisie
        tooltip_showing = null;
        $(document).on('click', '.wrapper-saisie', function (e) {
            if (tooltip_showing == null) {
                $(this).find('.tooltip-saisie').css({
                    opacity: 1,
                    pointerEvents: 'auto',
                    transform: 'translateY(0px)',
                    webkitTransform: 'translateY(0px)',
                    mozTransform: 'translateY(0px)',
                    msTransform: 'translateY(0px)',
                    oTransform: 'translateY(0px)',
                });

                tooltip_showing = $(this).find('.tooltip-saisie');
            } else{
                tooltip_showing.css({
                    opacity: 0,
                    pointerEvents: 'none',
                    transform: 'translateY(10px)',
                    webkitTransform: 'translateY(10px)',
                    mozTransform: 'translateY(10px)',
                    msTransform: 'translateY(10px)',
                    oTransform: 'translateY(10px)',
                });

                tooltip_showing = null;
            }
        });


    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>