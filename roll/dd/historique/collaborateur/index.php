<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('dd');

add_log('consultation', 'Consultation de l\'historique des collaborateurs', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Historique des collaborateurs (Prise en charge de dossiers)';
$titre_menu = 'Historique des collaborateurs (Prise en charge de dossiers)';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_saisie_client = "";
$menu_compta = "";
$menu_compta_facture = "";
$menu_compta_relance = "";
$menu_hist = "here show";
$menu_hist_interlo = "";
$menu_hist_collabo = "active";

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/dd/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/dd/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/dd/include/sidebar.php');

?>



<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="container-xxl" id="kt_content_container">
				<!--begin::Card-->
				<div class="card card-flush mt-6 mt-xl-9">
					<!--begin::Card header-->
					<div class="card-header mt-5">
						<!--begin::Card title-->
						<div class="card-title flex-column">
							<h2>Historiques</h2>
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
							<table id="historiques" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
								<!--begin::Head-->
								<thead class="fs-7 text-gray-400 text-uppercase">
									<tr>
										<th class="min-w-100px">Client</th>
										<th class="min-w-100px">Collaborateur</th>
										<th class="">Fonction</th>
										<th class="">Téléphone</th>
										<th class="">Statut</th>
										<th class="">Debut</th>
										<th class="">Fin</th>
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
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>
<!--end::Content wrapper-->


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/dd/include/footer_activities.php'); ?>


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
<!-- <script src="assets/js/custom/widgets.js"></script> -->
<script src="assets/js/custom/apps/chat/chat.js"></script>
<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="assets/js/custom/utilities/modals/create-app.js"></script>
<script src="assets/js/custom/utilities/modals/new-target.js"></script>
<script src="assets/js/custom/utilities/modals/users-search.js"></script>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/dd/include/pages_script.php'); ?>

<script>
	$(document).ready(function() {
		function update_data_datatable(data) {

			$("#historiques").DataTable().destroy();
			var historiques = $('#historiques').DataTable({
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
				historiques.search($(this).val()).draw();
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
				url: "roll/dd/historique/collaborateur/fetch.php",
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

		// Datatable for all interlocuteurs
		$.ajax({
			url: "roll/dd/historique/collaborateur/fetch.php",
			method: "POST",
			data: {
				datatable: 'historiques',
			},
			dataType: "JSON",
			success: function(data) {
				var historiques = $('#historiques').DataTable({
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
					historiques.search($(this).val()).draw();
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
	});
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>