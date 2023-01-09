<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Dossiers de tavail';
$titre_menu = 'Dossiers de tavail';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "active";
$menu_interlo = "";
$menu_collabo = "";
$menu_saisie_client = "";
$menu_compta = "";
$menu_compta_facture = "";
$menu_compta_relance = "";

$data_client = $_GET['data_client'] ?? '';

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
                            <h2>Tous les clients</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar my-1">
                            <!-- begin::add btn client -->
                            <div id="add_btn_client" data-bs-toggle="modal" data-bs-target="#add_client_modal" class="btn btn-sm btn-light btn-active-primary me-3">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>Ajouter un client
                                <!--end::Svg Icon-->
                            </div>
                            <!-- end::add btn client -->
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
                            <table id="all_dossiers" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="min-w-150px">Client</th>
                                        <th class="min-w-75px">Matricule</th>
                                        <th class="min-w-50px">Prise en charge</th>
                                        <th class="min-w-50px">Statut</th>
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

    <!-- begin::Modal Ajouter un client-->
    <div class="modal fade" id="add_client_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_client" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter un client</h4>
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
                            <label class="fs-5 mb-2">Nom du client</label>
                            <input id="add_client_nom" type="text" class="form-control form-control-solid" name="nom_client" placeholder="Entrez le nom du client" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Adresse du client</label>
                            <input id="add_client_adresse" type="text" class="form-control form-control-solid" name="adresse_client" placeholder="Entrez une adresse">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Téléphone du client</label>
                            <input id="add_client_tel" type="text" class="form-control form-control-solid" name="tel_client" placeholder="Entrez une téléphone">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Email du client</label>
                            <input id="add_client_email" type="email" class="form-control form-control-solid" name="email_client" placeholder="Entrez un email">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Secteur d'activité principal</label>
                            <select id="add_client_secteur_activite" class="form-select form-select-solid" data-dropdown-parent="#add_client_modal" data-allow-clear="true" data-control="select2" data-placeholder="Sélectionnez le secteur d'activité du client" name="secteur_activite_client" required></select>
                        </div>
                    </div>


                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_client">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_client" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Ajouter un client-->

    <!-- begin::Modal Modifier client-->
    <div class="modal fade" id="edit_client_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_edit_client" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Modifier les informations du client</h4>
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
                            <label class="fs-5 mb-2">Nom du client</label>
                            <input id="edit_client_nom" type="text" class="form-control form-control-solid" name="nom_client" placeholder="Entrez le nom du client" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Adresse du client</label>
                            <input id="edit_client_adresse" type="text" class="form-control form-control-solid" name="adresse_client" placeholder="Entrez une adresse">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Téléphone du client</label>
                            <input id="edit_client_tel" type="text" class="form-control form-control-solid" name="tel_client" placeholder="Entrez une téléphone">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Email du client</label>
                            <input id="edit_client_email" type="email" class="form-control form-control-solid" name="email_client" placeholder="Entrez un email">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Secteur d'activité principal</label>
                            <select id="edit_client_secteur_activite" class="form-select form-select-solid" data-dropdown-parent="#edit_client_modal" data-allow-clear="true" data-control="select2" data-placeholder="Sélectionnez le secteur d'activité du client" name="secteur_activite_client" required></select>
                        </div>
                    </div>


                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_client">
                    <input type="hidden" name="id_client" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_client" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Modifier client-->

    <!-- begin::Modal attribuer collaborateur-->
    <div class="modal fade" id="attribuer_modal" tabindex="-1" role="dialog" aria-labelledby="attribuer_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_attribuer" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Attribuer collaborateur</h4>
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
                                Client :
                            </div>
                            <div id="attribuer_nom_client" class="fs-5 text-muted ms-3">--</div>
                        </div>
                        <!--begin::Input group-->
                        <div id="choisir_dossier" class="fv-row row mb-10">
                            <select id="attribuer_collabo" class="form-select form-select-solid" data-dropdown-parent="#attribuer_modal" data-allow-clear="true" data-control="select2" data-placeholder="Choisissez un collaborateur" name="id_collaborateur" required>

                            </select>
                        </div>
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_attribuer_collabo">
                        <input id="attribuer_id_client" type="hidden" name="id_client" value="">
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
    <!-- end::Modal attribuer collaborateur-->

    <!-- begin::Modal detail-->
	<div class="modal fade" id="detail_dossier_modal" tabindex="-1" role="dialog" aria-labelledby="detail_dossier_modal_title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<form method="POST" class="form modal-content" action="">
				<div class="modal-header p-5">
					<h4 class="modal-title">Détails client</h4>
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

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        function update_data_datatable(data) {

            $("#all_dossiers").DataTable().destroy();
            var all_dossiers = $('#all_dossiers').DataTable({
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
                all_dossiers.search($(this).val()).draw();
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
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    datatable: datatable,
                    data_client: `<?= $data_client ?>`,
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable(data.data);
                }
            })
        }

        // Datatable for all dossiers
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                datatable: 'all_dossiers',
                data_client: `<?= $data_client ?>`,
            },
            dataType: "JSON",
            success: function(data) {
                var all_dossiers = $('#all_dossiers').DataTable({
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
                    all_dossiers.search($(this).val()).draw();
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

        // fetch data secteur d'activité
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_secteur_activite',
            },
            dataType: "JSON",
            success: function(data) {
                $('#add_client_secteur_activite').html(data);
                $('#edit_client_secteur_activite').html(data);
            }
        });

        // Lorsqu'on clique sur #add_btn_client
        $(document).on('click', '#add_btn_client', function() {
            $('#form_add_client')[0].reset();
        });

        // Pour l'ajout d'un nouveau client
        $(document).on('submit', '#form_add_client', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_add_client');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#add_client_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Client ajouté !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_dossiers'); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .edit_client
        $(document).on('click', '.edit_client', function(e) {
            e.preventDefault();
            id_client = $(this).data('id_client');
            $('#form_edit_client input[name="id_client"]').val(id_client);

            // On vide le formulaire
            $('#form_edit_client')[0].reset();

            // On récupère les infos client
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_client: id_client,
                    action: 'fetch_edit_client'
                },
                dataType: "JSON",
                success: function(data) {

                    // On remplit le formulaire
                    $('#edit_client_nom').val(data.nom_utilisateur);
                    $('#edit_client_adresse').val(data.adresse_utilisateur);
                    $('#edit_client_tel').val(data.tel_utilisateur);
                    $('#edit_client_email').val(data.email_utilisateur);
                    $('#edit_client_secteur_activite').val(data.id_secteur_activite).trigger('change');
                }
            });

        });

        // Pour la modification d'un client
        $(document).on('submit', '#form_edit_client', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_client');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#edit_client_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Modification effectuée !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_dossiers'); // On recharge le datatable

                        } else {
                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .activer_compte
        $(document).on('click', '.activer_compte', function(e) {
            e.preventDefault();
            var id_client = $(this).data('id_client'); // On récupère l'id de l'article

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
                        url: "roll/ag/dossiers/fetch.php",
                        method: "POST",
                        data: {
                            id_client: id_client,
                            action: 'activer_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_dossiers'); // On recharge le datatable

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
            var id_client = $(this).data('id_client'); // On récupère l'id de l'article

            // Voulez-vous vraiment désactiver ce compte ?
            Swal.fire({
                title: "Voulez-vous vraiment désactiver ce compte ?",
                text: "Vous ne pouvez plus revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, désactiver !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/ag/dossiers/fetch.php",
                        method: "POST",
                        data: {
                            id_client: id_client,
                            action: 'desactiver_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_dossiers'); // On recharge le datatable

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

        // Lorsqu'on clique sur .view_detail_dossier
        $(document).on('click', '.view_detail_dossier', function(e) {
            e.preventDefault();
            var id_client = $(this).data('id_client');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_client: id_client,
                    action: 'view_detail_dossier'
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

        // Lorsqu'on clique sur .attribuer_collabo
        $(document).on('click', '.attribuer_collabo', function(e) {
            e.preventDefault();
            var id_client = $(this).data('id_client'); // On récupère l'id de l'article

            $.ajax({
				url: "roll/ag/dossiers/fetch.php",
				method: "POST",
				data: {
                    id_client: id_client,
                    action: 'fetch_attribuer_collabo'
				},
				dataType: "JSON",
				success: function(data) {
                    $('#attribuer_nom_client').html(data.nom_client);
                    $('#attribuer_collabo').html(data.dossier_html);
                    $('#attribuer_id_client').val(data.id_client);
				}
			});

        });

        // Pour l'attribution un collaborateur à un client
		$(document).on('submit', '#form_attribuer', function(event) {
			event.preventDefault();

			// Show loading indication
			formSubmitButton = document.querySelector('#btn_attribuer');
			formSubmitButton.setAttribute('data-kt-indicator', 'on');

			$.ajax({
				url: "roll/ag/dossiers/fetch.php",
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
                                title: "Dossier prise en charge !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_dossiers'); // On recharge le datatable

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


    })
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>