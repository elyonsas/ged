<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

connected('client');

add_log('consultation', 'Consultation de la listes des collaborateur', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Collaborateurs';
$titre_menu = 'Collaborateurs';
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

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/client/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/client/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/client/include/sidebar.php');

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
                            <h2>Tous les collaborateurs</h2>
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
                            <table id="all_collabo" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="min-w-100px">Collaborateur</th>
                                        <th class="min-w-200px">Email</th>
                                        <th class="min-w-75px">Téléphone</th>
                                        <th class="min-w-50px">Dossier en charge</th>
                                        <th class="min-w-75px">Statut</th>
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
    
</div>
<!--end::Content wrapper-->


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/client/include/footer_activities.php'); ?>


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

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/client/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        function update_data_datatable(data) {

            $("#all_collabo").DataTable().destroy();
            var all_collabo = $('#all_collabo').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": true,
                "order": [],
                "data": data,
                "columnDefs": [{
                    "targets": [5],
                    "orderable": false,
                }, ],
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });
            $('#kt_filter_search').keyup(function() {
                all_collabo.search($(this).val()).draw();
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
                url: "roll/client/collaborateurs/fetch.php",
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

        // Datatable for all collaborateurs
        $.ajax({
            url: "roll/client/collaborateurs/fetch.php",
            method: "POST",
            data: {
                datatable: 'all_collabo',
            },
            dataType: "JSON",
            success: function(data) {
                var all_collabo = $('#all_collabo').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": true,
                    "order": [],
                    "data": data.data,
                    "columnDefs": [{
                        "targets": [5],
                        "orderable": false,
                    }, ],
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });
                $('#kt_filter_search').keyup(function() {
                    all_collabo.search($(this).val()).draw();
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
                        url: "roll/client/collaborateurs/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            action: 'activer_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_collabo'); // On recharge le datatable

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
                        url: "roll/client/collaborateurs/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            action: 'desactiver_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_collabo'); // On recharge le datatable

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
				url: "roll/client/collaborateurs/fetch.php",
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
				url: "roll/client/collaborateurs/fetch.php",
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

                            reload_datatable('all_collabo'); // On recharge le datatable

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