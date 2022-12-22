<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Client';
$titre_menu = 'Client';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "";

$menu_dt = "active";
$menu_interlo = "";
$menu_collabo = "";
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
        <div id="kt_app_content_container" class="app-container container-fluid pt-10">
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Details-->
                        <div class="d-flex flex-wrap flex-sm-nowrap">
                            <!--begin: Pic-->
                            <div class="me-7 mb-4 d-flex flex-center">
                                <div id="avatar_client" class="symbol symbol-100px symbol-fixed position-relative"></div>
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
                                            <a id="nom_client" href="roll/ag/clients/view" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">--</a>
                                        </div>
                                        <!--end::Name-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column fw-semibold fs-6 mb-4 pe-2">
                                            <div class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
                                                        <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <span id="email_client">--</span>
                                            </div>
                                            <div class="d-flex align-items-center text-gray-400 mb-1">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/arrows/arr024.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 4L18 12L10 20H14L21.3 12.7C21.7 12.3 21.7 11.7 21.3 11.3L14 4H10Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M3 4L11 12L3 20H7L14.3 12.7C14.7 12.3 14.7 11.7 14.3 11.3L7 4H3Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="d-flex">
                                                    <span class="min-w-250px">Aspects juridiques et administratifs</span>
                                                    <div id="ready_icon_juridiques_et_administratifs">...</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-gray-400 mb-1">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/arrows/arr024.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 4L18 12L10 20H14L21.3 12.7C21.7 12.3 21.7 11.7 21.3 11.3L14 4H10Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M3 4L11 12L3 20H7L14.3 12.7C14.7 12.3 14.7 11.7 14.3 11.3L7 4H3Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="d-flex">
                                                    <span class="min-w-250px">Aspects techniques</span>
                                                    <div id="ready_icon_techniques">...</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-gray-400 mb-1">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-29-094551/core/html/src/media/icons/duotune/arrows/arr024.svg-->
                                                <span class="svg-icon svg-icon-4 me-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 4L18 12L10 20H14L21.3 12.7C21.7 12.3 21.7 11.7 21.3 11.3L14 4H10Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M3 4L11 12L3 20H7L14.3 12.7C14.7 12.3 14.7 11.7 14.3 11.3L7 4H3Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="d-flex">
                                                    <span class="min-w-250px">Aspects comptables et financiers</span>
                                                    <div id="ready_icon_comptables_et_financiers">...</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                        <!-- begin:niveau -->
                                        <div id="niveau_client"></div>
                                        <!-- end:niveau -->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center">
                                        <div id="statut_client" class="me-5">
                                        </div>
                                        <div id="action_client">
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
                            <li class="nav-item mt-2 flex-column position-relative">
                                <a id="generale_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5 active" href="">Générale</a>
                                <div style="cursor: not-allowed;" id="mask_generale_area_btn" class="w-100 h-100 position-absolute d-none" 
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Générale"></div>
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item mt-2 flex-column position-relative">
                                <a id="juridico_admin_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5" href="">Aspects juridiques et administratifs</a>
                                <div style="cursor: not-allowed;" id="mask_juridico_admin_area_btn" class="w-100 h-100 position-absolute d-none" 
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Aspects juridiques et administratifs"></div>
                            </li>
                            <!--end::Nav item-->

                            <!--begin::Nav item-->
                            <li class="nav-item mt-2 flex-column position-relative">
                                <a id="technique_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5" href="">Aspects techniques</a>
                                <div style="cursor: not-allowed;" id="mask_technique_area_btn" class="w-100 h-100 position-absolute d-none" 
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Vous devez valider l'aspect juridiques et administratifs de ce dossier client"></div>
                            </li>
                            <!--end::Nav item-->

                            <!--begin::Nav item-->
                            <li class="nav-item mt-2 flex-column position-relative">
                                <a id="compta_finance_area_btn" class="nav-link text-active-primary ms-0 me-10 py-5" href="">Aspects comptables et financiers</a>
                                <div style="cursor: not-allowed;" id="mask_compta_finance_area_btn" class="w-100 h-100 position-absolute d-none" 
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Vous devez valider l'aspect technique de ce dossier client"></div>
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
                                    <h2>Infos client</h2>
                                </div>
                                <!--end::Header-->
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Matricule :
                                            <span id="matricule_client" class="text-gray-400 fw-bold"></span>
                                        </div>
                                        <!--begin::copy-btn-->
                                        <button id="matricule_client_copy_btn" type="button" data-clipboard-target="#matricule_client" data-bs-toggle="popover" data-bs-placement="top" title="" data-bs-content="Copié !" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary">
                                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-07-151451/core/html/src/media/icons/duotune/general/gen054.svg-->
                                            <span id="code_article_copy_icon" class="svg-icon svg-icon-muted svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::copy-btn-->
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            IFU :
                                            <span id="ifu_entite" class="text-gray-400 fw-bold">--</span>
                                        </div>
                                        <!--begin::copy-btn-->
                                        <button id="ifu_entite_copy_btn" type="button" data-clipboard-target="#ifu_entite" data-bs-toggle="popover" data-bs-placement="top" title="" data-bs-content="Copié !" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary">
                                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-07-151451/core/html/src/media/icons/duotune/general/gen054.svg-->
                                            <span id="code_article_copy_icon" class="svg-icon svg-icon-muted svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::copy-btn-->
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Désignation de l'entité :
                                            <span id="designation_entite" class="text-gray-400 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Téléphone :
                                            <span id="tel_client" class="text-gray-400 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Boîte postale :
                                            <span id="boite_postal" class="text-gray-400 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Activité principale :
                                            <span id="designation_activite_principale" class="text-gray-400 fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="text-gray-900 fs-3 fw-bold">
                                            Adresse géographique complète :
                                            <span id="adresse_geo_complete" class="text-gray-400 fw-bold"></span>
                                        </div>
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
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xxl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Collaborateurs en charge</span>
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
                                    <table id="collabos_dossier" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="">#</th>
                                                <th class="min-w-200px">Collaborateur</th>
                                                <th class="">Téléphone</th>
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
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row Générale-->

                <!--begin::Row juridico_admin-->
                <div id="infos_juridico_admin" class="row g-5 g-xxl-8 d-none">
                    <div class="col-xl-12">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xxl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <!--begin::Title-->
                                <div class="align-items-start flex-column">
                                    <!--begin::Select-->
                                    <div class="me-6 my-1">
                                        <select id="filter_type_dossier_document2" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm">
                                            <option value="all" selected="selected">Tous les documents</option>
                                            <option value="permanent">Dossier permanent</option>
                                            <option value="general">Dossier général de contrôle annuel</option>
                                        </select>
                                    </div>
                                    <!--end::Select-->
                                </div>
                                <!--end::Title-->

                                <!--begin::Card toolbar-->
                                <div class="card-toolbar my-1">
                                    <!-- begin::add btn document -->
                                    <div id="add_btn_document" data-bs-toggle="modal" data-bs-target="#add_doc_modal" class="btn btn-sm btn-light btn-active-primary me-3">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                            </svg>
                                        </span>Ajouter un document
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!-- end::add btn document -->
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
                                        <input type="text" id="kt_filter_search2" class="form-control form-control-solid form-select-sm w-150px ps-9" placeholder="Rechercher...">
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card toolbar-->
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
                                    <table id="documents_juridico_admin" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="min-w-200px">Document</th>
                                                <th class="">Dernière modification</th>
                                                <th class="">statut</th>
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
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Row juridico_admin-->

                <!--begin::Row technique-->
                <div id="infos_technique" class="row g-5 g-xxl-8 d-none">
                    <div class="col-xl-12">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xxl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <!--begin::Title-->
                                <div class="d-flex">
                                    <!--begin::Select-->
                                    <div class="me-3 my-1">
                                        <select id="filter_type_dossier_document3" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm">
                                            <option value="all" selected="selected">Tous les documents</option>
                                            <option value="permanent">Dossier permanent</option>
                                            <option value="general">Dossier général de contrôle annuel</option>
                                        </select>
                                    </div>
                                    <!--end::Select-->

                                    <!--begin::Select-->
                                    <div class="me-3 my-1">
                                        <select id="filter_rubrique_document3" data-control="select2" class="form-select form-select-solid form-select-sm">
                                            <option value="all" selected="selected">Toutes les rubriques</option>
                                            <option value="connaissance_generale_client">Connaissance générale du Client</option>
                                            <option value="documents_juridiques_client">Documents juridiques sur le Client</option>
                                            <option value="organisation_comptable_client">Organisation comptable du Client</option>
                                            <option value="documents_comptables_client">Documents comptables du Client</option>
                                            <option value="documents_fiscaux_client">Documents fiscaux du Client</option>
                                            <option value="documents_sociaux_client">Documents sociaux du Client</option>
                                            <option value="documents_gestion_client">Documents de Gestion du Client</option>
                                            <option value="prepare_mission_annee">Préparation de la mission au titre de la nouvelle année</option>
                                            <option value="exam_coherence_vraisemblance">Examen de cohérence et de vraisemblance</option>
                                            <option value="synthese_mission_rapport">Synthèse de la mission et rapports</option>
                                        </select>
                                    </div>
                                    <!--end::Select-->
                                </div>
                                <!--end::Title-->

                                <!--begin::Card toolbar-->
                                <div class="card-toolbar my-1">
                                    <!-- begin::add btn document -->
                                    <div data-bs-toggle="modal" data-bs-target="#add_doc_modal" class="btn btn-sm btn-light btn-active-primary me-3">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                            </svg>
                                        </span>Ajouter un document
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!-- end::add btn document -->
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
                                        <input type="text" id="kt_filter_search3" class="form-control form-control-solid form-select-sm w-150px ps-9" placeholder="Rechercher...">
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card toolbar-->
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
                                    <table id="documents_techniques" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                            <tr>
                                                <th class="min-w-200px">Document</th>
                                                <th class="">Dernière modification</th>
                                                <th class="">statut</th>
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
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Row technique-->

                <!--begin::Row compta_finance-->
                <div id="infos_compta_finance" class="row g-5 g-xxl-8 d-none">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Engage widget 10-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                                <!--begin::Wrapper-->
                                <div class="mb-10">
                                    <div class="d-flex justify-content-between flex-wrap fs-2hx fw-bold text-gray-800 text-center mb-13">
                                        <div class="me-2">Taux de recouvrement<br>
                                            <span class="position-relative d-inline-block text-danger">
                                                <a id="view_facture_taux_recouvrement" href="#" class="text-dark opacity-75-hover">--</a>
                                                <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-primary border-bottom w-100"></span>
                                            </span>
                                        </div>
                                        <div class="mb-7 min-w-250px p-3" style="background-color: #abfdd0;">
                                            <!--begin::Title-->
                                            <h5 class="mb-4">Total facturé</h5>
                                            <!--end::Title-->
                                            <!--begin::Details-->
                                            <div class="mb-0">
                                                <span id="view_facture_total_facture" class="fw-bold fs-1">--</span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <div class="mb-7 min-w-250px p-3" style="background-color: #abe5fd;">
                                            <!--begin::Title-->
                                            <h5 class="mb-4">Total réglé</h5>
                                            <!--end::Title-->
                                            <!--begin::Details-->
                                            <div class="mb-0">
                                                <span id="view_facture_total_regle" class="fw-bold fs-1">--</span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 rounded-3 p-3 mb-5">
                                            <div class="card card-flush flex-column flex-stack py-5" style="background: linear-gradient(#f1416c 60%, #f5f8fa);">
                                                <div class="text-white text-center fs-2 fw-bold">Facture échues</div>
                                                <div class="text-center">
                                                    <span id="view_facture_total_echue" class="text-light fw-bold fs-1 d-block">--</span>
                                                    <span id="view_facture_nb_echue" class="text-dark fw-semibold fs-3">--</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 rounded-3 p-3 mb-5">
                                            <div class="card card-flush bg-primary flex-column flex-stack py-5" style="background: linear-gradient(#009ef7 60%, #f5f8fa);">
                                                <div class="text-white text-center fs-2 fw-bold">Facture en cours</div>
                                                <div class="text-center">
                                                    <span id="view_facture_total_en_cour" class="text-light fw-bold fs-1 d-block">--</span>
                                                    <span id="view_facture_nb_en_cour" class="text-dark fw-semibold fs-3">--</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 rounded-3 p-3 mb-5">
                                            <div class="card card-flush bg-success flex-column flex-stack py-5" style="background: linear-gradient(#50cd89 60%, #f5f8fa);">
                                                <div class="text-white text-center fs-2 fw-bold">Facture soldés</div>
                                                <div class="text-center">
                                                    <span id="view_facture_total_solde" class="text-light fw-bold fs-1 d-block">--</span>
                                                    <span id="view_facture_nb_solde" class="text-dark fw-semibold fs-3">--</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Action-->
                                    <div class="text-center">
                                        <div class="info_relance btn btn-sm btn-dark fw-bold" data-bs-toggle="modal" data-bs-target="#edit_info_relance_modal">Informations de relance</div>
                                    </div>
                                    <!--begin::Action-->
                                </div>
                                <!--begin::Wrapper-->
                                <!--begin::Illustration-->
                                <img class="mx-auto h-150px h-lg-250px theme-light-show" src="assets/media/illustrations/misc/upgrade.svg" alt="" />
                                <img class="mx-auto h-150px h-lg-250px theme-dark-show" src="assets/media/illustrations/misc/upgrade-dark.svg" alt="" />
                                <!--end::Illustration-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Engage widget 10-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row compta_finance-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <style>
        /* Pour permettre aux instances de tinymce d'avoir une hauteur max */
        .doc-content>.fv-row.row,
        .doc-content>.fv-row.row>.tox.tox-tinymce {
            height: 100% !important;
        }
    </style>

    <!-- begin::Modal attribuer collaborateur-->
    <div class="modal fade" id="attribuer_modal" tabindex="-1">
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
    <div class="modal fade" id="detail_dossier_modal" tabindex="-1">
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

    <!-- begin::Modal detail-->
    <div class="modal fade" id="detail_collabo_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Détails collaborateur</h4>
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
                                <label class="fs-3 fw-bold">COLLABORATEUR</label>
                                <div id="detail_collaborateur" class="fs-5 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">CODE COLLABORATEUR</label>
                                <div id="detail_code_collaborateur" class="fs-5 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">TELEPHONE</label>
                                <div id="detail_telephone_collaborateur" class="fs-5 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">EMAIL</label>
                                <div id="detail_email_collaborateur" class="fs-5 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-3 fw-bold">ADRESSE</label>
                                <div id="detail_adresse_collaborateur" class="fs-5 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end::Modal detail-->


    <!-- begin::Modal Ajouter un document-->
    <div class="modal fade" id="add_doc_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_doc" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter un document</h4>
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
                            <label class="fs-5 mb-2">Titre du document</label>
                            <input id="id_add_doc_titre_document" type="text" class="form-control form-control-solid" placeholder="Entrez le titre du document" name="titre_document">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group">
                            <label class="fs-5 mb-2">Description (facultative)</label>
                            <textarea id="id_add_doc_description_document" class="form-control form-control-solid" rows="3" placeholder="Entrez une description du document" name="description_document"></textarea>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="fs-5 mb-2">Type du document</label>

                        <div class="form-group col-6">
                            <!--begin::Col-->
                            <label class="form-check-clip text-center w-100">
                                <input id="id_add_doc_type_document_file" class="btn-check" type="radio" value="file" required name="type_document" />
                                <div class="form-check-wrapper w-100">
                                    <div class="form-check-indicator"></div>
                                    <div class="form-check-content fw-semibold text-start bg-light-primary rounded border-primary border border-dashed p-6">
                                        <span class="text-dark fw-bold d-block fs-3">Fichier</span>
                                        <span class="text-muted fw-semibold fs-6">Téléversez un fichier</span>
                                    </div>
                                </div>
                            </label>
                            <!--end::Col-->
                        </div>

                        <div class="form-group col-6">
                            <!--begin::Col-->
                            <label class="form-check-clip text-center w-100">
                                <input id="id_add_doc_type_document_write" class="btn-check" type="radio" value="write" required name="type_document" />
                                <div class="form-check-wrapper w-100">
                                    <div class="form-check-indicator"></div>
                                    <div class="form-check-content fw-semibold text-start bg-light-primary rounded border-primary border border-dashed p-6">
                                        <span class="text-dark fw-bold d-block fs-3">Écrire</span>
                                        <span class="text-muted fw-semibold fs-6">Rédigez dans le logiciel</span>
                                    </div>
                                </div>
                            </label>
                            <!--end::Col-->
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="form-group col-6">
                            <label class="fs-5 mb-2">Type de dossier</label>
                            <select id="id_add_doc_type_dossier" class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" name="type_dossier">
                                <option value="permanent">Permanent</option>
                                <option value="general">Général de contrôle annuel</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label class="fs-5 mb-2">Rubrique (Facultative)</label>
                            <select id="id_add_doc_rubrique" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionnez une rubrique" data-hide-search="true" name="rubrique">
                                <option></option>
                                <option value="connaissance_generale_client">Connaissance générale du Client</option>
                                <option value="documents_juridiques_client">Documents juridiques sur le Client</option>
                                <option value="organisation_comptable_client">Organisation comptable du Client</option>
                                <option value="documents_comptables_client">Documents comptables du Client</option>
                                <option value="documents_fiscaux_client">Documents fiscaux du Client</option>
                                <option value="documents_sociaux_client">Documents sociaux du Client</option>
                                <option value="documents_gestion_client">Documents de Gestion du Client</option>
                                <option value="prepare_mission_annee">Préparation de la mission au titre de la nouvelle année</option>
                                <option value="exam_coherence_vraisemblance">Examen de cohérence et de vraisemblance</option>
                                <option value="synthese_mission_rapport">Synthèse de la mission et rapports</option>
                            </select>
                        </div>
                    </div>

                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_doc">
                    <input type="hidden" name="aspect" value="juridiques_et_administratifs">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_doc" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Ajouter un document-->

    <!-- begin::Modal detail-->
    <div class="modal fade" id="detail_document_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Détail du document</h4>
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
                        <div id="equipe_detail_area" class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Aspect : <span id="detail_doc_aspect" class="fs-5 text-muted">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Code document : <span id="detail_doc_code" class="fs-5 text-muted">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Titre du document :</label>
                                <div id="detail_doc_titre" class="fs-6 text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Statut document : <span id="detail_doc_statut" class="">--</span></label>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Document créé par :</label>
                                <div id="detail_doc_created_by" class="fs-6 fst-italic text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::item-->
                            <div class="me-5 fw-semibold">
                                <label class="fs-4">Dernière modification par :</label>
                                <div id="detail_doc_updated_by" class="fs-6 fst-italic text-muted"></div>
                            </div>
                            <!--end::item-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end::Modal detail-->

    <!--begin::Modal - preview-->
    <div class="modal fade" id="preview_doc_write_modal" tabindex="-1">
        <style>
            #preview_doc_write_modal li {
                white-space: nowrap !important;
            }

            #preview_doc_write_modal .doc-content {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif
            }

            @media screen {
                #preview_doc_write_modal .modal-header {
                    margin: 1rem auto 0;
                    min-width: 25%;
                    max-width: 90%;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                }

                #preview_doc_write_modal .modal-body {
                    background: #f8f9fa;
                    min-height: 100%
                }

                #preview_doc_write_modal .document-top-shadow {
                    background: linear-gradient(to bottom, rgba(0, 0, 0, .1), transparent);
                    height: 15px;
                }

                #preview_doc_write_modal .doc-content {
                    background-color: #fff;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                    box-sizing: border-box;
                    margin: 1rem auto 0;
                    max-width: 820px;
                    min-height: calc(100vh - 1rem);
                    padding: 4rem 6rem 6rem 6rem
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Modal body-->
                    <div class="doc-content">

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - preview-->

    <!--begin::Modal - preview-->
    <div class="modal fade" id="preview_doc_generate_modal" tabindex="-1">
        <style>
            #preview_doc_generate_modal li {
                white-space: nowrap !important;
            }

            #preview_doc_generate_modal .doc-content {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif
            }

            @media screen {

                #preview_doc_generate_modal .modal-header {
                    margin: 1rem auto 0;
                    min-width: 25%;
                    max-width: 90%;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                }

                #preview_doc_generate_modal .doc-content {
                    background-color: #fff;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                    box-sizing: border-box;
                    margin: 15px auto 0;
                    max-width: 1050px;
                    min-height: 75%;
                    padding: 15px;
                }

                #preview_doc_generate_modal .document-top-shadow {
                    background: linear-gradient(to bottom, rgba(0, 0, 0, .1), transparent);
                    height: 15px;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Modal body-->
                    <div class="doc-content">

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - preview-->

    <!--begin::Modal - preview-->
    <div class="modal fade" id="preview_doc_file_modal" tabindex="-1">
        <style>
            @media screen {
                #preview_doc_file_modal .modal-header {
                    margin: 1rem auto 0;
                    min-width: 25%;
                    max-width: 90%;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                }

                #preview_doc_file_modal .modal-body {
                    background: #d1d1d1;
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                }

                #preview_doc_file_modal .doc-content {
                    height: 100%;
                }
            }

            #preview_doc_file_modal .refresh-preview {
                position: relative;
                left: 75px;
                cursor: pointer;
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content h-100">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->

                    <div class="refresh-preview btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualiser">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-09-043348/core/html/src/media/icons/duotune/arrows/arr029.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.5 20.7259C14.6 21.2259 14.2 21.826 13.7 21.926C13.2 22.026 12.6 22.0259 12.1 22.0259C9.5 22.0259 6.9 21.0259 5 19.1259C1.4 15.5259 1.09998 9.72592 4.29998 5.82592L5.70001 7.22595C3.30001 10.3259 3.59999 14.8259 6.39999 17.7259C8.19999 19.5259 10.8 20.426 13.4 19.926C13.9 19.826 14.4 20.2259 14.5 20.7259ZM18.4 16.8259L19.8 18.2259C22.9 14.3259 22.7 8.52593 19 4.92593C16.7 2.62593 13.5 1.62594 10.3 2.12594C9.79998 2.22594 9.4 2.72595 9.5 3.22595C9.6 3.72595 10.1 4.12594 10.6 4.02594C13.1 3.62594 15.7 4.42595 17.6 6.22595C20.5 9.22595 20.7 13.7259 18.4 16.8259Z" fill="currentColor" />
                                <path opacity="0.3" d="M2 3.62592H7C7.6 3.62592 8 4.02592 8 4.62592V9.62589L2 3.62592ZM16 14.4259V19.4259C16 20.0259 16.4 20.4259 17 20.4259H22L16 14.4259Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Modal body-->
                    <div class="doc-content">

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - preview-->

    <!--begin::Modal - preview-->
    <div class="modal fade" id="preview_doc_scan_modal" tabindex="-1">
        <style>
            @media screen {
                #preview_doc_scan_modal .modal-header {
                    margin: 1rem auto 0;
                    min-width: 25%;
                    max-width: 90%;
                    box-shadow: 0 0 4px rgba(0, 0, 0, .15);
                }

                #preview_doc_scan_modal .modal-body {
                    background: #d1d1d1;
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                }

                #preview_doc_scan_modal .doc-content {
                    height: 100%;
                }
            }

            #preview_doc_scan_modal .refresh-preview {
                position: relative;
                left: 75px;
                cursor: pointer;
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content h-100">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->

                    <div class="refresh-preview btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualiser">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-09-043348/core/html/src/media/icons/duotune/arrows/arr029.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.5 20.7259C14.6 21.2259 14.2 21.826 13.7 21.926C13.2 22.026 12.6 22.0259 12.1 22.0259C9.5 22.0259 6.9 21.0259 5 19.1259C1.4 15.5259 1.09998 9.72592 4.29998 5.82592L5.70001 7.22595C3.30001 10.3259 3.59999 14.8259 6.39999 17.7259C8.19999 19.5259 10.8 20.426 13.4 19.926C13.9 19.826 14.4 20.2259 14.5 20.7259ZM18.4 16.8259L19.8 18.2259C22.9 14.3259 22.7 8.52593 19 4.92593C16.7 2.62593 13.5 1.62594 10.3 2.12594C9.79998 2.22594 9.4 2.72595 9.5 3.22595C9.6 3.72595 10.1 4.12594 10.6 4.02594C13.1 3.62594 15.7 4.42595 17.6 6.22595C20.5 9.22595 20.7 13.7259 18.4 16.8259Z" fill="currentColor" />
                                <path opacity="0.3" d="M2 3.62592H7C7.6 3.62592 8 4.02592 8 4.62592V9.62589L2 3.62592ZM16 14.4259V19.4259C16 20.0259 16.4 20.4259 17 20.4259H22L16 14.4259Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Modal body-->
                    <div class="doc-content">

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - preview-->

    <!-- begin::Modal edit_doc_write -->
    <div class="modal fade" id="edit_doc_write_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_write_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_write_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_write_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_write" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_write" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_write_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_write">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_write -->

    <!-- begin::Modal edit_doc_other_write -->
    <div class="modal fade" id="edit_doc_other_write_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_other_write_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_other_write_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_other_write_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_other_write" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_other_write" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_other_write_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_write">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_other_write -->

    <!-- begin::Modal edit_doc_file -->
    <div class="modal fade" id="edit_doc_file_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_file" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #file_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="file_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_file">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_file" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_file -->

    <!-- begin::Modal edit_doc_other_file -->
    <div class="modal fade" id="edit_doc_other_file_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_other_file" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #other_file_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="other_file_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_file">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_other_file" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_other_file -->

    <!-- begin::Modal edit_doc_scan -->
    <div class="modal fade" id="edit_doc_scan_modal" tabindex="-1">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form id="form_edit_doc_scan" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Dropzone-->
                            <style>
                                #scan_upload_zone .dropzone-select {
                                    min-height: auto;
                                    padding: 1.5rem 1.75rem !important;
                                    text-align: center !important;
                                    border: 1px dashed var(--kt-primary);
                                    background-color: var(--kt-primary-light) !important;
                                    border-radius: 0.475rem !important;
                                }

                                .dz-drag-hover {
                                    opacity: 0.5;
                                }

                                .dz-drag-hover .dropzone-select {
                                    border-style: solid !important;
                                }
                            </style>
                            <div class="dropzone dropzone-queue mb-2" id="scan_upload_zone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <div class="dropzone-select">
                                        <!--begin::Icon-->
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <!--end::Icon-->

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Glissez déposez un fichier ici ou cliquez pour importer.</h3>
                                            <span class="fs-7 fw-semibold text-gray-400">Importer un seul fichier</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">

                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">Choisissez un document pdf, word, excel ou une image. </br> (Tailles maximal de fichier : 10MB)</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="opt d-flex justify-content-end">
                        <input type="hidden" name="action" value="edit_doc_scan">
                        <input type="hidden" name="id_document" value="">
                        <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                        <button id="btn_edit_doc_scan" type="submit" class="btn btn-lg btn-primary ms-2">
                            <span class="indicator-label">Valider</span>
                            <span class="indicator-progress">Veuillez patienter...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_scan -->

    <!-- begin::Modal edit_doc_generate -->
    <div class="modal fade" id="edit_doc_generate_modal" tabindex="-1">
        <style>
            @media screen {
                #edit_doc_generate_modal .modal-body {
                    height: 100%;
                    margin: 0px;
                    padding: 0px;
                    overflow: hidden;
                }

                #edit_doc_generate_modal .doc-content {
                    width: 100%;
                    height: 100%;
                }

                #edit_doc_generate_modal .loader {
                    background-color: white;
                    position: absolute;
                    opacity: 0.95;
                    width: 100%;
                    height: 100%;
                    z-index: 100;
                }
            }
        </style>
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <!--begin::Modal content-->
            <form id="form_edit_doc_generate" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="document-top-shadow w-100"></div>
                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="loader">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="assets/media/loaders/elyon_loader.gif" alt="loader">
                        </div>
                    </div>
                    <div class="doc-content">
                        <!--begin::Input group-->
                        <div class="fv-row row">
                            <textarea id="id_edit_doc_generate" class="edit_doc_tinymce form-control form-control-solid" rows="3" placeholder="" name="contenu_document"></textarea>
                            <textarea id="id_edit_doc_generate_text" name="contenu_text_document" hidden></textarea>
                        </div>
                        <!--end::Input group-->
                    </div>

                    <input type="hidden" name="action" value="edit_doc_generate">
                    <input type="hidden" name="id_document" value="">
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_doc_generate -->

    <!-- begin::Modal edit_form_doc_generate -->
    <div class="modal fade" id="edit_form_doc_generate_table_doc_8_fiche_id_client_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <!--begin::Modal content-->
            <form id="form_edit_form_doc_generate_table_doc_8_fiche_id_client" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">
                        <h3>Sous-doc N°8-1 : Informations générales sur le client (Partie 1)</h3> <br><br>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Adresse</label>
                                <input id="table_doc_8_fiche_id_client_adresse" type="text" class="form-control form-control-solid" placeholder="Entrez l'adresse du client" name="adresse">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-12 col-lg-4 form-group">
                                <label class="fs-5 mb-2">N° d'identification fiscal</label>
                                <input id="table_doc_8_fiche_id_client_id_fiscale_client" type="text" class="form-control form-control-solid" placeholder="N° d'identification fiscal" name="id_fiscale_client">
                            </div>
                            <div class="col-md-6 col-lg-4 form-group">
                                <label class="fs-5 mb-2">Exercice clos le</label>
                                <input id="table_doc_8_fiche_id_client_exercice_clos_le" type="date" class="form-control form-control-solid" placeholder="Exercice clos le" name="exercice_clos_le">
                            </div>
                            <div class="col-md-6 col-lg-4 form-group">
                                <label class="fs-5 mb-2">Durée de l'exercice</label>
                                <input id="table_doc_8_fiche_id_client_duree_en_mois" type="number" step="1" class="form-control form-control-solid" placeholder="Durée (en mois)" name="duree_en_mois">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="fs-5 mb-2">Exercice comptable du</label>
                            <div class="input-group">
                                <input id="table_doc_8_fiche_id_client_exercice_compta_du" type="date" class="form-control" placeholder="" name="exercice_compta_du">
                                <span class="input-group-text">au</span>
                                <input id="table_doc_8_fiche_id_client_exercice_compta_au" type="date" class="form-control" placeholder="" name="exercice_compta_au">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-4 form-group">
                                <label class="fs-5 mb-2">Date d'arrêté des comptes</label>
                                <input id="table_doc_8_fiche_id_client_date_arret_compta" type="date" class="form-control form-control-solid" placeholder="" name="date_arret_compta">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="fs-5 mb-2">Exercice précédent clos le</label>
                                <input id="table_doc_8_fiche_id_client_exercice_prev_clos_le" type="date" class="form-control form-control-solid" placeholder="" name="exercice_prev_clos_le">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="fs-5 mb-2">Durée de l'exercice précédent</label>
                                <input id="table_doc_8_fiche_id_client_duree_exercice_prev_en_mois" type="number" step="1" class="form-control form-control-solid" placeholder="Durée (en mois)" name="duree_exercice_prev_en_mois">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-4 col-md-4 form-group">
                                <label class="fs-5 mb-2">Greffe</label>
                                <input id="table_doc_8_fiche_id_client_greffe" type="int" class="form-control form-control-solid" placeholder="Greffe" name="greffe">
                            </div>
                            <div class="col-8 col-md-4 form-group">
                                <label class="fs-5 mb-2">N° Registre du commerce</label>
                                <input id="table_doc_8_fiche_id_client_num_registre_commerce" type="text" class="form-control form-control-solid" placeholder="N° Registre du commerce" name="num_registre_commerce">
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label class="fs-5 mb-2">N° Répertoire des entités</label>
                                <input id="table_doc_8_fiche_id_client_num_repertoire_entite" type="text" class="form-control form-control-solid" placeholder="N° Répertoire des entités" name="num_repertoire_entite">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-6 col-md-4 form-group">
                                <label class="fs-5 mb-2">N° de caisse sociale</label>
                                <input id="table_doc_8_fiche_id_client_num_caisse_sociale" type="int" class="form-control form-control-solid" placeholder="N° de caisse sociale" name="num_caisse_sociale">
                            </div>
                            <div class="col-6 col-md-4 form-group">
                                <label class="fs-5 mb-2">N° Code Importateur</label>
                                <input id="table_doc_8_fiche_id_client_num_code_importateur" type="text" class="form-control form-control-solid" placeholder="N° Code Importateur" name="num_code_importateur">
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label class="fs-5 mb-2">Code activité principale</label>
                                <input id="table_doc_8_fiche_id_client_code_activite_principale" type="text" class="form-control form-control-solid" placeholder="Code activité principale" name="code_activite_principale">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-8 form-group">
                                <label class="fs-5 mb-2">Désignation de l'entité</label>
                                <input id="table_doc_8_fiche_id_client_designation_entite" type="int" class="form-control form-control-solid" placeholder="Désignation de l'entité" name="designation_entite">
                            </div>
                            <div class="col-4 form-group">
                                <label class="fs-5 mb-2">Sigle</label>
                                <input id="table_doc_8_fiche_id_client_sigle" type="text" class="form-control form-control-solid" placeholder="Sigle" name="sigle">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-5 form-group">
                                <label class="fs-5 mb-2">N° de téléphone</label>
                                <input id="table_doc_8_fiche_id_client_telephone" type="int" class="form-control form-control-solid" placeholder="N° de téléphone" name="telephone">
                            </div>
                            <div class="col-7 form-group">
                                <label class="fs-5 mb-2">Email</label>
                                <input id="table_doc_8_fiche_id_client_email" type="text" class="form-control form-control-solid" placeholder="Email" name="email">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="fs-5 mb-2">Boite postal</label>
                            <div class="input-group">
                                <input id="table_doc_8_fiche_id_client_num_code" type="text" class="form-control" placeholder="" name="num_code">
                                <span class="input-group-text">-</span>
                                <input id="table_doc_8_fiche_id_client_code" type="text" class="form-control" placeholder="Code" name="code">
                                <span class="input-group-text">-</span>
                                <input id="table_doc_8_fiche_id_client_boite_postal" type="text" class="form-control" placeholder="Boite postale" name="boite_postal">
                                <span class="input-group-text">-</span>
                                <input id="table_doc_8_fiche_id_client_ville" type="text" class="form-control" placeholder="Boite postale" name="ville">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Adresse géographique complète</label>
                                <textarea id="table_doc_8_fiche_id_client_adresse_geo_complete" class="form-control form-control-solid" placeholder="Adresse géographique complète (Immeuble, rue, quartier, ville, pays)" rows="3" name="adresse_geo_complete"></textarea>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Désignation précise de l'activité principale</label>
                                <textarea id="table_doc_8_fiche_id_client_designation_activite_principale" class="form-control form-control-solid" placeholder="Désignation précise de l'activité principale exercée par l'entité" rows="3" name="designation_activite_principale"></textarea>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Personne à contacter pour renseignement</label>
                                <input id="table_doc_8_fiche_id_client_personne_a_contacter" type="text" class="form-control form-control-solid" placeholder="Nom, adresse et qualité de la personne à contacter" name="personne_a_contacter">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Professionnel salarié ou Cabinet</label>
                                <textarea id="table_doc_8_fiche_id_client_professionnel_salarie_ou_cabinet" class="form-control form-control-solid" placeholder="Nom du professionnel salarié de l'entité ou Nom, adresse et téléphone du cabinet comptable ou du professionnel INSCRIT A L'ORDRE NATIONAL DES EXPERTS COMPTABLES ET DES COMPTABLES AGREES ayant établi les états financiers" rows="3" name="professionnel_salarie_ou_cabinet"></textarea>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group d-none">
                                <label class="fs-5 mb-2">Visa de l'expert comptable</label>
                                <input id="table_doc_8_fiche_id_client_visa_expert" type="text" class="form-control form-control-solid" placeholder="" value="" name="visa_expert">
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="text-end">
                                    <label class="fs-5 mb-2">Etats financiers approuvés</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid form-check-lg justify-content-end">
                                    <div class="d-flex flex-column">
                                        <input id="table_doc_8_fiche_id_client_etats_financiers_approuves_oui" class="form-check-input" type="radio" value="oui" name="etats_financiers_approuves">
                                        <label class="form-check-label m-0 mt-2 text-center" for="etats_financiers_approuves_oui">Oui</label>
                                    </div>
                                    <div class="d-flex flex-column ms-5">
                                        <input id="table_doc_8_fiche_id_client_etats_financiers_approuves_non" class="form-check-input" type="radio" value="non" name="etats_financiers_approuves">
                                        <label class="form-check-label m-0 mt-2 text-center" for="etats_financiers_approuves_non">Non</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <h3>Sous-doc N°8-1 : Informations générales sur le client (Partie 2)</h3> <br><br>

                        <div class="row mb-5">
                            <div class="input-group">
                                <span class="input-group-text">Forme juridique :</span>
                                <input id="table_doc_8_fiche_id_client_forme_juridique_1" type="number" class="form-control" placeholder="" name="forme_juridique_1">
                                <input id="table_doc_8_fiche_id_client_forme_juridique_2" type="number" class="form-control" placeholder="" name="forme_juridique_2">
                                <span class="input-group-text">Régime fiscal :</span>
                                <input id="table_doc_8_fiche_id_client_regime_fiscal_1" type="number" class="form-control" placeholder="" name="regime_fiscal_1">
                                <input id="table_doc_8_fiche_id_client_regime_fiscal_2" type="number" class="form-control" placeholder="" name="regime_fiscal_2">
                                <span class="input-group-text">Pays du siège social :</span>
                                <input id="table_doc_8_fiche_id_client_pays_siege_social_1" type="number" class="form-control" placeholder="" name="pays_siege_social_1">
                                <input id="table_doc_8_fiche_id_client_pays_siege_social_2" type="number" class="form-control" placeholder="" name="pays_siege_social_2">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="input-group">
                                <span class="input-group-text">Nombre d'établissement dans le pays :</span>
                                <input id="table_doc_8_fiche_id_client_nbr_etablissement_in" type="number" class="form-control" placeholder="" name="nbr_etablissement_in">
                                <span class="input-group-text">Hors du pays :</span>
                                <input id="table_doc_8_fiche_id_client_nbr_etablissement_out" type="number" class="form-control" placeholder="" name="nbr_etablissement_out">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="d-flex form-group align-center">
                                <label class="fs-5 p-3 ps-0">Première année d'exercice dans le pays :</label>
                                <input id="table_doc_8_fiche_id_client_prem_annee_exercice_in" class="form-control mw-250px ms-3" type="number" min="1800" max="<?= date('Y') ?>" step="1" value="" name="prem_annee_exercice_in">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="fs-5 mb-2">Contrôle de l'entité</label>

                            <div class="form-group col-4">
                                <!--begin::Col-->
                                <label class="form-check-clip text-center w-100">
                                    <input id="table_doc_8_fiche_id_client_controle_entite_public" class="btn-check" type="radio" value="public" checked name="controle_entite" />
                                    <div class="form-check-wrapper w-100">
                                        <div class="form-check-indicator"></div>
                                        <div class="form-check-content fw-semibold text-start bg-light-primary rounded border-primary border border-dashed p-6">
                                            <span class="text-dark fw-bold d-block fs-3">Entité</span>
                                            <span class="text-muted fw-semibold fs-6">Sous contrôle public</span>
                                        </div>
                                    </div>
                                </label>
                                <!--end::Col-->
                            </div>

                            <div class="form-group col-4">
                                <!--begin::Col-->
                                <label class="form-check-clip text-center w-100">
                                    <input id="table_doc_8_fiche_id_client_controle_entite_prive_national" class="btn-check" type="radio" value="prive_national" checked name="controle_entite" />
                                    <div class="form-check-wrapper w-100">
                                        <div class="form-check-indicator"></div>
                                        <div class="form-check-content fw-semibold text-start bg-light-primary rounded border-primary border border-dashed p-6">
                                            <span class="text-dark fw-bold d-block fs-3">Entité</span>
                                            <span class="text-muted fw-semibold fs-6">Sous contrôle privé national</span>
                                        </div>
                                    </div>
                                </label>
                                <!--end::Col-->
                            </div>

                            <div class="form-group col-4">
                                <!--begin::Col-->
                                <label class="form-check-clip text-center w-100">
                                    <input id="table_doc_8_fiche_id_client_controle_entite_prive_etranger" class="btn-check" type="radio" value="prive_etranger" name="controle_entite" />
                                    <div class="form-check-wrapper w-100">
                                        <div class="form-check-indicator"></div>
                                        <div class="form-check-content fw-semibold text-start bg-light-primary rounded border-primary border border-dashed p-6">
                                            <span class="text-dark fw-bold d-block fs-3">Entité</span>
                                            <span class="text-muted fw-semibold fs-6">Sous contrôle privé étranger</span>
                                        </div>
                                    </div>
                                </label>
                                <!--end::Col-->
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">ACTIVITE DE L'ENTITE</span>
                        </div>

                        <!--begin::Repeater-->
                        <div id="table_doc_8_fiche_id_client_activite_client_repeater">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="activite_client">
                                    <div data-repeater-item>
                                        <div class="form-group row mb-2">
                                            <div class="col-md-3">
                                                <!-- <label class="form-label">Designation</label>
                                                <input name="designation_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Désignation de l'activité" /> -->
                                                <div class="form-floating">
                                                    <input name="designation_activite_client" type="text" class="form-control" placeholder="Désignation de l'activité" />
                                                    <label>Designation</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <label class="form-label">Nomenclature</label>
                                                <input name="code_nomenclature_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Code nomenclature d'activité" /> -->
                                                <div class="form-floating">
                                                    <input name="code_nomenclature_activite_client" type="text" class="form-control" placeholder="Code nomenclature d'activité" />
                                                    <label>Nomenclature</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <!-- <label class="form-label">Chiffre d'affaires HT</label>
                                                <input name="chiffre_affaires_ht_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Chiffre d'affaires HT" /> -->
                                                <div class="form-floating">
                                                    <input name="chiffre_affaires_ht_activite_client" type="number" class="form-control" placeholder="Chiffre d'affaires HT" />
                                                    <label>Chiffre d'affaires HT</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <!-- <label class="form-label">% activité dans le CA</label>
                                                <input name="percent_activite_in_ca_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="% activité dans le CA HT" /> -->
                                                <div class="form-floating">
                                                    <input name="percent_activite_in_ca_activite_client" type="number" class="form-control" placeholder="% activité dans le CA HT" />
                                                    <label>% activité dans le CA</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                    <i class="la la-trash-o fs-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <div class="infos_activite_client">
                                <span class="fst-italic fw-bold text-muted fs-6">(!) Lister de manière précise les activités dans l'ordre décroissant du C. A. HT, ou de la valeur ajoutée (V. A.).</span>
                            </div>

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Ajouter
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                        <br><br>
                        <h3>Sous-doc N°8-1 : Informations générales sur le client (Partie 3)</h3> <br><br>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">DIRIGEANTS</span>
                        </div>

                        <!--begin::Repeater-->
                        <div id="table_doc_8_fiche_id_client_dirigeant_client_repeater">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="dirigeant_client">
                                    <div data-repeater-item>
                                        <div class="form-group row mb-5">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="nom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Nom" />
                                                    <label>Nom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="prenom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Prénom" />
                                                    <label>Prénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="qualite_dirigeant_client" type="text" class="form-control mb-2" placeholder="Qualité" />
                                                    <label>Qualité</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="id_fiscal_dirigeant_client" type="number" class="form-control mb-2" placeholder="N° identification fiscale" />
                                                    <label>N° identification fiscale</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="tel_dirigeant_client" type="text" class="form-control mb-2" placeholder="Téléphone" />
                                                    <label>Téléphone</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="mail_dirigeant_client" type="email" class="form-control mb-2" placeholder="Mail" />
                                                    <label>Mail</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="adresse_dirigeant_client" type="text" class="form-control mb-2" placeholder="Adresse" />
                                                    <label>Adresse</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                    <i class="la la-trash-o fs-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <div class="infos_activite_client">
                                <span class="fst-italic fw-bold text-muted fs-6">(!) Dirigeants = Président Directeur Général, Directeur Général, Administrateur Général, Gérant, Autres.</span>
                            </div>

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Ajouter
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">MEMBRES DU CONSEIL D'ADMINISTRATION</span>
                        </div>

                        <!--begin::Repeater-->
                        <div id="table_doc_8_fiche_id_client_membre_conseil_client_repeater">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="membre_conseil_client">
                                    <div data-repeater-item>
                                        <div class="form-group row mb-5">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="nom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Nom" />
                                                    <label>Nom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="prenom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Prénom" />
                                                    <label>Prénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="qualite_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Qualité" />
                                                    <label>Qualité</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="tel_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Téléphone" />
                                                    <label>Téléphone</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="mail_membre_conseil_client" type="email" class="form-control mb-2" placeholder="Mail" />
                                                    <label>Mail</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input name="adresse_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Adresse" />
                                                    <label>Adresse</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <textarea name="fonction_membre_conseil_client" class="form-control mb-2" placeholder="Fonction"></textarea>
                                                    <label>Fonction</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                    <i class="la la-trash-o fs-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <div class="infos_activite_client">
                                <span class="fst-italic fw-bold text-muted fs-6">(!) Dirigeants = Président Directeur Général, Directeur Général, Administrateur Général, Gérant, Autres.</span>
                            </div>

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Ajouter
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                        <br><br>
                        <h3>Sous-doc N°8-2 : Autres informations sur le client</h3> <br><br>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Durée de vie de la société :</label>
                                <input id="table_doc_8_fiche_id_client_duree_vie_societe" type="number" class="form-control form-control-solid" placeholder="Entrez le nombre d'année" name="duree_vie_societe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Date de dissolution prévisible :</label>
                                <input id="table_doc_8_fiche_id_client_date_dissolution" type="date" class="form-control form-control-solid" placeholder="Date de dissolution prévisible" name="date_dissolution">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Capital Social :</label>
                                <input id="table_doc_8_fiche_id_client_capital_social" type="number" class="form-control form-control-solid" placeholder="Capital Social" name="capital_social">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Siège Social :</label>
                                <input id="table_doc_8_fiche_id_client_siege_social" type="text" class="form-control form-control-solid" placeholder="Siège Social" name="siege_social">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Site internet :</label>
                                <input id="table_doc_8_fiche_id_client_site_internet" type="text" class="form-control form-control-solid" placeholder="Site internet" name="site_internet">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Nombre de salariés :</label>
                                <input id="table_doc_8_fiche_id_client_nombre_de_salarie" type="number" class="form-control form-control-solid" placeholder="Nombre de salariés" name="nombre_de_salarie">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="fs-5 mb-2">Chiffre d'affaires des 3 derniers exercices :</label>
                            <div class="input-group">
                                <span class="input-group-text">N-1</span>
                                <input id="table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_1" type="number" class="form-control" placeholder="" name="ca_3_derniers_exercices_n_1">
                                <span class="input-group-text">N-2</span>
                                <input id="table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_2" type="number" class="form-control" placeholder="" name="ca_3_derniers_exercices_n_2">
                                <span class="input-group-text">N-3</span>
                                <input id="table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_3" type="number" class="form-control" placeholder="" name="ca_3_derniers_exercices_n_3">
                            </div>
                        </div>

                        <br><br>
                        <h3>Sous-doc N°8-3: Autres informations au niveau du cabinet</h3> <br><br>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Date ouverture du dossier du client :</label>
                                <input id="table_doc_8_fiche_id_client_date_ouverture_dossier" type="date" class="form-control form-control-solid" placeholder="Date ouverture du dossier du client" name="date_ouverture_dossier">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Nom du Cabinet du confrère ou de l'Expert :</label>
                                <input id="table_doc_8_fiche_id_client_nom_cabinet_confrere" type="text" class="form-control form-control-solid" placeholder="Nom du Cabinet du confrère ou de l'Expert" name="nom_cabinet_confrere">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Dossier hérité du confrère :</label>
                                <input id="table_doc_8_fiche_id_client_dossier_herite_confrere" type="text" class="form-control form-control-solid" placeholder="Dossier hérité du confrère" name="dossier_herite_confrere">
                            </div>
                        </div>

                    </div>

                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_table_doc_8_fiche_id_client">
                    <input type="hidden" name="id_document" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_form_doc_generate_table_doc_8_fiche_id_client" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_form_doc_generate -->

    <!-- begin::Modal edit_form_doc_generate -->
    <div class="modal fade" id="edit_form_doc_generate_table_doc_3_accept_mission_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <!--begin::Modal content-->
            <form id="form_edit_form_doc_generate_table_doc_3_accept_mission" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Prise de connaissance (confère DOC N°2)</span>
                        </div>
                        <!-- quiz1 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le cabinet a-t-il rencontré le client pour prendre connaissance de ses besoins et découvrir l'entreprise ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz1_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz1_oui" class="form-check-input" type="radio" value="oui" name="quiz1">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz1_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz1_non" class="form-check-input" type="radio" value="non" name="quiz1">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ1" type="" class="form-control form-control-solid" placeholder="" name="observ1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="infos_quiz1">
                            <span class="fst-italic fw-semibold text-muted fs-6">
                                <span class="fw-bold text-decoration-underline text-dark">Nota Bene</span>: Joindre au dossier permanent une présentation de l'entité (plaquette, les notes prises lors de l'entretien avec le client, budgets ou tableaux de bord…)
                            </span>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Analyse des risques du client (confère DOC N°9)</span>
                        </div>
                        <!-- quiz2 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Activité</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz2_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz2_e" class="form-check-input" type="radio" value="e" name="quiz2">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz2_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz2_m" class="form-check-input" type="radio" value="m" name="quiz2">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz2_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz2_f" class="form-check-input" type="radio" value="f" name="quiz2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz3 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Caractéristiques juridiques (Structure juridique, détenteurs du capital, dirigeants de l'entité…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz3_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz3_e" class="form-check-input" type="radio" value="e" name="quiz3">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz3_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz3_m" class="form-check-input" type="radio" value="m" name="quiz3">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz3_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz3_f" class="form-check-input" type="radio" value="f" name="quiz3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz4 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Système d’information (Fiabilité, conformité par rapport à la législation, sécurité…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz4_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz4_e" class="form-check-input" type="radio" value="e" name="quiz4">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz4_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz4_m" class="form-check-input" type="radio" value="m" name="quiz4">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz4_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz4_f" class="form-check-input" type="radio" value="f" name="quiz4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz5 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Organisation comptable (Existence et importance de la fonction comptable – qualification du personnel comptable - nature et qualité des travaux pris en charge…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz5_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz5_e" class="form-check-input" type="radio" value="e" name="quiz5">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz5_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz5_m" class="form-check-input" type="radio" value="m" name="quiz5">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz5_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz5_f" class="form-check-input" type="radio" value="f" name="quiz5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz6 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Clients (les clients les plus importants, délais de règlement des clients…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz6_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz6_e" class="form-check-input" type="radio" value="e" name="quiz6">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz6_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz6_m" class="form-check-input" type="radio" value="m" name="quiz6">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz6_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz6_f" class="form-check-input" type="radio" value="f" name="quiz6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz7 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Fournisseurs (les fournisseurs les plus importants, délais de règlement des fournisseurs)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz7_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz7_e" class="form-check-input" type="radio" value="e" name="quiz7">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz7_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz7_m" class="form-check-input" type="radio" value="m" name="quiz7">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz7_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz7_f" class="form-check-input" type="radio" value="f" name="quiz7">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz8 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Trésorerie (Existence de système de contrôle interne autour de la trésorerie, inventaire périodique de la banque et de la caisse,…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz8_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz8_e" class="form-check-input" type="radio" value="e" name="quiz8">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz8_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz8_m" class="form-check-input" type="radio" value="m" name="quiz8">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz8_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz8_f" class="form-check-input" type="radio" value="f" name="quiz8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz9 -->
                        <div class="row mb-10">
                            <div class="row px-10 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Historique fiscal et social du client (Contrôles fiscaux, contrôles CNSS…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz9_e">Élevé</label>
                                            <input id="table_doc_3_accept_mission_quiz9_e" class="form-check-input" type="radio" value="e" name="quiz9">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz9_m">Moyen</label>
                                            <input id="table_doc_3_accept_mission_quiz9_m" class="form-check-input" type="radio" value="m" name="quiz9">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz9_f">Faible</label>
                                            <input id="table_doc_3_accept_mission_quiz9_f" class="form-check-input" type="radio" value="f" name="quiz9">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Analyse des besoins du client</span>
                        </div>
                        <h4>Les informations suivantes ont-elles été collectées ?</h4>
                        <!-- quiz10 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">La répartition des travaux comptables entre le client et le cabinet</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz10_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz10_oui" class="form-check-input" type="radio" value="oui" name="quiz10">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz10_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz10_non" class="form-check-input" type="radio" value="non" name="quiz10">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ10" type="" class="form-control form-control-solid" placeholder="" name="observ10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz11 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le volume d'écritures comptables</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz11_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz11_oui" class="form-check-input" type="radio" value="oui" name="quiz11">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz11_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz11_non" class="form-check-input" type="radio" value="non" name="quiz11">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ11" type="" class="form-control form-control-solid" placeholder="" name="observ11"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz12 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Les spécificités comptables, fiscales et sociales relatives à l'activité et pouvant nécessiter des travaux approfondis ou spécifiques : valorisation, détermination de provisions, etc(confère la partie Organisation comptable dans le logiciel GED-ELYON)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz12_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz12_oui" class="form-check-input" type="radio" value="oui" name="quiz12">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz12_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz12_non" class="form-check-input" type="radio" value="non" name="quiz12">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ12" type="" class="form-control form-control-solid" placeholder="" name="observ12"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz13 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Les délais spécifiques à respecter (Demande particulière du client…)</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz13_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz13_oui" class="form-check-input" type="radio" value="oui" name="quiz13">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz13_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz13_non" class="form-check-input" type="radio" value="non" name="quiz13">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ13" type="" class="form-control form-control-solid" placeholder="" name="observ13"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Analyse de la faisabilité de la mission</span>
                        </div>
                        <!-- quiz14 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le cabinet est-il indépendant vis-à-vis du client ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz14_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz14_oui" class="form-check-input" type="radio" value="oui" name="quiz14">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz14_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz14_non" class="form-check-input" type="radio" value="non" name="quiz14">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ14" type="" class="form-control form-control-solid" placeholder="" name="observ14"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz15 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le cabinet a-t-il la compétence pour réaliser cette mission ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz15_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz15_oui" class="form-check-input" type="radio" value="oui" name="quiz15">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz15_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz15_non" class="form-check-input" type="radio" value="non" name="quiz15">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ15" type="" class="form-control form-control-solid" placeholder="" name="observ15"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz16 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le cabinet dispose-t-il des moyens adéquats pour assurer cette mission dans de bonnes conditions (notamment de délai) ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz16_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz16_oui" class="form-check-input" type="radio" value="oui" name="quiz16">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz16_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz16_non" class="form-check-input" type="radio" value="non" name="quiz16">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ16" type="" class="form-control form-control-solid" placeholder="" name="observ16"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Analyse des dispositions de la loi anti blanchiment</span>
                        </div>
                        <!-- quiz17 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le questionnaire sur la lutte anti blanchiment a-t-il été complété ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz17_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz17_oui" class="form-check-input" type="radio" value="oui" name="quiz17">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz17_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz17_non" class="form-check-input" type="radio" value="non" name="quiz17">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ17" type="" class="form-control form-control-solid" placeholder="" name="observ17"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Lettre au confrère (confère DOC N°4)</span>
                        </div>
                        <!-- quiz18 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le client fait-il déjà appel aux services d'un professionnel de l'expertise comptable ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz18_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz18_oui" class="form-check-input" type="radio" value="oui" name="quiz18">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz18_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz18_non" class="form-check-input" type="radio" value="non" name="quiz18">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ18" type="" class="form-control form-control-solid" placeholder="" name="observ18"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz19 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">…la lettre au confrère (prévue au Code de déontologie de la profession d'expertise comptable) a-t-elle été envoyée ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz19_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz19_oui" class="form-check-input" type="radio" value="oui" name="quiz19">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz19_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz19_non" class="form-check-input" type="radio" value="non" name="quiz19">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ19" type="" class="form-control form-control-solid" placeholder="" name="observ19"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- quiz20 -->
                        <div class="row mb-10">
                            <div class="row px-5 px-md-20">
                                <div class="col-md-6 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">…existe-t-il une opposition à notre entrée en fonction ou des remarques ont-elles été formulées par le confrère ?</label>
                                </div>
                                <div class="col-md-6 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz20_oui">Oui</label>
                                            <input id="table_doc_3_accept_mission_quiz20_oui" class="form-check-input" type="radio" value="oui" name="quiz20">
                                        </div>
                                        <div class="d-flex flex-column ms-10">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_3_accept_mission_quiz20_non">Non</label>
                                            <input id="table_doc_3_accept_mission_quiz20_non" class="form-check-input" type="radio" value="non" name="quiz20">
                                        </div>

                                    </div>
                                    <div class="form-observ ms-10">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_3_accept_mission_observ20" type="" class="form-control form-control-solid" placeholder="" name="observ20"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Décision d’acception de la mission</span>
                        </div>
                        <!-- Décision final -->
                        <div class="row mb-10">
                            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                                <label class="fs-6 mb-2">Après avoir pris connaissance des réponses formulées sur cette page, compte tenu de la connaissance que nous avons acquise de l'entité et notamment des zones et des niveaux de risque identifiés dans le cadre de la prise de connaissance,</label>
                            </div>
                            <div class="col-lg-6 form-group">
                                <div class="form-check form-check-custom form-check-solid form-check-lg justify-content-end flex-column">
                                    <div class="decision_oui mb-10">
                                        <label class="form-check-label m-0 mt-2 text-center" for="table_doc_3_accept_mission_accept_mission_oui">Nous décidons d’accepter la mission</label>
                                        <input id="table_doc_3_accept_mission_accept_mission_oui" class="form-check-input ms-2" type="radio" value="oui" name="accept_mission">
                                    </div>
                                    <div class="decision_non">
                                        <label class="form-check-label m-0 mt-2 text-center" for="table_doc_3_accept_mission_accept_mission_non">Nous décidons de refuser la mission</label>
                                        <input id="table_doc_3_accept_mission_accept_mission_non" class="form-check-input ms-2" type="radio" value="non" name="accept_mission">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Observation générale</span>
                        </div>
                        <!-- observation -->
                        <div class="row mb-10 px-5 px-md-20">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Observations :</label>
                                <textarea id="table_doc_3_accept_mission_observation" rows="3" class="form-control form-control-solid w-100" placeholder="" name="observation"></textarea>
                            </div>
                        </div>



                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_table_doc_3_accept_mission">
                    <input type="hidden" name="id_document" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_form_doc_generate_table_doc_3_accept_mission" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_form_doc_generate -->

    <!-- begin::Modal edit_form_doc_generate -->
    <div class="modal fade" id="edit_form_doc_generate_table_doc_19_quiz_lcb_modal" tabindex="-1">

        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <!--begin::Modal content-->
            <form id="form_edit_form_doc_generate_table_doc_19_quiz_lcb" method="POST" class="modal-content h-100" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Vigilance vis-à-vis de l'entité</span>
                        </div>
                        <!-- quiz1 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Le dossier contient-il des documents officiels d'identité actualisés (IFU, RCCM et autres) ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz1_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz1_oui" class="form-check-input" type="radio" value="oui" name="quiz1">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz1_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz1_non" class="form-check-input" type="radio" value="non" name="quiz1">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz1_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz1_na" class="form-check-input" type="radio" value="na" name="quiz1">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact1" name="impact1" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ1" type="" class="form-control form-control-solid" placeholder="" name="observ1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz2 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des changements juridiques fréquents de structures ou d'associés/dirigeants ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz2_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz2_oui" class="form-check-input" type="radio" value="oui" name="quiz2">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz2_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz2_non" class="form-check-input" type="radio" value="non" name="quiz2">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz2_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz2_na" class="form-check-input" type="radio" value="na" name="quiz2">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact2" name="impact2" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-2">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ2" type="" class="form-control form-control-solid" placeholder="" name="observ2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz3 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">L'entité a-t-elle subi un contrôle fiscal avec des redressements importants ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz3_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz3_oui" class="form-check-input" type="radio" value="oui" name="quiz3">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz3_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz3_non" class="form-check-input" type="radio" value="non" name="quiz3">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz3_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz3_na" class="form-check-input" type="radio" value="na" name="quiz3">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact3" name="impact3" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ3" type="" class="form-control form-control-solid" placeholder="" name="observ3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Vigilance vis-à-vis du bénéficiaire</span>
                        </div>
                        <!-- quiz4 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Connaissons-nous les associés directs détenant plus de 25% des droits de vote ou du capital ou les dirigeants ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz4_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz4_oui" class="form-check-input" type="radio" value="oui" name="quiz4">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz4_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz4_non" class="form-check-input" type="radio" value="non" name="quiz4">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz4_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz4_na" class="form-check-input" type="radio" value="na" name="quiz4">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact4" name="impact4" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ4" type="" class="form-control form-control-solid" placeholder="" name="observ4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz5 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Avons-nous rencontré le(s) dirigeants effectif(s) ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz5_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz5_oui" class="form-check-input" type="radio" value="oui" name="quiz5">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz5_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz5_non" class="form-check-input" type="radio" value="non" name="quiz5">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz5_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz5_na" class="form-check-input" type="radio" value="na" name="quiz5">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact5" name="impact5" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ5" type="" class="form-control form-control-solid" placeholder="" name="observ5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz6 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il fréquemment des changements de représentant légal ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz6_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz6_oui" class="form-check-input" type="radio" value="oui" name="quiz6">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz6_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz6_non" class="form-check-input" type="radio" value="non" name="quiz6">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz6_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz6_na" class="form-check-input" type="radio" value="na" name="quiz6">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact6" name="impact6" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ6" type="" class="form-control form-control-solid" placeholder="" name="observ6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Informations sur l'actionnariat</span>
                        </div>
                        <!-- quiz7 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il parmi les actionnaires ou dirigeants des personnes politiquement exposées (PPE) ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz7_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz7_oui" class="form-check-input" type="radio" value="oui" name="quiz7">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz7_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz7_non" class="form-check-input" type="radio" value="non" name="quiz7">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz7_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz7_na" class="form-check-input" type="radio" value="na" name="quiz7">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact7" name="impact7" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ7" type="" class="form-control form-control-solid" placeholder="" name="observ7"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz8 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il une part de capital détenue par des actionnaires inconnus et/ou physiquement absents ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz8_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz8_oui" class="form-check-input" type="radio" value="oui" name="quiz8">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz8_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz8_non" class="form-check-input" type="radio" value="non" name="quiz8">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz8_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz8_na" class="form-check-input" type="radio" value="na" name="quiz8">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact8" name="impact8" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ8" type="" class="form-control form-control-solid" placeholder="" name="observ8"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz9 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des doutes sur l'intégrité et la réputation des actionnaires ou dirigeants ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz9_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz9_oui" class="form-check-input" type="radio" value="oui" name="quiz9">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz9_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz9_non" class="form-check-input" type="radio" value="non" name="quiz9">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz9_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz9_na" class="form-check-input" type="radio" value="na" name="quiz9">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact9" name="impact9" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ9" type="" class="form-control form-control-solid" placeholder="" name="observ9"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Informations sur les dirigeants</span>
                        </div>
                        <!-- quiz10 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des éléments ou des indices permettant de penser que la direction pourrait être amenée à fausser délibérément les résultats de l'entité ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz10_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz10_oui" class="form-check-input" type="radio" value="oui" name="quiz10">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz10_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz10_non" class="form-check-input" type="radio" value="non" name="quiz10">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz10_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz10_na" class="form-check-input" type="radio" value="na" name="quiz10">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact10" name="impact10" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ10" type="" class="form-control form-control-solid" placeholder="" name="observ10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz11 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Des personnes clés ont-elles quitté l'entité récemment ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz11_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz11_oui" class="form-check-input" type="radio" value="oui" name="quiz11">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz11_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz11_non" class="form-check-input" type="radio" value="non" name="quiz11">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz11_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz11_na" class="form-check-input" type="radio" value="na" name="quiz11">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact11" name="impact11" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ11" type="" class="form-control form-control-solid" placeholder="" name="observ11"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz12 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Les dirigeants changent-ils souvent de banque, d'avocat, d'expert-comptable ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz12_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz12_oui" class="form-check-input" type="radio" value="oui" name="quiz12">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz12_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz12_non" class="form-check-input" type="radio" value="non" name="quiz12">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz12_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz12_na" class="form-check-input" type="radio" value="na" name="quiz12">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact12" name="impact12" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ12" type="" class="form-control form-control-solid" placeholder="" name="observ12"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Structure de l'entité</span>
                        </div>
                        <!-- quiz13 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">La structure de l'entité est-elle complexe ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz13_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz13_oui" class="form-check-input" type="radio" value="oui" name="quiz13">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz13_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz13_non" class="form-check-input" type="radio" value="non" name="quiz13">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz13_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz13_na" class="form-check-input" type="radio" value="na" name="quiz13">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact13" name="impact13" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ13" type="" class="form-control form-control-solid" placeholder="" name="observ13"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz14 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des opérations, des filiales ou des comptes bancaires significatifs dans des pays étrangers qui n'ont en apparence aucun lien commercial évident avec l'entité ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz14_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz14_oui" class="form-check-input" type="radio" value="oui" name="quiz14">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz14_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz14_non" class="form-check-input" type="radio" value="non" name="quiz14">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz14_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz14_na" class="form-check-input" type="radio" value="na" name="quiz14">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact14" name="impact14" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ14" type="" class="form-control form-control-solid" placeholder="" name="observ14"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Vigilance liée aux opérations</span>
                        </div>
                        <!-- quiz15 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des opérations complexes ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz15_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz15_oui" class="form-check-input" type="radio" value="oui" name="quiz15">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz15_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz15_non" class="form-check-input" type="radio" value="non" name="quiz15">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz15_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz15_na" class="form-check-input" type="radio" value="na" name="quiz15">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact15" name="impact15" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ15" type="" class="form-control form-control-solid" placeholder="" name="observ15"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz16 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">L'entité exerce-t-elle une activité générant d'importants mouvements d'argent liquide ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz16_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz16_oui" class="form-check-input" type="radio" value="oui" name="quiz16">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz16_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz16_non" class="form-check-input" type="radio" value="non" name="quiz16">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz16_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz16_na" class="form-check-input" type="radio" value="na" name="quiz16">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact16" name="impact16" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ16" type="" class="form-control form-control-solid" placeholder="" name="observ16"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz17 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">L'entité exerce-t-elle dans un secteur sensible/favorable au blanchiment (<span style="font-size: 10px;">immobilier, négoce de pierres précieuses, antiquités ou œuvres d'arts, opérateurs de jeux ou de paris autorisés, secteur associatifs etc.</span>)</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz17_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz17_oui" class="form-check-input" type="radio" value="oui" name="quiz17">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz17_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz17_non" class="form-check-input" type="radio" value="non" name="quiz17">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz17_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz17_na" class="form-check-input" type="radio" value="na" name="quiz17">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact17" name="impact17" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ17" type="" class="form-control form-control-solid" placeholder="" name="observ17"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz18 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des montants anormalement élevés ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz18_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz18_oui" class="form-check-input" type="radio" value="oui" name="quiz18">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz18_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz18_non" class="form-check-input" type="radio" value="non" name="quiz18">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz18_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz18_na" class="form-check-input" type="radio" value="na" name="quiz18">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact18" name="impact18" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ18" type="" class="form-control form-control-solid" placeholder="" name="observ18"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz19 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des opérations sans justification économique ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz19_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz19_oui" class="form-check-input" type="radio" value="oui" name="quiz19">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz19_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz19_non" class="form-check-input" type="radio" value="non" name="quiz19">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz19_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz19_na" class="form-check-input" type="radio" value="na" name="quiz19">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact19" name="impact19" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ19" type="" class="form-control form-control-solid" placeholder="" name="observ19"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz20 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">L'origine des fonds est-elle suffisamment justifiée ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz20_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz20_oui" class="form-check-input" type="radio" value="oui" name="quiz20">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz20_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz20_non" class="form-check-input" type="radio" value="non" name="quiz20">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz20_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz20_na" class="form-check-input" type="radio" value="na" name="quiz20">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact20" name="impact20" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ20" type="" class="form-control form-control-solid" placeholder="" name="observ20"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quiz21 -->
                        <div class="row mb-10">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="fs-6 mb-2">Existe-t-il des transactions avec des pays faisant partie de la liste des pays nécessitant une vigilance ?</label>
                                </div>
                                <div class="col-md-5 form-group d-flex justify-content-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <div class="d-flex flex-column">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz21_oui">Oui</label>
                                            <input id="table_doc_19_quiz_lcb_quiz21_oui" class="form-check-input" type="radio" value="oui" name="quiz21">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz21_non">Non</label>
                                            <input id="table_doc_19_quiz_lcb_quiz21_non" class="form-check-input" type="radio" value="non" name="quiz21">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="form-check-label m-0 mb-5 text-center fs-5" for="table_doc_19_quiz_lcb_quiz21_na">NA</label>
                                            <input id="table_doc_19_quiz_lcb_quiz21_na" class="form-check-input" type="radio" value="na" name="quiz21">
                                        </div>
                                        <div class="d-flex flex-column ms-5">
                                            <label class="m-0 mb-5 text-center fs-5">Impact</label>
                                            <select id="table_doc_19_quiz_lcb_impact21" name="impact21" class="form-select form-select-solid" data-control="select2" data-placeholder="Impact" data-hide-search="true">
                                                <option></option>
                                                <option value="e">Élevé</option>
                                                <option value="m">Moyen</option>
                                                <option value="f">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group d-flex justify-content-center">
                                    <div class="form-observ">
                                        <label class="fs-5 mb-3">Observations :</label>
                                        <textarea id="table_doc_19_quiz_lcb_observ21" type="" class="form-control form-control-solid" placeholder="" name="observ21"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Conclusion</span>
                        </div>
                        <!-- conclusion -->
                        <div class="row mb-10 px-5 px-md-20">
                            <div class="form-group">
                                <label class="fs-5 mb-2">Conclusion :</label>
                                <textarea id="table_doc_19_quiz_lcb_conclusion" rows="3" class="form-control form-control-solid w-100" placeholder="" name="conclusion"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_table_doc_19_quiz_lcb">
                    <input type="hidden" name="id_document" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_form_doc_generate_table_doc_19_quiz_lcb" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_form_doc_generate -->

    <!-- begin::Modal edit_info_doc_file -->
    <div class="modal fade" id="edit_info_doc_file_table_doc_6_info_lettre_mission_modal" tabindex="-1">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <!--begin::Modal content-->
            <form id="form_edit_info_doc_file_table_doc_6_info_lettre_mission" method="POST" class="modal-content" action="">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-between border-0 py-3">
                    <h4 class="modal-title">--</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary ms-5" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body">
                    <div class="doc-content">

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Durée de la lettre de mission</label>
                                <input id="table_doc_6_info_lettre_mission_duree" type="number" class="form-control form-control-solid" placeholder="Durée (en année)" name="duree" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">À partir de</label>
                                <input id="table_doc_6_info_lettre_mission_date_debut_duree" type="date" class="form-control form-control-solid" placeholder="" name="date_debut_duree" required>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Renouvellement</label>
                                <input id="table_doc_6_info_lettre_mission_renouvellement" type="number" class="form-control form-control-solid" placeholder="Durée (en année)" name="renouvellement">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">À partir de</label>
                                <input id="table_doc_6_info_lettre_mission_date_debut_renouvellement" type="date" class="form-control form-control-solid" placeholder="" name="date_debut_renouvellement">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="fs-5 mb-2">Montant hors taxes et TTC des honoraires</label>
                            <div class="input-group">
                                <input id="table_doc_6_info_lettre_mission_frais_ouverture" type="text" class="form-control" placeholder="Frais d'ouverture de dossier" name="frais_ouverture">
                                <span class="input-group-text">-</span>
                                <input id="table_doc_6_info_lettre_mission_montant_honoraires_ht" type="text" class="form-control" placeholder="Montant hors taxes" name="montant_honoraires_ht">
                                <span class="input-group-text">-</span>
                                <input id="table_doc_6_info_lettre_mission_montant_honoraires_ttc" type="text" class="form-control" placeholder="Montant TTC" name="montant_honoraires_ttc">
                            </div>
                        </div>

                        <div class="separator d-flex flex-center my-8">
                            <span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3">Renseignez les missions de la lettre de mission</span>
                        </div>

                        <!--begin::Repeater-->
                        <div class="row mb-5" id="table_doc_6_info_lettre_mission_repeater">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="mission">
                                    <div data-repeater-item>
                                        <div class="form-group row mb-5">
                                            <div class="col-md-10">
                                                <label class="fs-5 form-label">Nature de la mission</label>
                                                <input type="text" class="form-control mb-2 mb-md-0" placeholder="Précisez la nature de la mission en se référant au prospectus du cabinet" name="nature_mission" />
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                    <i class="la la-trash-o fs-3"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-10 ms-10 mt-5">
                                                <div class="inner-repeater">
                                                    <div data-repeater-list="sous_mission" class="mb-5">
                                                        <div data-repeater-item>
                                                            <label class="fs-6 form-label">Nature de la sous mission</label>
                                                            <div class="input-group pb-3">
                                                                <input type="text" class="form-control" placeholder="Précisez la nature de la sous mission" name="nature_sous_mission" />
                                                                <button class="border border-secondary btn btn-icon btn-light-danger" data-repeater-delete type="button">
                                                                    <i class="la la-trash-o fs-3"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm btn-light-primary" data-repeater-create type="button">
                                                        <i class="la la-plus"></i> Ajouter une sous mission
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>Ajouter une mission
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                    </div>

                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_table_doc_6_info_lettre_mission">
                    <input type="hidden" name="id_document" value="">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_info_doc_file_table_doc_6_info_lettre_mission" type="submit" class="btn btn-lg btn-primary ms-2">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Veuillez patienter...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!-- end::Modal edit_info_doc_file -->

    <!-- begin::Modal Information relance-->
    <div class="modal fade" id="edit_info_relance_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_edit_info_relance" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Modifier les informations de relance client</h4>
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

                    <div class="d-flex fw-semibold me-5 mb-5">
                        <i class="fas fa-exclamation-circle ms-2 fs-5"></i>
                        <div class="fs-6 text-muted ms-3 fst-italic">
                            Les mails de relance seront envoyés à un représentant du client. Ce dernier peut-être, un associé gérant, le directeur général, le directeur des ressources humaines, etc.
                        </div>
                    </div>

                    <div class="row ms-1 my-10">
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            <input id="id_edit_info_relance_auto" class="form-check-input" type="checkbox" value="" name="relance_auto_client">
                            <span class="form-check-label">
                                Relance automatique
                            </span>
                        </label>
                    </div>

                    <div class="relance-info-option">
                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Nom responsable client</label>
                                <input id="id_edit_info_relance_nom" type="text" class="form-control form-control-solid" placeholder="Entrez le nom du responsable client" name="nom_responsable_client">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Prénom responsable client</label>
                                <input id="id_edit_info_relance_prenom" type="text" class="form-control form-control-solid" placeholder="Entrez le prenom du responsable client" name="prenom_responsable_client">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Civilité</label>
                                <select id="id_edit_info_relance_civilite" class="form-select form-select-solid" data-control="select2" data-placeholder="Sélectionnez une civilité" data-hide-search="true" name="civilite_responsable_client">
                                    <option></option>
                                    <option value="Monsieur">Monsieur</option>
                                    <option value="Madame">Madame</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="fs-5 mb-2">Fonction</label>
                                <input id="id_edit_info_relance_fonction" type="text" class="form-control form-control-solid" placeholder="Entrez la fonction du responsable client" name="role_responsable_client">
                            </div>
                        </div>
                    </div>


                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="edit_info_relance">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_edit_info_relance" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Information relance-->



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
<script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
<script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/roll/ag/include/pages_script.php'); ?>

<script>
    $(document).ready(function() {

        // Datatable1 = datatable collabo
        function update_data_datatable1(data) {

            $("#collabos_dossier").DataTable().destroy();
            var collabos_dossier = $('#collabos_dossier').DataTable({
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

        function reload_datatable1() {
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    datatable: 'collabos_dossier',
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable1(data.data);
                }
            })
        }

        // Datatable2 = datatable docs juridico admin
        function update_data_datatable2(data) {

            $("#documents_juridico_admin").DataTable().destroy();
            var documents_juridico_admin = $('#documents_juridico_admin').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": true,
                "order": [],
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false,
                }, ],
                "data": data,
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });

            $('#kt_filter_search2').keyup(function() {
                documents_juridico_admin.search($(this).val()).draw();
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

        function reload_datatable2() {
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    datatable: 'documents_juridico_admin',
                    type_dossier_document: $('#filter_type_dossier_document2').val()
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable2(data.data);
                }
            })
        }

        // Datatable3 = datatable docs techniques
        function update_data_datatable3(data) {

            $("#documents_techniques").DataTable().destroy();
            var documents_techniques = $('#documents_techniques').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "bInfo": true,
                "bFilter": true,
                "bSort": true,
                "order": [],
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false,
                }, ],
                "data": data,
                "initComplete": function(settings, json) {
                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });

            $('#kt_filter_search3').keyup(function() {
                documents_techniques.search($(this).val()).draw();
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

        function reload_datatable3() {
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    datatable: 'documents_techniques',
                    type_dossier_document: $('#filter_type_dossier_document3').val(),
                    rubrique_document: $('#filter_rubrique_document3').val()
                },
                dataType: "JSON",
                success: function(data) {
                    update_data_datatable3(data.data);
                }
            })
        }



        // Reload all data pages and datatable
        function reload_page() {

            // Fait une réquête AJAX pour récupérer les données de la page
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_page_client'
                },
                dataType: "JSON",
                success: function(data) {

                    // Affiche les données dans la page

                    $('#ready_icon_juridiques_et_administratifs').html(data.ready_icon_juridiques_et_administratifs);
                    $('#ready_icon_techniques').html(data.ready_icon_techniques);
                    $('#ready_icon_comptables_et_financiers').html(data.ready_icon_comptables_et_financiers);

                    $('#avatar_client').html(data.avatar_client);
                    $('#nom_client').html(data.nom_client);
                    $('#email_client').html(data.email_client);
                    $('#matricule_client').html(data.matricule_client);
                    $('#tel_client').html(data.tel_client);

                    $('#ifu_entite').html(data.ifu_entite);
                    $('#designation_entite').html(data.designation_entite);
                    $('#boite_postal').html(data.boite_postal);
                    $('#designation_activite_principale').html(data.designation_activite_principale);
                    $('#adresse_geo_complete').html(data.adresse_geo_complete);

                    $('#statut_client').html(data.statut_client);
                    $('#action_client').html(data.action_client);
                    $('#niveau_client').html(data.niveau_client);

                    taux_recouvrement = data.taux_recouvrement;
                    total_facture = amount_format(data.total_facture);
                    total_regle = amount_format(data.total_regle);

                    total_echue = amount_format(data.total_echue);
                    nb_facture_echue = data.nb_facture_echue;
                    total_en_cour = amount_format(data.total_en_cour);
                    nb_facture_en_cour = data.nb_facture_en_cour;
                    total_solde = amount_format(data.total_solde);
                    nb_facture_solde = data.nb_facture_solde;

                    $('#view_facture_taux_recouvrement').html(taux_recouvrement + '%');
                    $('#view_facture_total_facture').html(total_facture);
                    $('#view_facture_total_regle').html(total_regle);

                    $('#view_facture_total_echue').html(total_echue);
                    $('#view_facture_nb_echue').html('(' + nb_facture_echue + ')');
                    $('#view_facture_total_en_cour').html(total_en_cour);
                    $('#view_facture_nb_en_cour').html('(' + nb_facture_en_cour + ')');
                    $('#view_facture_total_solde').html(total_solde);
                    $('#view_facture_nb_solde').html('(' + nb_facture_solde + ')');

                    // Validation des aspects
                    if (!(data.nbr_doc_ready_juridiques_et_administratifs >= 4)) {
                        $('#mask_technique_area_btn').removeClass('d-none');
                        $('#mask_compta_finance_area_btn').removeClass('d-none');
                    } else if (!(data.nbr_doc_ready_techniques >= 1)) {
                        $('#mask_technique_area_btn').addClass('d-none');
                        $('#mask_compta_finance_area_btn').removeClass('d-none');
                    } else{
                        $('#mask_technique_area_btn').addClass('d-none');
                        $('#mask_compta_finance_area_btn').addClass('d-none');
                    }


                    KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                    KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                }
            });

            reload_datatable1();
            reload_datatable2();
            reload_datatable3();

        }

        function date_formatter(date, format) {
            if (date == null) {
                return '--';
            }

            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear(),
                hour = ('0' + d.getHours()).slice(-2),
                minute = ('0' + d.getMinutes()).slice(-2),
                second = ('0' + d.getSeconds()).slice(-2);

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            if (format == 'dd/mm/yyyy') {
                return [day, month, year].join('/');
            } else if (format == 'mm/dd/yyyy') {
                return [month, day, year].join('/');
            } else if (format == 'yyyy/mm/dd') {
                return [year, month, day].join('/');
            } else if (format == 'yyyy/dd/mm') {
                return [year, day, month].join('/');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'dd-mm-yyyy') {
                return [day, month, year].join('-');
            } else if (format == 'mm-dd-yyyy') {
                return [month, day, year].join('-');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'yyyy-dd-mm') {
                return [year, day, month].join('-');
            } else if (format == 'dd/mm/yyyy hh:mm') {
                return [day, month, year].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'mm/dd/yyyy hh:mm') {
                return [month, day, year].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy/mm/dd hh:mm') {
                return [year, month, day].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy/dd/mm hh:mm') {
                return [year, day, month].join('/') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-mm-dd hh:mm') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'dd-mm-yyyy hh:mm') {
                return [day, month, year].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'mm-dd-yyyy hh:mm') {
                return [month, day, year].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-mm-dd hh:mm') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'yyyy-dd-mm hh:mm') {
                return [year, day, month].join('-') + ' ' + hour + ':' + minute;
            } else if (format == 'dd/mm/yyyy hh:mm:ss') {
                return [day, month, year].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'mm/dd/yyyy hh:mm:ss') {
                return [month, day, year].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy/mm/dd hh:mm:ss') {
                return [year, month, day].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy/dd/mm hh:mm:ss') {
                return [year, day, month].join('/') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-mm-dd hh:mm:ss') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'dd-mm-yyyy hh:mm:ss') {
                return [day, month, year].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'mm-dd-yyyy hh:mm:ss') {
                return [month, day, year].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-mm-dd hh:mm:ss') {
                return [year, month, day].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else if (format == 'yyyy-dd-mm hh:mm:ss') {
                return [year, day, month].join('-') + ' ' + hour + ':' + minute + ':' + second;
            } else {
                return [day, month, year].join('/');
            }
        }

        function amount_format(amount, delimitter = ' ') {

            if (amount == null || amount == '' || isNaN(amount)) {
                return '--';
            }

            var delimitter_str = "$1" + delimitter;
            return amount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, delimitter_str);

        }

        // Fait une réquête AJAX pour récupérer les données de la page
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                action: 'fetch_page_client'
            },
            dataType: "JSON",
            success: function(data) {

                // Affiche les données dans la page

                $('#ready_icon_juridiques_et_administratifs').html(data.ready_icon_juridiques_et_administratifs);
                $('#ready_icon_techniques').html(data.ready_icon_techniques);
                $('#ready_icon_comptables_et_financiers').html(data.ready_icon_comptables_et_financiers);

                $('#avatar_client').html(data.avatar_client);
                $('#nom_client').html(data.nom_client);
                $('#email_client').html(data.email_client);
                $('#matricule_client').html(data.matricule_client);
                $('#tel_client').html(data.tel_client);

                $('#ifu_entite').html(data.ifu_entite);
                $('#designation_entite').html(data.designation_entite);
                $('#boite_postal').html(data.boite_postal);
                $('#designation_activite_principale').html(data.designation_activite_principale);
                $('#adresse_geo_complete').html(data.adresse_geo_complete);

                $('#statut_client').html(data.statut_client);
                $('#action_client').html(data.action_client);
                $('#niveau_client').html(data.niveau_client);

                taux_recouvrement = data.taux_recouvrement;
                total_facture = amount_format(data.total_facture);
                total_regle = amount_format(data.total_regle);

                total_echue = amount_format(data.total_echue);
                nb_facture_echue = data.nb_facture_echue;
                total_en_cour = amount_format(data.total_en_cour);
                nb_facture_en_cour = data.nb_facture_en_cour;
                total_solde = amount_format(data.total_solde);
                nb_facture_solde = data.nb_facture_solde;

                $('#view_facture_taux_recouvrement').html(taux_recouvrement + '%');
                $('#view_facture_total_facture').html(total_facture);
                $('#view_facture_total_regle').html(total_regle);

                $('#view_facture_total_echue').html(total_echue);
                $('#view_facture_nb_echue').html('(' + nb_facture_echue + ')');
                $('#view_facture_total_en_cour').html(total_en_cour);
                $('#view_facture_nb_en_cour').html('(' + nb_facture_en_cour + ')');
                $('#view_facture_total_solde').html(total_solde);
                $('#view_facture_nb_solde').html('(' + nb_facture_solde + ')');

                // Validation des aspects
                if (!(data.nbr_doc_ready_juridiques_et_administratifs >= 4)) {
                    $('#mask_technique_area_btn').removeClass('d-none');
                    $('#mask_compta_finance_area_btn').removeClass('d-none');
                } else if (!(data.nbr_doc_ready_techniques >= 1)) {
                    $('#mask_technique_area_btn').addClass('d-none');
                    $('#mask_compta_finance_area_btn').removeClass('d-none');
                } else{
                    $('#mask_technique_area_btn').addClass('d-none');
                    $('#mask_compta_finance_area_btn').addClass('d-none');
                }


                KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
            }
        });

        // Datatable for collabos dossier
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                datatable: 'collabos_dossier',
            },
            dataType: "JSON",
            success: function(data) {
                var collabos_dossier = $('#collabos_dossier').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": false,
                    "bInfo": false,
                    "bFilter": false,
                    "bSort": false,
                    "order": [],
                    "data": data.data,
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });

                $('.sorting').click(function() {
                    setTimeout(() => {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }, 1000);
                })
            }
        });

        // Datatable for documents juridico admin
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                datatable: 'documents_juridico_admin',
                type_dossier_document: $('#filter_type_dossier_document2').val()
            },
            dataType: "JSON",
            success: function(data) {
                var documents_juridico_admin = $('#documents_juridico_admin').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": true,
                    "order": [],
                    "columnDefs": [{
                        "targets": [3],
                        "orderable": false,
                    }, ],
                    "data": data.data,
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });

                $('#kt_filter_search2').keyup(function() {
                    documents_juridico_admin.search($(this).val()).draw();
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

        // Datatable for documents techniques
        $.ajax({
            url: "roll/ag/dossiers/fetch.php",
            method: "POST",
            data: {
                datatable: 'documents_techniques',
                type_dossier_document: $('#filter_type_dossier_document3').val(),
                rubrique_document: $('#filter_rubrique_document3').val()
            },
            dataType: "JSON",
            success: function(data) {
                var documents_techniques = $('#documents_techniques').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "bInfo": true,
                    "bFilter": true,
                    "bSort": true,
                    "order": [],
                    "columnDefs": [{
                        "targets": [3],
                        "orderable": false,
                    }, ],
                    "data": data.data,
                    "initComplete": function(settings, json) {
                        KTMenu.createInstances('.drop_action'); // Ici, nous avons créé des instances de menu ayant pour class .drop_action (Check on line :2599 of scripts.bundle.js) 
                        KTApp.createInstances(); // Ici, nous avons recréer toutes les instances des utilitaires comme "tooltip" "popover" et autres (:6580 of scripts.bundle.js)
                    }
                });

                $('#kt_filter_search3').keyup(function() {
                    documents_techniques.search($(this).val()).draw();
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

        $('#filter_type_dossier_document2').on('change', function(event) {
            reload_datatable2();
        })

        $('#filter_type_dossier_document3').on('change', function(event) {
            reload_datatable3();
        })

        $('#filter_rubrique_document3').on('change', function(event) {
            reload_datatable3();
        })



        // Afficher les infos selon la zone cliquée (generale, avance)
        $(document).on('click', '#generale_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active des autres area
            $('#juridico_admin_area_btn').removeClass('active');
            $('#technique_area_btn').removeClass('active');
            $('#compta_finance_area_btn').removeClass('active');

            // ajout de la classe active de l'element #generale_area_btn
            $('#generale_area_btn').addClass('active');
            // supprimer d-none de l'element #infos_generale
            $('#infos_generale').removeClass('d-none');

            // ajouter d-none aux autres elements
            $('#infos_juridico_admin').addClass('d-none');
            $('#infos_technique').addClass('d-none');
            $('#infos_compta_finance').addClass('d-none');
        })

        $(document).on('click', '#juridico_admin_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active des autres area
            $('#generale_area_btn').removeClass('active');
            $('#technique_area_btn').removeClass('active');
            $('#compta_finance_area_btn').removeClass('active');

            // ajout de la classe active de l'element #generale_area_btn
            $('#juridico_admin_area_btn').addClass('active');
            // supprimer d-none de l'element #infos_generale
            $('#infos_juridico_admin').removeClass('d-none');

            // ajouter d-none aux autres elements
            $('#infos_generale').addClass('d-none');
            $('#infos_technique').addClass('d-none');
            $('#infos_compta_finance').addClass('d-none');
        })

        $(document).on('click', '#technique_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active des autres area
            $('#generale_area_btn').removeClass('active');
            $('#juridico_admin_area_btn').removeClass('active');
            $('#compta_finance_area_btn').removeClass('active');

            // ajout de la classe active de l'element #generale_area_btn
            $('#technique_area_btn').addClass('active');
            // supprimer d-none de l'element #infos_generale
            $('#infos_technique').removeClass('d-none');

            // ajouter d-none aux autres elements
            $('#infos_generale').addClass('d-none');
            $('#infos_juridico_admin').addClass('d-none');
            $('#infos_compta_finance').addClass('d-none');
        })

        $(document).on('click', '#compta_finance_area_btn', function(e) {
            e.preventDefault();

            // suppression de la classe active des autres area
            $('#generale_area_btn').removeClass('active');
            $('#juridico_admin_area_btn').removeClass('active');
            $('#technique_area_btn').removeClass('active');

            // ajout de la classe active de l'element #generale_area_btn
            $('#compta_finance_area_btn').addClass('active');
            // supprimer d-none de l'element #infos_generale
            $('#infos_compta_finance').removeClass('d-none');

            // ajouter d-none aux autres elements
            $('#infos_generale').addClass('d-none');
            $('#infos_juridico_admin').addClass('d-none');
            $('#infos_technique').addClass('d-none');
        })

        // Pour la copie du code document
        var KTModalShareEarn = function() {
            // Private functions
            var handleForm1 = function() {
                var button = document.querySelector('#matricule_client_copy_btn');
                var input = document.querySelector('#matricule_client');
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

            var handleForm2 = function() {
                var button = document.querySelector('#ifu_entite_copy_btn');
                var input = document.querySelector('#ifu_entite');
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
                    handleForm1();
                    handleForm2();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTModalShareEarn.init();
        });

        /* ---------------- Données Page dossier ----------------- */

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
                                reload_page(); // On recharge le datatable

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
                                reload_page(); // On recharge le datatable

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

        // Lorsqu'on clique sur .view_detail_collabo
        $(document).on('click', '.view_detail_collabo', function(e) {
            e.preventDefault();
            var id_collaborateur = $(this).data('id_collaborateur');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_collaborateur: id_collaborateur,
                    action: 'view_detail_collabo'
                },
                dataType: "JSON",
                success: function(data) {

                    $('#detail_collaborateur').html(data.collaborateur);
                    $('#detail_code_collaborateur').html(data.code_collaborateur);
                    $('#detail_telephone_collaborateur').html(data.telephone_collaborateur);
                    $('#detail_email_collaborateur').html(data.email_collaborateur);
                    $('#detail_adresse_collaborateur').html(data.adresse_collaborateur);
                }
            });

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
                        url: "roll/ag/dossiers/fetch.php",
                        method: "POST",
                        data: {
                            id_collaborateur: id_collaborateur,
                            id_client: id_client,
                            action: 'retirer_dossier'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                reload_page(); // On recharge le datatable

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

        // Pour l'attribution un collaborateur à un dossier
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

                            reload_page(); // On recharge le datatable

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

        /* -----------------Données docs juridico admin---------------- */
        function save_doc_write() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_write = tinymce.get('id_edit_doc_write').getContent({
                format: 'text'
            });
            $('#id_edit_doc_write_text').val(docs_write);

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_write').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                        reload_page();
                    } else {
                        toastr.error(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    }
                }
            })
        }

        function save_doc_other_write() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_write = tinymce.get('id_edit_doc_other_write').getContent({
                format: 'text'
            });
            $('#id_edit_doc_other_write_text').val(docs_write);

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_other_write').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                        reload_page();
                    } else {
                        toastr.error(data.message, '', {
                            positionClass: "toastr-bottom-left",
                        });
                    }
                }
            })
        }

        function save_doc_generate() {

            // Récupérer les données text tinymce du briefing et mettre dans un textarea
            var docs_generate = tinymce.get('id_edit_doc_generate').getContent({
                format: 'text'
            });
            $('#id_edit_doc_generate_text').val(docs_generate);

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: $('#form_edit_doc_generate').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
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

        // Pour l'ajout d'un nouveau Document
        $(document).on('submit', '#form_add_doc', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_add_doc');
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            if ($('#generale_area_btn').hasClass('active')) {
                $('#add_doc_modal .modal-footer input[name="aspect"]').val('generale');
            } else if ($('#juridico_admin_area_btn').hasClass('active')) {
                $('#add_doc_modal .modal-footer input[name="aspect"]').val('juridiques_et_administratifs');
            } else if ($('#technique_area_btn').hasClass('active')) {
                $('#add_doc_modal .modal-footer input[name="aspect"]').val('techniques');
            } else if ($('#compta_finance_area_btn').hasClass('active')) {
                $('#add_doc_modal .modal-footer input[name="aspect"]').val('comptables_et_financiers');
            }


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
                            $('#add_doc_modal').modal('hide');
                            $('#form_add_doc')[0].reset();
                            reload_page();

                            if (data.type_document == 'file') {
                                $('#edit_doc_other_file_modal').modal('show');

                                // Variable contenant les fichiers joint
                                fileList = [];
                                fileListPath = [];
                                fileListName = [];
                                // set the dropzone container id
                                var id = "#other_file_upload_zone";
                                var dropzone = document.querySelector(id);

                                var id_document = data.id_document;
                                $.ajax({
                                    url: "roll/ag/dossiers/fetch.php",
                                    method: "POST",
                                    data: {
                                        id_document: id_document,
                                        action: 'fetch_edit_doc_file'
                                    },
                                    dataType: "JSON",
                                    success: function(data) {
                                        $('#edit_doc_other_file_modal input[name="id_document"]').val(id_document);
                                        $('#edit_doc_other_file_modal .modal-title').html(data.titre_document);


                                        /* -----------------Mise en place du plugin dropzonejs---------------- */
                                        // set the preview element template
                                        var previewTemplate = `
                                            <div class="dropzone-item">
                                                <!--begin::File-->
                                                <div class="dropzone-file">
                                                    <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                        <span data-dz-name>some_image_file_name.jpg</span>
                                                        <strong>(<span data-dz-size>340kb</span>)</strong>
                                                    </div>

                                                    <div class="dropzone-error" data-dz-errormessage></div>
                                                </div>
                                                <!--end::File-->

                                                <!--begin::Progress-->
                                                <div class="dropzone-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->

                                                <!--begin::Toolbar-->
                                                <div class="dropzone-toolbar">
                                                    <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                                </div>
                                                <!--end::Toolbar-->
                                            </div>
                                        `;
                                        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
                                            url: "roll/ag/dossiers/fetch.php?titre_document=" + data.titre_document + "&id_document=" + id_document + "&action=doc_file_upload", // Set the url for your upload script location
                                            parallelUploads: 20,
                                            maxFilesize: 10, // Max filesize in MB
                                            maxFiles: 1,
                                            previewTemplate: previewTemplate,
                                            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                                            clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
                                        });

                                        // When added file
                                        myDropzone.on("addedfile", function(file) {
                                            // Hookup the start button
                                            const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
                                            dropzoneItems.forEach(dropzoneItem => {
                                                dropzoneItem.style.display = '';
                                            });
                                        });
                                        // Packaging of files in array
                                        myDropzone.on("success", function(file, serverFileName) {
                                            fileList.push({
                                                "serverPath": serverFileName,
                                                "uploadId": file.upload.uuid
                                            });
                                            fileListPath.push(serverFileName);
                                            fileListName.push(file.name);

                                        });
                                        // Remove file from the list
                                        myDropzone.on("removedfile", function(file) {
                                            for (let i = 0; i < fileList.length; i++) {
                                                if (file.upload.uuid == fileList[i].uploadId) {
                                                    $.ajax({
                                                        url: "roll/ag/dossiers/fetch.php",
                                                        method: "POST",
                                                        data: {
                                                            action: 'delete_doc_file_upload',
                                                            id_document: id_document,
                                                            file_path: fileList[i].serverPath,
                                                        },
                                                        dataType: "json",
                                                        success: function(data) {
                                                            // do something
                                                        }
                                                    })
                                                    fileList.splice(i, 1)
                                                    fileListPath.splice(i, 1)
                                                    fileListName.splice(i, 1)
                                                }
                                            }

                                            // var server_file = $(file.previewTemplate).children('.server_file').text();
                                            // alert(server_file);
                                            // // Do a post request and pass this path and use server-side language to delete the file
                                            // $.post("delete.php", {
                                            // 	file_to_be_deleted: server_file
                                            // });
                                        });
                                        // Update the total progress bar
                                        myDropzone.on("totaluploadprogress", function(progress) {
                                            const progressBars = dropzone.querySelectorAll('.progress-bar');
                                            progressBars.forEach(progressBar => {
                                                progressBar.style.width = progress + "%";
                                            });
                                        });
                                        // Sending files to server
                                        myDropzone.on("sending", function(file) {
                                            // Show the total progress bar when upload starts
                                            const progressBars = dropzone.querySelectorAll('.progress-bar');
                                            progressBars.forEach(progressBar => {
                                                progressBar.style.opacity = "1";
                                            });
                                        });
                                        // Hide the total progress bar when nothing"s uploading anymore
                                        myDropzone.on("complete", function(progress) {
                                            const progressBars = dropzone.querySelectorAll('.dz-complete');

                                            setTimeout(function() {
                                                progressBars.forEach(progressBar => {
                                                    progressBar.querySelector('.progress-bar').style.opacity = "0";
                                                    progressBar.querySelector('.progress').style.opacity = "0";
                                                });
                                            }, 300);
                                        });

                                        // Si on quitte le modal
                                        $('#edit_doc_other_file_modal').on('hidden.bs.modal', function() {
                                            // Supprimer l'instance de dropzone
                                            myDropzone.destroy();

                                            // Remove file from the list
                                            for (let i = 0; i < fileList.length; i++) {
                                                $.ajax({
                                                    url: "roll/ag/dossiers/fetch.php",
                                                    method: "POST",
                                                    data: {
                                                        action: 'delete_doc_file_upload',
                                                        id_document: id_document,
                                                        file_path: fileList[i].serverPath,
                                                    },
                                                    dataType: "json",
                                                    success: function(data) {
                                                        // do something
                                                    }
                                                })
                                                fileList.splice(i, 1)
                                                fileListPath.splice(i, 1)
                                                fileListName.splice(i, 1)
                                            }
                                        });

                                        //Lorsque l'utilisateur tente de quitter la page
                                        $(window).on('beforeunload', function() {
                                            // Remove file from the list
                                            for (let i = 0; i < fileList.length; i++) {
                                                $.ajax({
                                                    url: "roll/ag/dossiers/fetch.php",
                                                    method: "POST",
                                                    data: {
                                                        action: 'delete_doc_file_upload',
                                                        id_document: id_document,
                                                        file_path: fileList[i].serverPath,
                                                    },
                                                    dataType: "json",
                                                    success: function(data) {
                                                        // do something
                                                    }
                                                })
                                                fileList.splice(i, 1)
                                                fileListPath.splice(i, 1)
                                                fileListName.splice(i, 1)
                                            }
                                        });

                                    }
                                })

                                // Lorsqu'on soumet le formulaire d'édition d'un document file
                                $(document).on('submit', '#form_edit_doc_other_file', function(event) {
                                    event.preventDefault();

                                    // Show loading indication
                                    formSubmitButton = document.querySelector('#btn_edit_doc_other_file');
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
                                                    $('#edit_doc_other_file_modal').modal('hide');

                                                    // swal
                                                    Swal.fire({
                                                        title: "Document ajouté !",
                                                        html: data.message,
                                                        icon: "success",
                                                        buttonsStyling: false,
                                                        confirmButtonText: "Ok, j'ai compris !",
                                                        customClass: {
                                                            confirmButton: "btn fw-bold btn-primary"
                                                        }
                                                    });

                                                    // Vider les fileLists
                                                    fileList = [];
                                                    fileListPath = [];
                                                    fileListName = [];

                                                    reload_page(); // On recharge le datatable

                                                } else {
                                                    toastr.error(data.message, '', {
                                                        positionClass: "toastr-bottom-left",
                                                    });
                                                }

                                            }, 2000);

                                        }
                                    })
                                });
                            } else if (data.type_document == 'write') {

                                $('#edit_doc_other_write_modal').modal('show');

                                var id_document = data.id_document;
                                $('#edit_doc_other_write_modal .loader').show();

                                $.ajax({
                                    url: "roll/ag/dossiers/fetch.php",
                                    method: "POST",
                                    data: {
                                        id_document: id_document,
                                        action: 'fetch_edit_doc_write'
                                    },
                                    dataType: "JSON",
                                    success: function(data) {
                                        $('#edit_doc_other_write_modal input[name="id_document"]').val(id_document);
                                        $('#edit_doc_other_write_modal .modal-title').html(data.titre_document);

                                        // Initialiser l'éditeur graphique tinymce pour la modification d'un document generate (une fois)
                                        if (typeof tinymce_other_write == 'undefined') {
                                            $('#edit_doc_other_write_modal .modal-body #id_edit_doc_other_write').html("");

                                            tinymce_other_write = tinymce.init({
                                                selector: '#id_edit_doc_other_write',
                                                menubar: false,
                                                language: 'fr_FR',
                                                content_css: 'document',
                                                plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                                                toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | numlist bullist | outdent indent | pagebreak | table',
                                                pagebreak_separator: '<div style="page-break-after: always;"></div>',
                                                save_onsavecallback: save_doc_other_write,
                                            });
                                            // Prevent Bootstrap dialog from blocking focusin for TinyMCE
                                            document.addEventListener('focusin', (e) => {
                                                if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                                                    e.stopImmediatePropagation();
                                                }
                                            });

                                            setTimeout(function() {
                                                $('#edit_doc_other_write_modal .loader').hide();
                                            }, 2000);
                                        } else {

                                            // Reset editor and set a new content
                                            tinymce.get('id_edit_doc_other_write').resetContent("");

                                            setTimeout(function() {
                                                $('#edit_doc_other_write_modal .loader').hide();
                                            }, 2000);
                                        }

                                    }
                                })

                            }

                        } else {
                            toastr.error('une erreur s\'est produite', '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }
                    }, 2000);

                }
            })
        });

        // Pour l'affichage des détails d'un document
        $(document).on('click', '.view_detail_document', function() {
            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'view_detail_document'
                },
                dataType: "JSON",
                success: function(data) {

                    $('#detail_doc_aspect').html(data.aspect_document);
                    $('#detail_doc_code').html(data.code_document);
                    $('#detail_doc_titre').html(data.titre_document);
                    $('#detail_doc_statut').html(data.statut_document);
                    $('#detail_doc_created_by').html('<u>' + data.created_by_document + '</u>' + ' le ' + data.created_at_document);
                    $('#detail_doc_updated_by').html('<u>' + data.updated_by_document + '</u>' + ' le ' + data.updated_at_document);

                }
            })
        });

        // Pour voir l'aperçu d'un document write
        $(document).on('click', '.preview_doc_write', function(e) {

            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_write'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_write_modal .doc-content').html(data.contenu_document);
                    $('#preview_doc_write_modal .modal-title').html(data.titre_document);
                }
            })

        });

        // Pour voir l'aperçu d'un document generate
        $(document).on('click', '.preview_doc_generate', function(e) {

            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_generate'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_generate_modal .doc-content').html(data.contenu_document);
                    $('#preview_doc_generate_modal .modal-title').html(data.titre_document);
                }
            })

        });

        // Pour voir l'aperçu d'un document file
        $(document).on('click', '.preview_doc_file', function(e) {

            var id_document = $(this).data('id_document');
            $('#preview_doc_file_modal .refresh-preview').data('id_document', id_document);

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_file'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_file_modal .doc-content').html(data.iframe_html);
                    $('#preview_doc_file_modal .modal-title').html(data.titre_document);
                }
            })

        });

        // Pour voir l'aperçu d'un document scan
        $(document).on('click', '.preview_doc_scan', function(e) {

            var id_document = $(this).data('id_document');
            $('#preview_doc_scan_modal .refresh-preview').data('id_document', id_document);

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_scan'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_scan_modal .doc-content').html(data.iframe_html);
                    $('#preview_doc_scan_modal .modal-title').html(data.titre_document);
                }
            })

        });

        // Quand on clique sur .preview_doc_file_modal .refresh-preview
        $(document).on('click', '#preview_doc_file_modal .refresh-preview', function(e) {
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_file'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_file_modal .doc-content').html(data.iframe_html);
                    $('#preview_doc_file_modal .modal-title').html(data.titre_document);
                }
            })
        });

        // Quand on clique sur .preview_doc_scan_modal .refresh-preview
        $(document).on('click', '#preview_doc_scan_modal .refresh-preview', function(e) {
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'preview_doc_scan'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#preview_doc_scan_modal .doc-content').html(data.iframe_html);
                    $('#preview_doc_scan_modal .modal-title').html(data.titre_document);
                }
            })
        });

        /* -----------------Modification d'un document write---------------- */
        //Lorsqu'on clique sur .edit_doc_write
        $(document).on('click', '.edit_doc_write', function() {

            var id_document = $(this).data('id_document');
            $('#edit_doc_write_modal .loader').show();

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_write'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_write_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_write_modal .modal-title').html(data.titre_document);

                    // Initialiser l'éditeur graphique tinymce pour la modification d'un document generate (une fois)
                    if (typeof tinymce_write == 'undefined') {
                        $('#edit_doc_write_modal .modal-body #id_edit_doc_write').html(data.contenu_document);

                        tinymce_write = tinymce.init({
                            selector: '#id_edit_doc_write',
                            menubar: false,
                            language: 'fr_FR',
                            content_css: 'document',
                            plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                            toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | numlist bullist | outdent indent | pagebreak | table',
                            pagebreak_separator: '<div style="page-break-after: always;"></div>',
                            save_onsavecallback: save_doc_write,
                        });
                        // Prevent Bootstrap dialog from blocking focusin for TinyMCE
                        document.addEventListener('focusin', (e) => {
                            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                                e.stopImmediatePropagation();
                            }
                        });

                        setTimeout(function() {
                            $('#edit_doc_write_modal .loader').hide();
                        }, 2000);
                    } else {

                        // Reset editor and set a new content
                        tinymce.get('id_edit_doc_write').resetContent(data.contenu_document);

                        setTimeout(function() {
                            $('#edit_doc_write_modal .loader').hide();
                        }, 2000);
                    }

                }
            })
        });

        /* -----------------Modification d'un document generate---------------- */
        //Lorsqu'on clique sur .edit_doc_generate
        $(document).on('click', '.edit_doc_generate', function() {

            var id_document = $(this).data('id_document');
            $('#edit_doc_generate_modal .loader').show();

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_generate'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_generate_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_generate_modal .modal-title').html(data.titre_document);

                    // Initialiser l'éditeur graphique tinymce pour la modification d'un document generate (une fois)
                    if (typeof tinymce_generate == 'undefined') {
                        $('#edit_doc_generate_modal .modal-body #id_edit_doc_generate').html(data.contenu_document);

                        tinymce_generate = tinymce.init({
                            selector: '#id_edit_doc_generate',
                            menubar: false,
                            language: 'fr_FR',
                            content_css: 'document',
                            content_style: 'body { padding: 25px !important; max-width: 1050px !important; min-height: 75% !important;}',
                            plugins: 'print importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars export',
                            toolbar: 'save undo redo | bold italic underline strikethrough | link image | forecolor backcolor | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | lineheight | fullscreen | numlist bullist | outdent indent | pagebreak | table',
                            pagebreak_separator: '<div style="page-break-after: always;"></div>',
                            save_onsavecallback: save_doc_generate,
                        });
                        // Prevent Bootstrap dialog from blocking focusin for TinyMCE
                        document.addEventListener('focusin', (e) => {
                            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                                e.stopImmediatePropagation();
                            }
                        });

                        setTimeout(function() {
                            $('#edit_doc_generate_modal .loader').hide();
                        }, 2000);
                    } else {

                        // Reset editor and set a new content
                        tinymce.get('id_edit_doc_generate').resetContent(data.contenu_document);

                        setTimeout(function() {
                            $('#edit_doc_generate_modal .loader').hide();
                        }, 2000);
                    }

                }
            })
        });

        /* -----------------Modification d'un document file---------------- */
        //Variable contenant les fichiers joint
        fileList = [];
        fileListPath = [];
        fileListName = [];
        // set the dropzone container id
        const id = "#file_upload_zone";
        const dropzone = document.querySelector(id);

        // Lorsqu'on clique sur .edit_doc_file
        $(document).on('click', '.edit_doc_file', function() {

            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_file'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_file_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_file_modal .modal-title').html(data.titre_document);


                    /* -----------------Mise en place du plugin dropzonejs---------------- */
                    // set the preview element template
                    var previewTemplate = `
                        <div class="dropzone-item">
                            <!--begin::File-->
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                    <span data-dz-name>some_image_file_name.jpg</span>
                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                </div>

                                <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                    `;
                    var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
                        url: "roll/ag/dossiers/fetch.php?titre_document=" + data.titre_document + "&id_document=" + id_document + "&action=doc_file_upload", // Set the url for your upload script location
                        parallelUploads: 20,
                        maxFilesize: 10, // Max filesize in MB
                        maxFiles: 1,
                        previewTemplate: previewTemplate,
                        previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                        clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
                    });

                    // When added file
                    myDropzone.on("addedfile", function(file) {
                        // Hookup the start button
                        const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
                        dropzoneItems.forEach(dropzoneItem => {
                            dropzoneItem.style.display = '';
                        });
                    });
                    // Packaging of files in array
                    myDropzone.on("success", function(file, serverFileName) {
                        fileList.push({
                            "serverPath": serverFileName,
                            "uploadId": file.upload.uuid
                        });
                        fileListPath.push(serverFileName);
                        fileListName.push(file.name);

                    });
                    // Remove file from the list
                    myDropzone.on("removedfile", function(file) {
                        for (let i = 0; i < fileList.length; i++) {
                            if (file.upload.uuid == fileList[i].uploadId) {
                                $.ajax({
                                    url: "roll/ag/dossiers/fetch.php",
                                    method: "POST",
                                    data: {
                                        action: 'delete_doc_file_upload',
                                        id_document: id_document,
                                        file_path: fileList[i].serverPath,
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        // do something
                                    }
                                })
                                fileList.splice(i, 1)
                                fileListPath.splice(i, 1)
                                fileListName.splice(i, 1)
                            }
                        }

                        // var server_file = $(file.previewTemplate).children('.server_file').text();
                        // alert(server_file);
                        // // Do a post request and pass this path and use server-side language to delete the file
                        // $.post("delete.php", {
                        // 	file_to_be_deleted: server_file
                        // });
                    });
                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function(progress) {
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.width = progress + "%";
                        });
                    });
                    // Sending files to server
                    myDropzone.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        const progressBars = dropzone.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.opacity = "1";
                        });
                    });
                    // Hide the total progress bar when nothing"s uploading anymore
                    myDropzone.on("complete", function(progress) {
                        const progressBars = dropzone.querySelectorAll('.dz-complete');

                        setTimeout(function() {
                            progressBars.forEach(progressBar => {
                                progressBar.querySelector('.progress-bar').style.opacity = "0";
                                progressBar.querySelector('.progress').style.opacity = "0";
                            });
                        }, 300);
                    });

                    // Si on quitte le modal
                    $('#edit_doc_file_modal').on('hidden.bs.modal', function() {
                        // Supprimer l'instance de dropzone
                        myDropzone.destroy();

                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_file_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                    //Lorsque l'utilisateur tente de quitter la page
                    $(window).on('beforeunload', function() {
                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_file_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                }
            })
        });

        // Lorsqu'on soumet le formulaire d'édition d'un document file
        $(document).on('submit', '#form_edit_doc_file', function(event) {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_doc_file');
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
                            $('#edit_doc_file_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Document enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            // Vider les fileLists
                            fileList = [];
                            fileListPath = [];
                            fileListName = [];

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        /* -----------------Modification d'un document scan---------------- */
        //Variable contenant les fichiers joint
        fileList = [];
        fileListPath = [];
        fileListName = [];
        // set the dropzone container id
        const id1 = "#scan_upload_zone";
        const dropzone1 = document.querySelector(id1);

        // Lorsqu'on clique sur .edit_doc_scan
        $(document).on('click', '.edit_doc_scan', function() {

            var id_document = $(this).data('id_document');
            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_scan'
                },
                dataType: "JSON",
                success: function(data) {
                    $('#edit_doc_scan_modal input[name="id_document"]').val(id_document);
                    $('#edit_doc_scan_modal .modal-title').html(data.titre_document);


                    /* -----------------Mise en place du plugin dropzonejs---------------- */
                    // set the preview element template
                    var previewTemplate = `
                        <div class="dropzone-item">
                            <!--begin::File-->
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                    <span data-dz-name>some_image_file_name.jpg</span>
                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                </div>

                                <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                    `;
                    var myDropzone = new Dropzone(id1, { // Make the whole body a dropzone
                        url: "roll/ag/dossiers/fetch.php?titre_document=" + data.titre_document + "&id_document=" + id_document + "&action=doc_scan_upload", // Set the url for your upload script location
                        parallelUploads: 20,
                        maxFilesize: 10, // Max filesize in MB
                        maxFiles: 1,
                        previewTemplate: previewTemplate,
                        previewsContainer: id1 + " .dropzone-items", // Define the container to display the previews
                        clickable: id1 + " .dropzone-select" // Define the element that should be used as click trigger to select files.
                    });

                    // When added file
                    myDropzone.on("addedfile", function(file) {
                        // Hookup the start button
                        const dropzoneItems = dropzone1.querySelectorAll('.dropzone-item');
                        dropzoneItems.forEach(dropzoneItem => {
                            dropzoneItem.style.display = '';
                        });
                    });
                    // Packaging of files in array
                    myDropzone.on("success", function(file, serverFileName) {
                        fileList.push({
                            "serverPath": serverFileName,
                            "uploadId": file.upload.uuid
                        });
                        fileListPath.push(serverFileName);
                        fileListName.push(file.name);

                    });
                    // Remove file from the list
                    myDropzone.on("removedfile", function(file) {
                        for (let i = 0; i < fileList.length; i++) {
                            if (file.upload.uuid == fileList[i].uploadId) {
                                $.ajax({
                                    url: "roll/ag/dossiers/fetch.php",
                                    method: "POST",
                                    data: {
                                        action: 'delete_doc_scan_upload',
                                        id_document: id_document,
                                        file_path: fileList[i].serverPath,
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        // do something
                                    }
                                })
                                fileList.splice(i, 1)
                                fileListPath.splice(i, 1)
                                fileListName.splice(i, 1)
                            }
                        }

                        // var server_file = $(file.previewTemplate).children('.server_file').text();
                        // alert(server_file);
                        // // Do a post request and pass this path and use server-side language to delete the file
                        // $.post("delete.php", {
                        // 	file_to_be_deleted: server_file
                        // });
                    });
                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function(progress) {
                        const progressBars = dropzone1.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.width = progress + "%";
                        });
                    });
                    // Sending files to server
                    myDropzone.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        const progressBars = dropzone1.querySelectorAll('.progress-bar');
                        progressBars.forEach(progressBar => {
                            progressBar.style.opacity = "1";
                        });
                    });
                    // Hide the total progress bar when nothing"s uploading anymore
                    myDropzone.on("complete", function(progress) {
                        const progressBars = dropzone1.querySelectorAll('.dz-complete');

                        setTimeout(function() {
                            progressBars.forEach(progressBar => {
                                progressBar.querySelector('.progress-bar').style.opacity = "0";
                                progressBar.querySelector('.progress').style.opacity = "0";
                            });
                        }, 300);
                    });

                    // Si on quitte le modal
                    $('#edit_doc_scan_modal').on('hidden.bs.modal', function() {
                        // Supprimer l'instance de dropzone
                        myDropzone.destroy();

                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_scan_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                    //Lorsque l'utilisateur tente de quitter la page
                    $(window).on('beforeunload', function() {
                        // Remove file from the list
                        for (let i = 0; i < fileList.length; i++) {
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    action: 'delete_doc_scan_upload',
                                    id_document: id_document,
                                    file_path: fileList[i].serverPath,
                                },
                                dataType: "json",
                                success: function(data) {
                                    // do something
                                }
                            })
                            fileList.splice(i, 1)
                            fileListPath.splice(i, 1)
                            fileListName.splice(i, 1)
                        }
                    });

                }
            })
        });

        // Lorsqu'on soumet le formulaire d'édition d'un document file
        $(document).on('submit', '#form_edit_doc_scan', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_doc_scan');
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
                            $('#edit_doc_scan_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Document enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            // Vider les fileLists
                            fileList = [];
                            fileListPath = [];
                            fileListName = [];

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });


        /* -----------------Modification d'un formulaire docs generate---------------- */
        function date_formatter(date, format) {
            if (date == null) {
                return '';
            }

            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            if (format == 'dd/mm/yyyy') {
                return [day, month, year].join('/');
            } else if (format == 'mm/dd/yyyy') {
                return [month, day, year].join('/');
            } else if (format == 'yyyy/mm/dd') {
                return [year, month, day].join('/');
            } else if (format == 'yyyy/dd/mm') {
                return [year, day, month].join('/');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'dd-mm-yyyy') {
                return [day, month, year].join('-');
            } else if (format == 'mm-dd-yyyy') {
                return [month, day, year].join('-');
            } else if (format == 'yyyy-mm-dd') {
                return [year, month, day].join('-');
            } else if (format == 'yyyy-dd-mm') {
                return [year, day, month].join('-');
            }
        }

        // Lorsqu'on clique sur .edit_form_doc_generate
        init_repeater_count_edit_form_doc_generate = 0;
        $(document).on('click', '.edit_form_doc_generate', function(e) {
            e.preventDefault();
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_doc_generate'
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.table_document == 'doc_8_fiche_id_client') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;
                        adresse = data.adresse;
                        id_fiscale_client = data.id_fiscale_client;
                        exercice_clos_le = date_formatter(data.exercice_clos_le, 'yyyy-mm-dd');
                        duree_en_mois = data.duree_en_mois;
                        exercice_compta_du = date_formatter(data.exercice_compta_du, 'yyyy-mm-dd');
                        exercice_compta_au = date_formatter(data.exercice_compta_au, 'yyyy-mm-dd');
                        date_arret_compta = date_formatter(data.date_arret_compta, 'yyyy-mm-dd');
                        exercice_prev_clos_le = date_formatter(data.exercice_prev_clos_le, 'yyyy-mm-dd');
                        duree_exercice_prev_en_mois = data.duree_exercice_prev_en_mois;
                        greffe = data.greffe;
                        num_registre_commerce = data.num_registre_commerce;
                        num_repertoire_entite = data.num_repertoire_entite;
                        num_caisse_sociale = data.num_caisse_sociale;
                        num_code_importateur = data.num_code_importateur;
                        code_activite_principale = data.code_activite_principale;
                        designation_entite = data.designation_entite;
                        sigle = data.sigle;
                        telephone = data.telephone;
                        email = data.email;
                        num_code = data.num_code;
                        code = data.code;
                        boite_postal = data.boite_postal;
                        ville = data.ville;
                        adresse_geo_complete = data.adresse_geo_complete;
                        designation_activite_principale = data.designation_activite_principale;
                        personne_a_contacter = data.personne_a_contacter;
                        professionnel_salarie_ou_cabinet = data.professionnel_salarie_ou_cabinet;
                        visa_expert = data.visa_expert;
                        etats_financiers_approuves = data.etats_financiers_approuves;

                        forme_juridique_1 = data.forme_juridique_1;
                        forme_juridique_2 = data.forme_juridique_2;
                        regime_fiscal_1 = data.regime_fiscal_1;
                        regime_fiscal_2 = data.regime_fiscal_2;
                        pays_siege_social_1 = data.pays_siege_social_1;
                        pays_siege_social_2 = data.pays_siege_social_2;
                        nbr_etablissement_in = data.nbr_etablissement_in;
                        nbr_etablissement_out = data.nbr_etablissement_out;
                        prem_annee_exercice_in = data.prem_annee_exercice_in;
                        controle_entite = data.controle_entite;

                        duree_vie_societe = data.duree_vie_societe;
                        date_dissolution = date_formatter(data.date_dissolution, 'yyyy-mm-dd');
                        capital_social = data.capital_social;
                        siege_social = data.siege_social;
                        site_internet = data.site_internet;
                        nombre_de_salarie = data.nombre_de_salarie;
                        ca_3_derniers_exercices_n_1 = data.ca_3_derniers_exercices_n_1;
                        ca_3_derniers_exercices_n_2 = data.ca_3_derniers_exercices_n_2;
                        ca_3_derniers_exercices_n_3 = data.ca_3_derniers_exercices_n_3;

                        date_ouverture_dossier = date_formatter(data.date_ouverture_dossier, 'yyyy-mm-dd');
                        nom_cabinet_confrere = data.nom_cabinet_confrere;
                        dossier_herite_confrere = data.dossier_herite_confrere;


                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal .modal-title').html(titre_document);

                        $('#table_doc_8_fiche_id_client_adresse').val(adresse);
                        $('#table_doc_8_fiche_id_client_id_fiscale_client').val(id_fiscale_client);
                        $('#table_doc_8_fiche_id_client_exercice_clos_le').val(exercice_clos_le);
                        $('#table_doc_8_fiche_id_client_duree_en_mois').val(duree_en_mois);
                        $('#table_doc_8_fiche_id_client_exercice_compta_du').val(exercice_compta_du);
                        $('#table_doc_8_fiche_id_client_exercice_compta_au').val(exercice_compta_au);
                        $('#table_doc_8_fiche_id_client_date_arret_compta').val(date_arret_compta);
                        $('#table_doc_8_fiche_id_client_exercice_prev_clos_le').val(exercice_prev_clos_le);
                        $('#table_doc_8_fiche_id_client_duree_exercice_prev_en_mois').val(duree_exercice_prev_en_mois);
                        $('#table_doc_8_fiche_id_client_greffe').val(greffe);
                        $('#table_doc_8_fiche_id_client_num_registre_commerce').val(num_registre_commerce);
                        $('#table_doc_8_fiche_id_client_num_repertoire_entite').val(num_repertoire_entite);
                        $('#table_doc_8_fiche_id_client_num_caisse_sociale').val(num_caisse_sociale);
                        $('#table_doc_8_fiche_id_client_num_code_importateur').val(num_code_importateur);
                        $('#table_doc_8_fiche_id_client_code_activite_principale').val(code_activite_principale);
                        $('#table_doc_8_fiche_id_client_designation_entite').val(designation_entite);
                        $('#table_doc_8_fiche_id_client_sigle').val(sigle);
                        $('#table_doc_8_fiche_id_client_telephone').val(telephone);
                        $('#table_doc_8_fiche_id_client_email').val(email);
                        $('#table_doc_8_fiche_id_client_num_code').val(num_code);
                        $('#table_doc_8_fiche_id_client_code').val(code);
                        $('#table_doc_8_fiche_id_client_boite_postal').val(boite_postal);
                        $('#table_doc_8_fiche_id_client_ville').val(ville);
                        $('#table_doc_8_fiche_id_client_adresse_geo_complete').val(adresse_geo_complete);
                        $('#table_doc_8_fiche_id_client_designation_activite_principale').val(designation_activite_principale);
                        $('#table_doc_8_fiche_id_client_personne_a_contacter').val(personne_a_contacter);
                        $('#table_doc_8_fiche_id_client_professionnel_salarie_ou_cabinet').val(professionnel_salarie_ou_cabinet);
                        $('#table_doc_8_fiche_id_client_visa_expert').val(visa_expert);
                        if (etats_financiers_approuves == 'oui') {
                            $('#table_doc_8_fiche_id_client_etats_financiers_approuves_oui').prop('checked', true);
                        } else {
                            $('#table_doc_8_fiche_id_client_etats_financiers_approuves_non').prop('checked', true);
                        }


                        $('#table_doc_8_fiche_id_client_forme_juridique_1').val(forme_juridique_1);
                        $('#table_doc_8_fiche_id_client_forme_juridique_2').val(forme_juridique_2);
                        $('#table_doc_8_fiche_id_client_regime_fiscal_1').val(regime_fiscal_1);
                        $('#table_doc_8_fiche_id_client_regime_fiscal_2').val(regime_fiscal_2);
                        $('#table_doc_8_fiche_id_client_pays_siege_social_1').val(pays_siege_social_1);
                        $('#table_doc_8_fiche_id_client_pays_siege_social_2').val(pays_siege_social_2);
                        $('#table_doc_8_fiche_id_client_nbr_etablissement_in').val(nbr_etablissement_in);
                        $('#table_doc_8_fiche_id_client_nbr_etablissement_out').val(nbr_etablissement_out);
                        $('#table_doc_8_fiche_id_client_prem_annee_exercice_in').val(prem_annee_exercice_in);
                        if (controle_entite == 'public') {
                            $('#table_doc_8_fiche_id_client_controle_entite_public').prop('checked', true);
                        } else if (controle_entite == 'prive_national') {
                            $('#table_doc_8_fiche_id_client_controle_entite_prive_national').prop('checked', true);
                        } else if (controle_entite == 'prive_etranger') {
                            $('#table_doc_8_fiche_id_client_controle_entite_prive_etranger').prop('checked', true);
                        }

                        $('#table_doc_8_fiche_id_client_duree_vie_societe').val(duree_vie_societe);
                        $('#table_doc_8_fiche_id_client_date_dissolution').val(date_dissolution);
                        $('#table_doc_8_fiche_id_client_capital_social').val(capital_social);
                        $('#table_doc_8_fiche_id_client_siege_social').val(siege_social);
                        $('#table_doc_8_fiche_id_client_site_internet').val(site_internet);
                        $('#table_doc_8_fiche_id_client_nombre_de_salarie').val(nombre_de_salarie);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_1').val(ca_3_derniers_exercices_n_1);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_2').val(ca_3_derniers_exercices_n_2);
                        $('#table_doc_8_fiche_id_client_ca_3_derniers_exercices_n_3').val(ca_3_derniers_exercices_n_3);


                        $('#table_doc_8_fiche_id_client_date_ouverture_dossier').val(date_ouverture_dossier);
                        $('#table_doc_8_fiche_id_client_nom_cabinet_confrere').val(nom_cabinet_confrere);
                        $('#table_doc_8_fiche_id_client_dossier_herite_confrere').val(dossier_herite_confrere);

                        init_repeater_count_edit_form_doc_generate++;
                        if (init_repeater_count_edit_form_doc_generate == 1) {
                            // Fetch data for activite_client (Repeater)
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'activite_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-2">
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">Designation</label>
                                                    <input name="designation_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Désignation de l'activité" /> -->
                                                    <div class="form-floating">
                                                        <input name="designation_activite_client" type="text" class="form-control" placeholder="Désignation de l'activité"/>
                                                        <label>Designation</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <label class="form-label">Nomenclature</label>
                                                    <input name="code_nomenclature_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Code nomenclature d'activité" /> -->
                                                    <div class="form-floating">
                                                        <input name="code_nomenclature_activite_client" type="text" class="form-control" placeholder="Code nomenclature d'activité"/>
                                                        <label>Nomenclature</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">Chiffre d'affaires HT</label>
                                                    <input name="chiffre_affaires_ht_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="Chiffre d'affaires HT" /> -->
                                                    <div class="form-floating">
                                                        <input name="chiffre_affaires_ht_activite_client" type="number" class="form-control" placeholder="Chiffre d'affaires HT"/>
                                                        <label>Chiffre d'affaires HT</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label">% activité dans le CA</label>
                                                    <input name="percent_activite_in_ca_activite_client" type="text" class="form-control mb-2 mb-md-0" placeholder="% activité dans le CA HT" /> -->
                                                    <div class="form-floating">
                                                        <input name="percent_activite_in_ca_activite_client" type="number" class="form-control" placeholder="% activité dans le CA HT"/>
                                                        <label>% activité dans le CA</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_activite_client_repeater div[data-repeater-list="activite_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="designation_activite_client"]').val(data[i].designation_activite_client);
                                        $(parent + ' ' + 'input[name="code_nomenclature_activite_client"]').val(data[i].code_nomenclature_activite_client);
                                        $(parent + ' ' + 'input[name="chiffre_affaires_ht_activite_client"]').val(data[i].chiffre_affaires_ht_activite_client);
                                        $(parent + ' ' + 'input[name="percent_activite_in_ca_activite_client"]').val(data[i].percent_activite_in_ca_activite_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_activite_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });


                                }
                            });

                            // Fetch data for dirigeant_client (Repeater)
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'dirigeant_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="nom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Nom"/>
                                                        <label>Nom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="prenom_dirigeant_client" type="text" class="form-control mb-2" placeholder="Prénom"/>
                                                        <label>Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="qualite_dirigeant_client" type="text" class="form-control mb-2" placeholder="Qualité"/>
                                                        <label>Qualité</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="id_fiscal_dirigeant_client" type="number" class="form-control mb-2" placeholder="N° identification fiscale"/>
                                                        <label>N° identification fiscale</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="tel_dirigeant_client" type="text" class="form-control mb-2" placeholder="Téléphone"/>
                                                        <label>Téléphone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="mail_dirigeant_client" type="email" class="form-control mb-2" placeholder="Mail"/>
                                                        <label>Mail</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="adresse_dirigeant_client" type="text" class="form-control mb-2" placeholder="Adresse"/>
                                                        <label>Adresse</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_dirigeant_client_repeater div[data-repeater-list="dirigeant_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="nom_dirigeant_client"]').val(data[i].nom_dirigeant_client);
                                        $(parent + ' ' + 'input[name="prenom_dirigeant_client"]').val(data[i].prenom_dirigeant_client);
                                        $(parent + ' ' + 'input[name="qualite_dirigeant_client"]').val(data[i].qualite_dirigeant_client);
                                        $(parent + ' ' + 'input[name="id_fiscal_dirigeant_client"]').val(data[i].id_fiscal_dirigeant_client);
                                        $(parent + ' ' + 'input[name="tel_dirigeant_client"]').val(data[i].tel_dirigeant_client);
                                        $(parent + ' ' + 'input[name="mail_dirigeant_client"]').val(data[i].mail_dirigeant_client);
                                        $(parent + ' ' + 'input[name="adresse_dirigeant_client"]').val(data[i].adresse_dirigeant_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_dirigeant_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });

                                }
                            });

                            // Fetch data for membre_conseil_client (Repeater)
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'membre_conseil_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="nom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Nom"/>
                                                        <label>Nom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="prenom_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Prénom"/>
                                                        <label>Prénom</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="qualite_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Qualité"/>
                                                        <label>Qualité</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="tel_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Téléphone"/>
                                                        <label>Téléphone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="mail_membre_conseil_client" type="email" class="form-control mb-2" placeholder="Mail"/>
                                                        <label>Mail</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input name="adresse_membre_conseil_client" type="text" class="form-control mb-2" placeholder="Adresse"/>
                                                        <label>Adresse</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <textarea name="fonction_membre_conseil_client" class="form-control mb-2" placeholder="Fonction"></textarea>
                                                        <label>Fonction</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="la la-trash-o fs-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"]').html('');
                                    for (let i = 0; i < data.length; i++) {
                                        $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"]').append($template);
                                        parent = '#table_doc_8_fiche_id_client_membre_conseil_client_repeater div[data-repeater-list="membre_conseil_client"] div[data-repeater-item]:last-child';

                                        $(parent + ' ' + 'input[name="nom_membre_conseil_client"]').val(data[i].nom_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="prenom_membre_conseil_client"]').val(data[i].prenom_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="qualite_membre_conseil_client"]').val(data[i].qualite_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="tel_membre_conseil_client"]').val(data[i].tel_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="mail_membre_conseil_client"]').val(data[i].mail_membre_conseil_client);
                                        $(parent + ' ' + 'input[name="adresse_membre_conseil_client"]').val(data[i].adresse_membre_conseil_client);
                                        $(parent + ' ' + 'textarea[name="fonction_membre_conseil_client"]').val(data[i].fonction_membre_conseil_client);

                                    }

                                    $('#table_doc_8_fiche_id_client_membre_conseil_client_repeater').repeater({
                                        initEmpty: false,

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        },
                                    });

                                }
                            });
                        }

                    }

                    if (data.table_document == 'doc_3_accept_mission') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;

                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_3_accept_mission_modal .modal-title').html(titre_document);

                        // quiz1
                        if (data.quiz1 == 'oui') {
                            $('#table_doc_3_accept_mission_quiz1_oui').prop('checked', true);
                        } else if (data.quiz1 == 'non') {
                            $('#table_doc_3_accept_mission_quiz1_non').prop('checked', true);
                        }
                        // observ1
                        $('#table_doc_3_accept_mission_observ1').val(data.observ1);

                        // quiz2 à 9
                        for (let i = 2; i <= 9; i++) {
                            if (data['quiz' + i] == 'e') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_e').prop('checked', true);
                            } else if (data['quiz' + i] == 'm') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_m').prop('checked', true);
                            } else if (data['quiz' + i] == 'f') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_f').prop('checked', true);
                            }
                        }

                        // quiz10 à 20
                        for (let i = 10; i <= 20; i++) {
                            // quiz
                            if (data['quiz' + i] == 'oui') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_oui').prop('checked', true);
                            } else if (data['quiz' + i] == 'non') {
                                $('#table_doc_3_accept_mission_quiz' + i + '_non').prop('checked', true);
                            }

                            // observ
                            $('#table_doc_3_accept_mission_observ' + i).val(data['observ' + i]);
                        }

                        // accept_mission
                        if (data.accept_mission == 'oui') {
                            $('#table_doc_3_accept_mission_accept_mission_oui').prop('checked', true);
                        } else if (data.accept_mission == 'non') {
                            $('#table_doc_3_accept_mission_accept_mission_non').prop('checked', true);
                        }
                        // observation
                        $('#table_doc_3_accept_mission_observation').val(data.observation);


                    }

                    if (data.table_document == 'doc_19_quiz_lcb') {

                        // Show modal
                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;

                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal input[name="id_document"]').val(id_document);
                        $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal .modal-title').html(titre_document);

                        // quiz1 à 21
                        for (let i = 1; i <= 21; i++) {
                            // quiz
                            if (data['quiz' + i] == 'oui') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_oui').prop('checked', true);
                            } else if (data['quiz' + i] == 'non') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_non').prop('checked', true);
                            } else if (data['quiz' + i] == 'na') {
                                $('#table_doc_19_quiz_lcb_quiz' + i + '_na').prop('checked', true);
                            }
                            // impact
                            if (data['impact' + i] == 'e') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('e').trigger('change');
                            } else if (data['impact' + i] == 'm') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('m').trigger('change');
                            } else if (data['impact' + i] == 'f') {
                                $('#table_doc_19_quiz_lcb_impact' + i).val('f').trigger('change');
                            }
                            // observ
                            $('#table_doc_19_quiz_lcb_observ' + i).val(data['observ' + i]);
                        }

                        // conclusion
                        $('#table_doc_19_quiz_lcb_conclusion').val(data.conclusion);


                    }



                }
            })
        });

        // Lorsqu'on clique sur .edit_info_doc_file
        init_repeater_count_edit_info_doc_file = 0;
        $(document).on('click', '.edit_info_doc_file', function(e) {
            e.preventDefault();
            var id_document = $(this).data('id_document');

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    id_document: id_document,
                    action: 'fetch_edit_info_doc_file'
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.table_info_document == 'doc_6_info_lettre_mission') {

                        // Show modal
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal').modal('show');

                        id_document = data.id_document;
                        id_client = data.id_client;
                        titre_document = data.titre_document;
                        duree = data.duree;
                        renouvellement = data.renouvellement;
                        date_debut_duree = date_formatter(data.date_debut_duree, 'yyyy-mm-dd');
                        date_debut_renouvellement = date_formatter(data.date_debut_renouvellement, 'yyyy-mm-dd');
                        frais_ouverture = data.frais_ouverture;
                        montant_honoraires_ht = data.montant_honoraires_ht;
                        montant_honoraires_ttc = data.montant_honoraires_ttc;


                        // On rempli les champs du modal
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal input[name="id_document"]').val(id_document);
                        $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal .modal-title').html(titre_document);

                        $('#table_doc_6_info_lettre_mission_duree').val(duree);
                        $('#table_doc_6_info_lettre_mission_renouvellement').val(renouvellement);
                        $('#table_doc_6_info_lettre_mission_date_debut_duree').val(date_debut_duree);
                        $('#table_doc_6_info_lettre_mission_date_debut_renouvellement').val(date_debut_renouvellement);
                        $('#table_doc_6_info_lettre_mission_frais_ouverture').val(frais_ouverture);
                        $('#table_doc_6_info_lettre_mission_montant_honoraires_ht').val(montant_honoraires_ht);
                        $('#table_doc_6_info_lettre_mission_montant_honoraires_ttc').val(montant_honoraires_ttc);

                        init_repeater_count_edit_info_doc_file++;
                        if (init_repeater_count_edit_info_doc_file == 1) {
                            // Fetch data for mission_client (Repeater)
                            $.ajax({
                                url: "roll/ag/dossiers/fetch.php",
                                method: "POST",
                                data: {
                                    table: 'mission_client',
                                    condition: 'id_client = ' + id_client,
                                    action: 'fetch_table'
                                },
                                dataType: "JSON",
                                success: function(data) {

                                    $template = `
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-10">
                                                    <label class="fs-5 form-label">Nature de la mission</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0" placeholder="Précisez la nature de la mission en se référant au prospectus du cabinet" name="nature_mission" />
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                        <i class="la la-trash-o fs-3"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-10 ms-10 mt-5">
                                                    <div class="inner-repeater">
                                                        <div data-repeater-list="sous_mission" class="mb-5">
                                                            <div data-repeater-item>
                                                                <label class="fs-6 form-label">Nature de la sous mission</label>
                                                                <div class="input-group pb-3">
                                                                    <input type="text" class="form-control" placeholder="Précisez la nature de la sous mission" name="nature_sous_mission" />
                                                                    <button class="border border-secondary btn btn-icon btn-light-danger" data-repeater-delete type="button">
                                                                        <i class="la la-trash-o fs-3"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-sm btn-light-primary" data-repeater-create type="button">
                                                            <i class="la la-plus"></i> Ajouter une sous mission
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    $template_inner = `
                                    
                                        <div data-repeater-item>
                                            <label class="fs-6 form-label">Nature de la sous mission</label>
                                            <div class="input-group pb-3">
                                                <input type="text" class="form-control" placeholder="Précisez la nature de la sous mission" name="nature_sous_mission" />
                                                <button class="border border-secondary btn btn-icon btn-light-danger" data-repeater-delete type="button">
                                                    <i class="la la-trash-o fs-3"></i>
                                                </button>
                                            </div>
                                        </div>

                                    `;

                                    // vider le contenu de #table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission
                                    $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"]').html('');
                                    init_repeater_inner_count_edit_info_doc_file = 0;
                                    for (let i = 0; i < data.length; i++) {
                                        if (data[i].sous_mission == 'non') {

                                            $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"]').append($template);
                                            parent = '#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="mission"] div[data-repeater-item]:last-child';

                                            $(parent + ' ' + 'input[name="nature_mission"]').val(data[i].nature_mission);

                                            init_repeater_inner_count_edit_info_doc_file = 0;
                                        } else {

                                            if (init_repeater_inner_count_edit_info_doc_file == 0) {
                                                $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last').html('');
                                            }

                                            $('#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last').append($template_inner);
                                            parent = '#table_doc_6_info_lettre_mission_repeater div[data-repeater-list="sous_mission"]:last div[data-repeater-item]:last-child';

                                            $(parent + ' ' + 'input[name="nature_sous_mission"]').val(data[i].nature_mission);

                                            init_repeater_inner_count_edit_info_doc_file++;

                                        }
                                    }



                                    $('#table_doc_6_info_lettre_mission_repeater').repeater({
                                        initEmpty: false,

                                        repeaters: [{
                                            initEmpty: false,

                                            selector: '.inner-repeater',
                                            show: function() {
                                                $(this).slideDown();
                                            },

                                            hide: function(deleteElement) {
                                                $(this).slideUp(deleteElement);
                                            }
                                        }],

                                        show: function() {
                                            $(this).slideDown();
                                        },

                                        hide: function(deleteElement) {
                                            $(this).slideUp(deleteElement);
                                        }
                                    });


                                }
                            });
                        }

                    }

                }
            })
        });

        // Lorsqu'on soumet le formulaire #form_edit_info_doc_file_table_doc_6_info_lettre_mission
        $(document).on('submit', '#form_edit_info_doc_file_table_doc_6_info_lettre_mission', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_info_doc_file_table_doc_6_info_lettre_mission');
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

                            $('#edit_info_doc_file_table_doc_6_info_lettre_mission_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Informations modifié !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        // Lorsqu'on soumet le formulaire #form_edit_form_doc_generate_table_doc_8_fiche_id_client
        $(document).on('submit', '#form_edit_form_doc_generate_table_doc_8_fiche_id_client', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_form_doc_generate_table_doc_8_fiche_id_client');
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

                            $('#edit_form_doc_generate_table_doc_8_fiche_id_client_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Fiche enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        // Lorsqu'on soumet le formulaire #form_edit_form_doc_generate_table_doc_3_accept_mission
        $(document).on('submit', '#form_edit_form_doc_generate_table_doc_3_accept_mission', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_form_doc_generate_table_doc_3_accept_mission');
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

                            $('#edit_form_doc_generate_table_doc_3_accept_mission_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Questionnaire enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        // Lorsqu'on soumet le formulaire #form_edit_form_doc_generate_table_doc_19_quiz_lcb
        $(document).on('submit', '#form_edit_form_doc_generate_table_doc_19_quiz_lcb', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_form_doc_generate_table_doc_19_quiz_lcb');
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

                            $('#edit_form_doc_generate_table_doc_19_quiz_lcb_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Questionnaire enregistré !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_page(); // On recharge le datatable

                        } else {
                            toastr.error(data.message, '', {
                                positionClass: "toastr-bottom-left",
                            });
                        }

                    }, 2000);

                }
            })
        });

        /* -----------------Suppression des documents---------------- */
        // Lorsqu'on clique sur .delete_doc
        $(document).on('click', '.delete_doc', function(e) {
            +
            e.preventDefault();
            var id_document = $(this).data('id_document');

            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, supprimer !",
                cancelButtonText: "Non, annuler !",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn btn-light fw-bold btn-active-light-primary"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "roll/ag/dossiers/fetch.php",
                        method: "POST",
                        data: {
                            id_document: id_document,
                            action: 'delete_doc'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    title: "Supprimé !",
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, j'ai compris !",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });

                                reload_page(); // On recharge le datatable

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

        /* -----------------Information de relance client---------------- */
        // Lorsqu'on clique sur .info_relance
        $(document).on('click', '.info_relance', function(e) {
            e.preventDefault();

            $.ajax({
                url: "roll/ag/dossiers/fetch.php",
                method: "POST",
                data: {
                    action: 'fetch_info_relance'
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.relance_auto_client == 'oui') {
                        $('#id_edit_info_relance_auto').prop('checked', true);
                        $('#form_edit_info_relance .relance-info-option').removeClass('d-none');
                    } else {
                        $('#id_edit_info_relance_auto').prop('checked', false);
                        $('#form_edit_info_relance .relance-info-option').addClass('d-none');
                    }
                    $('#id_edit_info_relance_nom').val(data.nom_responsable_client);
                    $('#id_edit_info_relance_prenom').val(data.prenom_responsable_client);
                    $('#id_edit_info_relance_civilite').val(data.civilite_responsable_client).trigger('change');
                    $('#id_edit_info_relance_fonction').val(data.role_responsable_client);
                }
            })
        });

        // Lorsqu'on change le checkbox #id_edit_info_relance_auto
        $(document).on('change', '#id_edit_info_relance_auto', function() {
            if ($(this).is(':checked')) {
                $('#form_edit_info_relance .relance-info-option').removeClass('d-none');
            } else {
                $('#form_edit_info_relance .relance-info-option').addClass('d-none');
            }
        });

        // Lorsqu'on soumet le formulaire #form_edit_info_relance
        $(document).on('submit', '#form_edit_info_relance', function() {
            event.preventDefault();

            // Show loading indication
            formSubmitButton = document.querySelector('#btn_edit_info_relance');
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

                            $('#edit_info_relance_modal').modal('hide');

                            // swal
                            Swal.fire({
                                title: "Informations enregistrées !",
                                html: data.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, j'ai compris !",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });

                            reload_page(); // On recharge le datatable

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