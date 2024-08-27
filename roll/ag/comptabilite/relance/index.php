<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/fonctions-sql.php');

connected('ag');

add_log('consultation', 'Consultation de la page de paramétrage des relances clients', $_SESSION['id_utilisateur'], $db);

$titre_page = 'GED-ELYON - Paramètre de relance';
$titre_menu = 'Paramètre de relance';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_saisie_client = "";
$menu_compta = "here show";
$menu_compta_facture = "";
$menu_compta_relance = "active";
$menu_hist = "";
$menu_hist_interlo = "";
$menu_hist_collabo = "";

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/ag/include/html_header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/ag/include/header.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/ag/include/sidebar.php');

?>



<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Container-->
            <div class="container-xxl px-20" id="kt_content_container">

                <!--begin::Alert-->
                <div class="alert alert-primary d-flex align-items-center p-3 mt-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2 svg-icon-primary me-3">
                        <svg class="bi bi-info-circle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h5 class="mb-1 text-primary">Définissez ici les paramètres pour la relance automatique des clients par mail</h5>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <span>Utilisez les variables globales disponible pour construire votre template de relance. Vous avez aussi la possibilité d'activer ou de désactiver la relance automatique des clients dans l'<a href="roll/ag/dossiers"><u><span style="font-weight: 500;">aspect comptable et financière</span></u></a> de leurs dossier de travail</span>
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
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{n_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{date_emission_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{montant_ttc_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{matricule_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{nom_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{nom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{prenom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{role_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{civilite_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{article_apres_civilite}</span>

                                <form id="edit_relance_temp_1_form" class="mt-5" method="POST" action="">
                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Objet du mail</label>
                                            <input id="edit_relance_temp_1_mail_objet" type="text" class="form-control" placeholder="Entrez l'objet du mail de relance" name="mail_objet">
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Contenu du mail</label>
                                            <textarea id="edit_relance_temp_1_mail_content" class="form-control" placeholder="Modèle de mail de relance" name="mail_content"></textarea>
                                        </div>
                                    </div>

                                    <div class="w-100 d-flex flex-end">
                                        <input type="hidden" name="action" value="edit_relance_temp_1">
                                        <button id="btn_edit_relance_temp_1" type="submit" class="btn btn-lg btn-primary ms-2">
                                            <span class="indicator-label">Sauvegarder</span>
                                            <span class="indicator-progress">Veuillez patienter...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="kt_accordion_1_header_2">
                            <button class="accordion-button fs-4 fw-semibold collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                                Deuxième relance ( 30 jours après l'échéance )
                            </button>
                        </h2>
                        <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body">
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{n_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{date_emission_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{montant_ttc_facture}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{matricule_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{nom_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{nom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{prenom_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{role_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{civilite_responsable_client}</span>
                                <span class="fs-5 badge badge-light mb-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="none">{article_apres_civilite}</span>

                                <form id="edit_relance_temp_2_form" class="mt-5" method="POST" action="">
                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Objet du mail</label>
                                            <input id="edit_relance_temp_2_mail_objet" type="text" class="form-control" placeholder="Entrez l'objet du mail de relance" name="mail_objet">
                                        </div>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="form-group">
                                            <label class="fs-5 mb-2">Contenu du mail</label>
                                            <textarea id="edit_relance_temp_2_mail_content" class="form-control" placeholder="Modèle de mail de relance" name="mail_content"></textarea>
                                        </div>
                                    </div>

                                    <div class="w-100 d-flex flex-end">
                                        <input type="hidden" name="action" value="edit_relance_temp_2">
                                        <button id="btn_edit_relance_temp_2" type="submit" class="btn btn-lg btn-primary ms-2">
                                            <span class="indicator-label">Sauvegarder</span>
                                            <span class="indicator-progress">Veuillez patienter...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>

                                </form>
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


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/ag/include/footer_activities.php'); ?>


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
<script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/roll/ag/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        function reload_page() {
            // Fait une réquête AJAX pour récupérer les données de la page
            $.ajax({
                url: "roll/ag/comptabilite/relance/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_page_param_relance'
                },
                dataType: "JSON",
                success: function(data) {

                    // Affiche les données dans la page (form 1)
                    $('#edit_relance_temp_1_mail_objet').val(data[0].mail_objet);
                    $('#edit_relance_temp_1_mail_content').html(data[0].mail_content);

                    // Affiche les données dans la page (form 2)
                    $('#edit_relance_temp_2_mail_objet').val(data[1].mail_objet);
                    $('#edit_relance_temp_2_mail_content').html(data[1].mail_content);

                    // Initialise les instances de tinymce
                    tinymce.init({
                        selector: '#edit_relance_temp_1_mail_content',
                        menubar: false,
                        language: 'fr_FR',
                        height: 450,
                        content_css: 'default',
                        // plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                        toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | fontselect fontsizeselect formatselect | numlist bullist | outdent indent | pagebreak | table',
                        pagebreak_separator: '<div style="page-break-after: always;"></div>',
                    });

                    tinymce.init({
                        selector: '#edit_relance_temp_2_mail_content',
                        menubar: false,
                        language: 'fr_FR',
                        height: 450,
                        content_css: 'default',
                        // plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                        toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | fontselect fontsizeselect formatselect | numlist bullist | outdent indent | pagebreak | table',
                        pagebreak_separator: '<div style="page-break-after: always;"></div>',
                    });

                }
            });

        }

        // Fait une réquête AJAX pour récupérer les données de la page
        $.ajax({
            url: "roll/ag/comptabilite/relance/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_param_relance'
            },
            dataType: "JSON",
            success: function(data) {

                // Affiche les données dans la page (form 1)
                $('#edit_relance_temp_1_mail_objet').val(data[0].mail_objet);
                $('#edit_relance_temp_1_mail_content').html(data[0].mail_content);

                // Affiche les données dans la page (form 2)
                $('#edit_relance_temp_2_mail_objet').val(data[1].mail_objet);
                $('#edit_relance_temp_2_mail_content').html(data[1].mail_content);

                // Initialise les instances de tinymce
                tinymce.init({
                    selector: '#edit_relance_temp_1_mail_content',
                    menubar: false,
                    language: 'fr_FR',
                    height: 450,
                    content_css: 'default',
                    // plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                    toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | fontselect fontsizeselect formatselect | numlist bullist | outdent indent | pagebreak | table',
                    pagebreak_separator: '<div style="page-break-after: always;"></div>',
                });

                tinymce.init({
                    selector: '#edit_relance_temp_2_mail_content',
                    menubar: false,
                    language: 'fr_FR',
                    height: 450,
                    content_css: 'default',
                    // plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                    toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | fontselect fontsizeselect formatselect | numlist bullist | outdent indent | pagebreak | table',
                    pagebreak_separator: '<div style="page-break-after: always;"></div>',
                });

            }
        });

        // Lorsqu'on soumet le formulaire #edit_relance_temp_1_form
        $(document).on('submit', '#edit_relance_temp_1_form', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_relance_temp_1');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/comptabilite/relance/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            toastr.success(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        // Lorsqu'on soumet le formulaire #edit_relance_temp_2_form
        $(document).on('submit', '#edit_relance_temp_2_form', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_relance_temp_2');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: "roll/ag/comptabilite/relance/fetch.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(data) {
                    setTimeout(function() {
                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        if (data.success) {
                            toastr.success(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });

                        } else {
                            toastr.error(data.message, '', {
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