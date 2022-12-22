<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Paramètre de relance';
$titre_menu = 'Paramètre de relance';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_compta = "here show";
$menu_compta_facture = "";
$menu_compta_relance = "active";

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

                <!--begin::Alert-->
                <div class="alert alert-primary d-flex align-items-center p-3 mt-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2 svg-icon-primary me-3">
                        <svg class="bi bi-info-circle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h5 class="mb-1 text-primary">Définissez ici les paramètres pour les relances automatiques client par mail</h5>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <span>Utilisez les variables globals disponible pour construire votre template de relance. Vous avez aussi la possibilité d'activer ou de désactiver la relance automatique des clients dans l'<a href="roll/ag/dossiers"><u><span style="font-weight: 500;">aspect comptable et financière</span></u></a> de leurs dossier de travail</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Alert-->

                <!--begin::Accordion-->
                <div class="accordion" id="kt_accordion_1">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_1_header_1">
                            <button class="accordion-button fs-4 fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                Première relance ( 5 jours après l'échéance )
                            </button>
                        </h2>
                        <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body">
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{n_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{date_emission_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{montant_ttc_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{matricule_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{nom_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{nom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{prenom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{role_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{civilite_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" 
                                data-bs-dismiss="click" title="none">{article_apres_civilite}</span>

                                <form id="relance_temp_1" class="mt-5" method="POST" action="">
                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Objet du mail</label>
                                            <input id="relance_temp_1_mail_objet" type="text" class="form-control" placeholder="Entrez l'objet du mail de relance" name="mail_objet">
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Contenu du mail</label>
                                            <textarea id="relance_temp_1_mail_content" class="form-control" placeholder="Modèle de mail de relance" name="mail_content"></textarea>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_1_header_2">
                            <button class="accordion-button fs-4 fw-semibold collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                                Première relance ( 5 jours après l'échéance )
                            </button>
                        </h2>
                        <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Accordion-->

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