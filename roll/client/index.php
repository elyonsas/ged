<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('client');

add_log('consultation', 'Consultation de l\'accueil Client', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Accueil';
$titre_menu = 'Accueil';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "active";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
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
	<div id="kt_app_content" class="app-content flex-column-fluid pb-0">
		<!--begin::Content container-->
		<iframe src="https://elyonsas.com/" frameborder="0" width="100%" height="100%"></iframe>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>
<!--end::Content wrapper-->




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

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/client/include/pages_script.php'); ?>

<script>
	$(document).ready(function() {

		function update_data_datatable(data) {

			$("#secteur_activite_client").DataTable().destroy();
			var secteur_activite_client = $('#secteur_activite_client').DataTable({
				"processing": true,
				"serverSide": false,
				"paging": true,
				"bInfo": false,
				"bFilter": false,
				"bSort": true,
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

		function reload_datatable(datatable) {
			$.ajax({
				url: "roll/client/fetch.php",
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

		// Datatable for all dossiers
		$.ajax({
			url: "roll/client/fetch.php",
			method: "POST",
			data: {
				datatable: 'secteur_activite_client',
			},
			dataType: "JSON",
			success: function(data) {
				var secteur_activite_client = $('#secteur_activite_client').DataTable({
					"processing": true,
					"serverSide": false,
					"paging": true,
					"bInfo": false,
					"bFilter": false,
					"bSort": true,
					"order": [],
					"data": data.data,
					"pageLength": 7,
                	"lengthMenu": [7, 10, 15, 20],
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

		// Requete pour récupérer les infos du chart list_chart
		$.ajax({
			url: 'roll/client/fetch.php',
			method: 'POST',
			data: {
				stat_chart: 'list_chart',
			},
			dataType: 'json',
			success: function(data) {
				
				"use strict";
				var KTProjectList = {
					init: function () {
						! function () {
							var t = document.getElementById("kt_project_list_chart");
							if (t) {
								var e = t.getContext("2d");
								new Chart(e, {
									type: "doughnut",
									data: {
										datasets: [{
											data: [data.dec, data.dac, data.dc],
											backgroundColor: ["#00A3FF", "#50CD89", "#E4E6EF"]
										}],
										labels: ["DEC", "DAC", "DC"]
									},
									options: {
										chart: {
											fontFamily: "inherit"
										},
										borderWidth: 0,
										cutout: "75%",
										cutoutPercentage: 65,
										responsive: !0,
										maintainAspectRatio: !1,
										title: {
											display: !1
										},
										animation: {
											animateScale: !0,
											animateRotate: !0
										},
										stroke: {
											width: 0
										},
										tooltips: {
											enabled: !0,
											intersect: !1,
											mode: "nearest",
											bodySpacing: 5,
											yPadding: 10,
											xPadding: 10,
											caretPadding: 0,
											displayColors: !1,
											backgroundColor: "#20D489",
											titleFontColor: "#ffffff",
											cornerRadius: 4,
											footerSpacing: 0,
											titleSpacing: 0
										},
										plugins: {
											legend: {
												display: !1
											}
										}
									}
								})
							}
						}()
					}
				};
				KTUtil.onDOMContentLoaded((function () {
					KTProjectList.init()
				}));

			}
		});

		// Requete pour récupérer les infos du chart MixedWidget5
		$.ajax({
			url: 'roll/client/fetch.php',
			method: 'POST',
			data: {
				stat_chart: 'mixedwidget',
			},
			dataType: 'json',
			success: function(data) {
				stat_date_mixedwidget5 = [
					data.stat_date, data.stat_date_1, data.stat_date_2, data.stat_date_3,
					data.stat_date_4, data.stat_date_5
				];
				// Définir le widget pour la tendance
				var initMixedWidget5 = function() {
					var charts = document.querySelectorAll('.mixed-widget-5-chart');

					[].slice.call(charts).map(function(element) {
						var height = parseInt(KTUtil.css(element, 'height'));

						if (!element) {
							return;
						}

						var color = element.getAttribute('data-kt-chart-color');

						var labelColor = KTUtil.getCssVariableValue('--kt-' + 'gray-800');
						var strokeColor = KTUtil.getCssVariableValue('--kt-' + 'gray-300');
						var baseColor = KTUtil.getCssVariableValue('--kt-' + color);
						var lightColor = KTUtil.getCssVariableValue('--kt-' + color + '-light');

						var options = {
							series: [{
								name: 'Clients',
								// data: [30, 30, 60, 25, 25, 40],
								data: [
									data.stat_month_5, data.stat_month_4,
									data.stat_month_3, data.stat_month_2,
									data.stat_month_1, data.stat_month
								]
							}],
							chart: {
								fontFamily: 'inherit',
								type: 'area',
								height: height,
								toolbar: {
									show: false
								},
								zoom: {
									enabled: false
								},
								sparkline: {
									enabled: true
								}
							},
							plotOptions: {},
							legend: {
								show: false
							},
							dataLabels: {
								enabled: false
							},
							fill: {
								type: 'solid',
								opacity: 1
							},
							fill1: {
								type: 'gradient',
								opacity: 1,
								gradient: {
									type: "vertical",
									shadeIntensity: 0.5,
									gradientToColors: undefined,
									inverseColors: true,
									opacityFrom: 1,
									opacityTo: 0.375,
									stops: [25, 50, 100],
									colorStops: []
								}
							},
							stroke: {
								curve: 'smooth',
								show: true,
								width: 3,
								colors: [baseColor]
							},
							xaxis: {
								categories: [
									stat_date_mixedwidget5[5], stat_date_mixedwidget5[4], stat_date_mixedwidget5[3],
									stat_date_mixedwidget5[2], stat_date_mixedwidget5[1], stat_date_mixedwidget5[0]
								],
								axisBorder: {
									show: false,
								},
								axisTicks: {
									show: false
								},
								labels: {
									show: false,
									style: {
										colors: labelColor,
										fontSize: '12px'
									}
								},
								crosshairs: {
									show: false,
									position: 'front',
									stroke: {
										color: strokeColor,
										width: 1,
										dashArray: 3
									}
								},
								tooltip: {
									enabled: true,
									formatter: undefined,
									offsetY: 0,
									style: {
										fontSize: '12px'
									}
								}
							},
							yaxis: {
								min: 0,
								max: 105,
								labels: {
									show: false,
									style: {
										colors: labelColor,
										fontSize: '12px'
									}
								}
							},
							states: {
								normal: {
									filter: {
										type: 'none',
										value: 0
									}
								},
								hover: {
									filter: {
										type: 'none',
										value: 0
									}
								},
								active: {
									allowMultipleDataPointsSelection: false,
									filter: {
										type: 'none',
										value: 0
									}
								}
							},
							tooltip: {
								style: {
									fontSize: '12px'
								},
								y: {
									formatter: function(val) {
										return val + "%"
									}
								}
							},
							colors: [lightColor],
							markers: {
								colors: [lightColor],
								strokeColor: [baseColor],
								strokeWidth: 3
							}
						};

						var chart = new ApexCharts(element, options);
						chart.render();
					});
				}
				initMixedWidget5();

			}
		});

		// Pour l'ajout d'un nouveau secteur d'activité
		$(document).on('submit', '#form_add_secteur_activite_client', function(event) {
			event.preventDefault();

			// Show loading indication
			formSubmitButton = document.querySelector('#btn_add_secteur_activite_client');
			formSubmitButton.setAttribute('data-kt-indicator', 'on');

			$.ajax({
				url: "roll/client/fetch.php",
				method: "POST",
				data: $(this).serialize(),
				dataType: "JSON",
				success: function(data) {
					setTimeout(function() {
						// Hide loading indication
						formSubmitButton.removeAttribute('data-kt-indicator');

						if (data.success) {
							$('#add_secteur_activite_client_modal').modal('hide');

							// swal
                            Swal.fire({
                                title: "Secteur d'activité ajouté !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('secteur_activite_client'); // On recharge le datatable

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