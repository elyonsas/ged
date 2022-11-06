<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Collaborateur';
$titre_menu = 'Collaborateur';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_collabo = "active";
$menu_compta = "";

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/sidebar.php');

?>



<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid pt-10">
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Details-->
                        <div class="d-flex flex-wrap flex-sm-nowrap">
                            <!--begin: Pic-->
                            <div class="me-7 mb-4">
                                <div id="avatar_collaborateur" class="symbol symbol-100px symbol-fixed position-relative"></div>
                            </div>
                            <!--end::Pic-->
                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <!--begin::User-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <div class="d-flex align-items-center mb-2">
                                            <a id="nom_prenom_collaborateur" href="roll/ag/collaborateurs/view" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">--</a>
                                        </div>
                                        <!--end::Name-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                            <a id="" href="" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
                                                        <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <span id="email_collaborateur">--</span>
                                            </a>
                                        </div>
                                        <!--end::Info-->
                                        <!-- begin:niveau -->
                                        <div id="niveau_collaborateur"></div>
                                        <!-- end:niveau -->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center">
                                        <div id="statut_collaborateur" class="me-5">
                                        </div>
                                        <div id="action_collaborateur">
                                        </div>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                            <!--begin::Nav item-->
                            <li class="nav-item mt-2">
                                <a id="generale_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5 active" href="">Générale</a>
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item mt-2">
                                <a id="avance_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5" href="">Avancé</a>
                            </li>
                            <!--end::Nav item-->
                        </ul>
                        <!--end::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Row Générale-->
                <div id="infos_generale" class="row g-5 g-xxl-8">
                    <!--begin::Col-->
                    <div class="col-lg-5">
                        <!--begin::Feeds Widget 2-->
                        <div class="card mb-5 mb-xxl-8">
                            <!--begin::Body-->
                            <div class="card-body pb-0">
                                <!--begin::Header-->
                                <div class="d-flex align-items-center mb-5">
                                    <h2>Infos collaborateur</h2>
                                </div>
                                <!--end::Header-->
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Code collaborateur :
                                            <span id="code_collaborateur" class="text-gray-400 fw-bold"></span>
                                        </div>
                                        <!--begin::copy-btn-->
                                        <button id="code_collaborateur_copy_btn" type="button" data-clipboard-target="#code_collaborateur" data-bs-toggle="popover" data-bs-placement="top" title="" data-bs-content="Copié !" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary">
                                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-07-151451/core/html/src/media/icons/duotune/general/gen054.svg-->
                                            <span id="code_article_copy_icon" class="svg-icon svg-icon-muted svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::copy-btn-->
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">Date de naissance : </div>
                                        <div id="date_naiss_collaborateur" class="text-gray-400 fs-3 fw-bold ms-3"></div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">Téléphone : </div>
                                        <div id="tel_collaborateur" class="text-gray-400 fs-3 fw-bold ms-3"></div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">Adresse : </div>
                                        <div id="adresse_collaborateur" class="text-gray-400 fs-3 fw-bold ms-3"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Feeds Widget 2-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-lg-7">
                        <!--begin::Charts Widget 1-->
                        <div class="card mb-5 mb-xxl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Dossiers en charges</span>
                                    <!-- <span class="text-muted fw-semibold fs-7">Plus de 100 articles validés</span> -->
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0">
                                <!--begin::Chart-->
                                <!-- <div id="kt_charts_widget_1_chart" style="height: 350px"></div> -->
                                <!--end::Chart-->

                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table id="dossiers_collabo" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="">#</th>
                                                <th class="min-w-200px">Client</th>
                                                <th class="min-w-100px">Matricule</th>
                                                <th class="">Rôle</th>
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
                            <!--end::Body-->
                        </div>
                        <!--end::Charts Widget 1-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row Générale-->

                <!--begin::Row Avancé-->
                <div id="infos_avance" class="row g-5 g-xxl-8">

                </div>
                <!--end::Row Avancé-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!-- begin::Modal attribuer dossier-->
    <div class="modal fade" id="attribuer_modal" tabindex="-1" role="dialog" aria-labelledby="attribuer_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_attribuer" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Attribution de dossier</h4>
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
                        <div class="d-flex fw-semibold me-5 mb-5 align-items-center">
                            <div class="fs-5">
                                Collaborateur :
                            </div>
                            <div id="attribuer_nom_collaborateur" class="fs-5 text-muted ms-3">
                                Ismael Badarou
                            </div>
                        </div>
                        <!--begin::Input group-->
                        <div id="choisir_dossier" class="fv-row row mb-10">
                            <select id="attribuer_dossier" class="form-select form-select-solid" data-dropdown-parent="#attribuer_modal" data-allow-clear="true" data-control="select2" data-placeholder="Choisissez un dossier" name="id_client" required>

                            </select>
                        </div>
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_attribuer_dossier">
                        <input id="attribuer_id_collaborateur" type="hidden" name="id_collaborateur" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_attribuer" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- end::Modal attribuer dossier-->

    	<!-- begin::Modal detail-->
	<div class="modal fade" id="detail_dossier_modal" tabindex="-1" role="dialog" aria-labelledby="detail_dossier_modal_title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<form method="POST" class="form modal-content" action="">
				<div class="modal-header p-5">
					<h4 class="modal-title">Détails</h4>
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
								<label class="fs-3 fw-bold">CLIENT</label>
								<div id="detail_nom_client" class="fs-5 text-muted"></div>
							</div>
							<!--end::item-->
						</div>
						<div class="d-flex flex-stack mb-5">
							<!--begin::item-->
							<div class="me-5 fw-semibold">
								<label class="fs-3 fw-bold">MATRICULE</label>
								<div id="detail_matricule_client" class="fs-5 text-muted"></div>
							</div>
							<!--end::item-->
						</div>
						<div class="d-flex flex-stack mb-5">
							<!--begin::item-->
							<div class="me-5 fw-semibold">
								<label class="fs-3 fw-bold">TELEPHONE</label>
								<div id="detail_telephone_client" class="fs-5 text-muted"></div>
							</div>
							<!--end::item-->
						</div>
						<div class="d-flex flex-stack mb-5">
							<!--begin::item-->
							<div class="me-5 fw-semibold">
								<label class="fs-3 fw-bold">EMAIL</label>
								<div id="detail_email_client" class="fs-5 text-muted"></div>
							</div>
							<!--end::item-->
						</div>
                        <div class="d-flex flex-stack mb-5">
							<!--begin::item-->
							<div class="me-5 fw-semibold">
								<label class="fs-3 fw-bold">ADRESSE</label>
								<div id="detail_adresse_client" class="fs-5 text-muted"></div>
							</div>
							<!--end::item-->
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- end::Modal detail-->

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

