<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

connected('client');

add_log('consultation', 'Consultation de la listes des interlocuteurs', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Interlocuteurs';
$titre_menu = 'Interlocuteurs';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "active";
$menu_collabo = "";
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
                            <h2>Tous les interlocuteurs</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar my-1">
                            <!-- begin::add btn interlo -->
                            <div id="add_interlocuteur" data-bs-toggle="modal" data-bs-target="#add_interlocuteur_modal" class="btn btn-sm btn-light btn-active-primary me-3">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>Ajouter un interlocuteur
                                <!--end::Svg Icon-->
                            </div>
                            <!-- end::add btn interlo -->
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
                            <table id="all_interlo" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr>
                                        <th class="min-w-100px">Interlocuteur</th>
                                        <th class="min-w-200px">Email</th>
                                        <th class="min-w-75px">Téléphone</th>
                                        <th class="min-w-100px">Fonction</th>
                                        <th class="min-w-75px">Statut</th>
                                        <th class="text-end">Action</th>
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

    <!-- begin::Modal Ajouter un interlocuteur-->
    <div class="modal fade" id="add_interlocuteur_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_interlocuteur" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter un interlocuteur</h4>
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
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Nom</label>
                            <input id="add_interlocuteur_nom" type="text" class="form-control form-control-solid" name="nom_interlocuteur" placeholder="Entrez le nom du interlocuteur" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Prenom</label>
                            <input id="add_interlocuteur_prenom" type="text" class="form-control form-control-solid" name="prenom_interlocuteur" placeholder="Entrez le prenom du interlocuteur" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Téléphone</label>
                            <input id="add_interlocuteur_tel" type="text" class="form-control form-control-solid" name="tel_interlocuteur" placeholder="Entrez un téléphone">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Fonction</label>
                            <input id="add_interlocuteur_fonction" type="text" class="form-control form-control-solid" name="fonction_interlocuteur" placeholder="Entrez une fonction">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Email</label>
                            <input id="add_interlocuteur_email" type="email" class="form-control form-control-solid" name="email_interlocuteur" placeholder="Entrez un email">
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_interlocuteur">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_interlocuteur" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Ajouter un interlocuteur-->

    <!-- begin::Modal Modifier un interlocuteur-->
    <div class="modal fade" id="edit_interlocuteur_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_edit_interlocuteur" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Modifier un interlocuteur</h4>
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
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Nom</label>
                            <input id="edit_interlocuteur_nom" type="text" class="form-control form-control-solid" name="nom_interlocuteur" placeholder="Entrez le nom du interlocuteur" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Prenom</label>
                            <input id="edit_interlocuteur_prenom" type="text" class="form-control form-control-solid" name="prenom_interlocuteur" placeholder="Entrez le prenom du interlocuteur" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Téléphone</label>
                            <input id="edit_interlocuteur_tel" type="text" class="form-control form-control-solid" name="tel_interlocuteur" placeholder="Entrez un téléphone">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="fs-5 mb-2">Fonction</label>
                            <input id="edit_interlocuteur_fonction" type="text" class="form-control form-control-solid" name="fonction_interlocuteur" placeholder="Entrez une fonction">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Email</label>
                            <input id="edit_interlocuteur_email" type="email" class="form-control form-control-solid" name="email_interlocuteur" placeholder="Entrez un email">
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_interlocuteur">
                    <input type="hidden" name="id_interlocuteur" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_interlocuteur" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Modifier un interlocuteur-->
    
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

            $("#all_interlo").DataTable().destroy();
            var all_interlo = $('#all_interlo').DataTable({
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
                all_interlo.search($(this).val()).draw();
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
                url: "roll/client/interlocuteurs/fetch.php",
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
            url: "roll/client/interlocuteurs/fetch.php",
            method: "POST",
            data: {
                datatable: 'all_interlo',
            },
            dataType: "JSON",
            success: function(data) {
                var all_interlo = $('#all_interlo').DataTable({
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
                    all_interlo.search($(this).val()).draw();
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
            var id_interlocuteur = $(this).data('id_interlocuteur'); // On récupère l'id de l'article

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
                        url: "roll/client/interlocuteurs/fetch.php",
                        method: "POST",
                        data: {
                            id_interlocuteur: id_interlocuteur,
                            action: 'activer_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_interlo'); // On recharge le datatable

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
            var id_interlocuteur = $(this).data('id_interlocuteur'); // On récupère l'id de l'article

            // Voulez-vous vraiment désactiver ce compte ?
            Swal.fire({
                title: "Voulez-vous vraiment désactiver ce compte ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, désactiver !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/client/interlocuteurs/fetch.php",
                        method: "POST",
                        data: {
                            id_interlocuteur: id_interlocuteur,
                            action: 'desactiver_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_interlo'); // On recharge le datatable

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

        // Lorsqu'on clique sur .supprimer_compte
        $(document).on('click', '.supprimer_compte', function(e) {
            e.preventDefault();
            var id_interlocuteur = $(this).data('id_interlocuteur'); // On récupère l'id de l'article

            // Voulez-vous vraiment supprimer ce compte ?
            Swal.fire({
                title: "Voulez-vous vraiment supprimer ce compte ?",
                text: "Vous ne pourrez plus revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui, supprimer !",
                cancelButtonText: "Non, annuler !",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "roll/client/interlocuteurs/fetch.php",
                        method: "POST",
                        data: {
                            id_interlocuteur: id_interlocuteur,
                            action: 'supprimer_compte'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_datatable('all_interlo'); // On recharge le datatable

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

        // Lorsqu'on clique sur #add_btn_interlocuteur
        $(document).on('click', '#add_btn_interlocuteur', function() {
            $('#form_add_interlocuteur')[0].reset();
        });

        // Pour l'ajout d'un nouveau interlocuteur
        $(document).on('submit', '#form_add_interlocuteur', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_add_interlocuteur');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/client/interlocuteurs/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#add_interlocuteur_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Interlocuteur ajouté !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_interlo'); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Lorsqu'on clique sur .edit_interlocuteur
        $(document).on('click', '.edit_interlocuteur', function(e) {
            e.preventDefault();
            id_interlocuteur = $(this).data('id_interlocuteur');
            $('#form_edit_interlocuteur input[name="id_interlocuteur"]').val(id_interlocuteur);

            // On vide le formulaire
            $('#form_edit_interlocuteur')[0].reset();

            // On récupère les infos interlocuteur
            $.ajax({
                url: "roll/client/interlocuteurs/fetch.php",
                method: "POST",
                data: {
                    id_interlocuteur: id_interlocuteur,
                    action: 'fetch_edit_interlocuteur'
                },
                dataType: "JSON",
                success: function(data) {

                    // On remplit le formulaire
                    $('#edit_interlocuteur_nom').val(data.nom_utilisateur);
                    $('#edit_interlocuteur_prenom').val(data.prenom_utilisateur);
                    $('#edit_interlocuteur_tel').val(data.tel_utilisateur);
                    $('#edit_interlocuteur_fonction').val(data.fonction_interlocuteur);
                    $('#edit_interlocuteur_email').val(data.email_utilisateur);
                }
            });

        });

        // Pour la modification d'un interlocuteur
        $(document).on('submit', '#form_edit_interlocuteur', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_interlocuteur');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/client/interlocuteurs/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            $('#edit_interlocuteur_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Infos de l'interlocuteur modifié !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_datatable('all_interlo'); // On recharge le datatable

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