<script>
    $(document).ready(function() {

        function update_data_datatable(data) {

            $("#dossiers_collabo").DataTable().destroy();
            var dossiers_collabo = $('#dossiers_collabo').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": false,
                "bInfo": false,
                "bFilter": false,
                "bSort": false,
                "order": [],
                "data": data,
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

        function reload_datatables(datatable) {
            $.ajax({
                url: "roll/ag/collaborateurs/fetch.php",
                method: "POST",
                data: {
                    datatable: datatable,
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable(data);
                }
            })
        }

        // Fait une réquête AJAX pour récupérer les données
        $.ajax({
            url: "roll/ag/collaborateurs/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_collaborateur'
            },
            dataType: "JSON",
            success: function(data) {

                // Affiche les données dans la page
                $('#avatar_collaborateur').html(data.avatar_collaborateur);
                $('#nom_prenom_collaborateur').html(data.nom_prenom_collaborateur);
                $('#email_collaborateur').html(data.email_collaborateur);
                $('#code_collaborateur').html(data.code_collaborateur);
                $('#date_naiss_collaborateur').html(data.date_naiss_collaborateur);
                $('#tel_collaborateur').html(data.tel_collaborateur);
                $('#adresse_collaborateur').html(data.adresse_collaborateur);
                $('#statut_collaborateur').html(data.statut_collaborateur);
                $('#action_collaborateur').html(data.action_collaborateur);
                $('#niveau_collaborateur').html(data.niveau_collaborateur);

                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
            }
        });

        // Datatable for dossiers collaborateur
        $.ajax({
            url: "roll/ag/collaborateurs/fetch.php",
            method: "POST",
            data: {
                datatable: 'dossiers_collabo',
            },
            dataType: "JSON",
            success: function(data) {
                var dossiers_collabo = $('#dossiers_collabo').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": false,
                    "bInfo": false,
                    "bFilter": false,
                    "bSort": false,
                    "order": [],
                    "data": data,
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

        function reloadPage() {

            // Fait une réquête AJAX pour récupérer les données
            $.ajax({
                url: "roll/ag/collaborateurs/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_page_collaborateur'
                },
                dataType: "JSON",
                success: function(data) {

                    // Affiche les données dans la page
                    $('#avatar_collaborateur').html(data.avatar_collaborateur);
                    $('#nom_prenom_collaborateur').html(data.nom_prenom_collaborateur);
                    $('#email_collaborateur').html(data.email_collaborateur);
                    $('#code_collaborateur').html(data.code_collaborateur);
                    $('#date_naiss_collaborateur').html(data.date_naiss_collaborateur);
                    $('#tel_collaborateur').html(data.tel_collaborateur);
                    $('#adresse_collaborateur').html(data.adresse_collaborateur);
                    $('#statut_collaborateur').html(data.statut_collaborateur);
                    $('#action_collaborateur').html(data.action_collaborateur);
                    $('#niveau_collaborateur').html(data.niveau_collaborateur);

                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });

            reload_datatables('dossiers_collabo');

        }

        // Afficher les infos selon la zone cliquée (generale, avance)
        $(document).on('click', '#generale_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active de l'element #avance_area_btn
            $('#avance_area_btn').removeClass('active');
            // ajout de la classe active de l'element #generale_area_btn
            $('#generale_area_btn').addClass('active');

            // supprimer d-none de l'element #infos_generale
            $('#infos_generale').removeClass('d-none');
            // ajouter d-none à l'element #infos_avance
            $('#infos_avance').addClass('d-none');
        })

        $(document).on('click', '#avance_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active de l'element #generale_area_btn
            $('#generale_area_btn').removeClass('active');
            // ajout de la classe active de l'element #avance_area_btn
            $('#avance_area_btn').addClass('active');

            // supprimer d-none de l'element #infos_avance
            $('#infos_avance').removeClass('d-none');
            // ajouter d-none à l'element #infos_generale
            $('#infos_generale').addClass('d-none');
        })

        // Pour la copie du code de l'article
        var KTModalShareEarn = function() {
            // Private functions
            var handleForm = function() {
                var button = document.querySelector('#code_collaborateur_copy_btn');
                var input = document.querySelector('#code_collaborateur');
                var clipboard = new ClipboardJS(button);

                if (!clipboard) {
                    return;
                }

                //  Copy text to clipboard. For more info check the plugin's documentation: https://clipboardjs.com/
                clipboard.on('success', function(e) {

                    console.log("Copied: " + e.text);

                    e.clearSelection();
                });
            }

            // Public methods
            return {
                init: function() {
                    handleForm();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTModalShareEarn.init();
        });

        // Lorsqu'on clique sur .activer_compte
        $(document).on('click', '.activer_compte', function(e) {
            e.preventDefault();
            var id_collaborateur = $(this).data('id_collaborateur'); // On récupère l'id de l'article

            // Voulez-vous vraiment activer ce compte ?
            Swal.fire({
                title: "Voulez-vous vraiment activer ce compte ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, activer !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/ag/collaborateurs/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            action: 'activer_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reloadPage(); // On recharge le datatable

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
            });

        });

        // Lorsqu'on clique sur .desactiver_compte
        $(document).on('click', '.desactiver_compte', function(e) {
            e.preventDefault();
            var id_collaborateur = $(this).data('id_collaborateur'); // On récupère l'id de l'article

            // Voulez-vous vraiment désactiver ce compte ?
            Swal.fire({
                title: "Voulez-vous vraiment désactiver ce compte ?",
                text: "Tous les dossiers de ce collaborateur ne seront plus pris en charge !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, désactiver !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/ag/collaborateurs/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            action: 'desactiver_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reloadPage(); // On recharge le datatable

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
            });

        });

        // Lorsqu'on clique sur .attribuer_dossier
        $(document).on('click', '.attribuer_dossier', function(e) {
            e.preventDefault();
            var id_collaborateur = $(this).data('id_collaborateur'); // On récupère l'id de l'article

            $.ajax({
                url: "roll/ag/collaborateurs/fetch.php",
                method: "POST",
                data: {
                    id_collaborateur: id_collaborateur,
                    action: 'fetch_attribuer_dossier'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#attribuer_nom_collaborateur').html(data.nom_collaborateur);
                    $('#attribuer_dossier').html(data.dossier_html);
                    $('#attribuer_id_collaborateur').val(data.id_collaborateur);
                }
            });

        });

        // Pour l'attribution un dossier à un collaborateur
        $(document).on('submit', '#form_attribuer', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_attribuer');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/collaborateurs/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#attribuer_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Dossier attribué !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reloadPage(); // On recharge le datatable

                        } else {
                            $('#attribuer_modal').modal('hide');

                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .retirer_dossier
        $(document).on('click', '.retirer_dossier', function(e) {
            e.preventDefault();
            var id_collaborateur = $(this).data('id_collaborateur');
            var id_client = $(this).data('id_client');

            // Voulez-vous vraiment retirer ce dossier ?
            Swal.fire({
                title: "Voulez-vous vraiment retirer ce dossier ?",
                text: "Ce dossier ne sera plus pris en charge par ce collaborateur !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, retirer !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/ag/collaborateurs/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            id_client: id_client,
                            action: 'retirer_dossier'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reloadPage(); // On recharge le datatable

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
            });

        });

        // Lorsqu'on clique sur .detail_dossier
        $(document).on('click', '.detail_dossier', function(e) {
            e.preventDefault();
            var id_client = $(this).data('id_client');

            $.ajax({
                url: "roll/ag/collaborateurs/fetch.php",
                method: "POST",
                data: {
                    id_client: id_client,
                    action: 'detail_dossier'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#detail_nom_client').html(data.nom_client);
                    $('#detail_matricule_client').html(data.matricule_client);
                    $('#detail_telephone_client').html(data.tel_client);
                    $('#detail_email_client').html(data.email_client);
                    $('#detail_adresse_client').html(data.adresse_client);
                }
            });

        });


    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>