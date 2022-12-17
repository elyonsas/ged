<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

connected('ag');

$titre_page = 'GED-ELYON - Tableau de bord';
$titre_menu = 'Tableau de bord';
$chemin_menu = <<<HTML

HTML;

$menu_tb = "active";

$menu_dt = "";
$menu_interlo = "";
$menu_collabo = "";
$menu_compta = "";
$menu_compta_facture = "";
$menu_compta_finance = "";

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
			<div class="container-xxl" id="kt_content_container">
				<!--begin::Row-->
				<div id="tb-stat" class="row m-auto my-5">

					<div class="col-md-4 col-lg-3 mb-5 mb-lg-0">
						<!--begin::Card widget 17-->
						<div class="card card-flush min-h-225px">
							<!--begin::Header-->
							<div class="card-header pt-5">
								<!--begin::Title-->
								<div class="card-title d-flex flex-column">
									<!--begin::Info-->
									<div class="d-flex align-items-center">
										<!--begin::Nbr client-->
										<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2" 
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_client($db) ?>">0</span>
										<span class="text-dark pt-1 fw-bold fs-15">Clients</span>
										<!--end::Nbr client-->
									</div>
									<!--end::Info-->
								</div>
								<!--end::Title-->
							</div>
							<!--end::Header-->
							<!--begin::Card body-->
							<div class="card-body pt-3 d-flex flex-wrap align-items-center">
								<!--begin::Chart-->
								<div class="d-flex flex-center me-5 pt-2">
									<div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
								</div>
								<!--end::Chart-->
								<!--begin::Labels-->
								<div class="d-flex flex-column content-justify-center flex-row-fluid">
									<!--begin::Label-->
									<div class="d-flex fw-semibold align-items-center">
										<!--begin::Bullet-->
										<div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
										<!--end::Bullet-->
										<!--begin::Label-->
										<div class="text-gray-500 flex-grow-1 me-2">DEC</div>
										<!--end::Label-->
										<!--begin::Stats-->
										<div class="fw-bolder text-gray-700 text-xxl-end"><?= stat_client($db, 1) ?></div>
										<!--end::Stats-->
									</div>
									<!--end::Label-->
									<!--begin::Label-->
									<div class="d-flex fw-semibold align-items-center my-3">
										<!--begin::Bullet-->
										<div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
										<!--end::Bullet-->
										<!--begin::Label-->
										<div class="text-gray-500 flex-grow-1 me-2">DAC</div>
										<!--end::Label-->
										<!--begin::Stats-->
										<div class="fw-bolder text-gray-700 text-xxl-end"><?= stat_client($db, 2) ?></div>
										<!--end::Stats-->
									</div>
									<!--end::Label-->
									<!--begin::Label-->
									<div class="d-flex fw-semibold align-items-center">
										<!--begin::Bullet-->
										<div class="bullet w-8px h-3px rounded-2 me-3" style="background-color: #E4E6EF"></div>
										<!--end::Bullet-->
										<!--begin::Label-->
										<div class="text-gray-500 flex-grow-1 me-2">DC</div>
										<!--end::Label-->
										<!--begin::Stats-->
										<div class="fw-bolder text-gray-700 text-xxl-end"><?= stat_client($db, 3) ?></div>
										<!--end::Stats-->
									</div>
									<!--end::Label-->
								</div>
								<!--end::Labels-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card widget 17-->
					</div>

					<div class="col-md-4 col-lg-3 mb-5 mb-lg-0">
						<!--begin::List widget 25-->
						<div class="card card-flush min-h-225px">
							<!--begin::Header-->
							<div class="card-header pt-5">
								<!--begin::Title-->
								<div class="card-title d-flex flex-column">
									<!--begin::Subtitle-->
									<span class="text-dark pt-1 fw-bold fs-15">Total CA cabinet</span>
									<!--end::Subtitle-->
								</div>
								<!--end::Title-->
								<!--begin::Toolbar-->
								<div class="card-toolbar d-none">
									<!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
									<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
										<!--begin::Display range-->
										<div class="text-gray-600 fw-bold">Loading date range...</div>
										<!--end::Display range-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
										<span class="svg-icon svg-icon-1 ms-2 me-0">
											<svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
												<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
												<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Daterangepicker-->
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body pt-5 pb-3">
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Section-->
									<div class="text-gray-700 fw-semibold fs-6 me-2">Contrat</div>
									<!--end::Section-->
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_contrat($db) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Section-->
									<div class="text-gray-700 fw-semibold fs-6 me-2">Facturé</div>
									<!--end::Section-->
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_facture($db) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Section-->
									<div class="text-gray-700 fw-semibold fs-6 me-2">Encaissé</div>
									<!--end::Section-->
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_encaisse($db) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Section-->
									<div class="text-gray-700 fw-semibold fs-6 me-2">Créances</div>
									<!--end::Section-->
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_creance($db) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::LIst widget 25-->
					</div>

					<div class="col-md-3 col-lg-2 mb-5 mb-lg-0">
						<!--begin::List widget 25-->
						<div class="card card-flush min-h-225px">
							<!--begin::Header-->
							<div class="card-header pt-5">
								<!--begin::Title-->
								<div class="card-title d-flex flex-column">
									<!--begin::Subtitle-->
									<span class="text-dark pt-1 fw-bold fs-15">CA DEC</span>
									<!--end::Subtitle-->
								</div>
								<!--end::Title-->
								<!--begin::Toolbar-->
								<div class="card-toolbar d-none">
									<!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
									<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
										<!--begin::Display range-->
										<div class="text-gray-600 fw-bold">Loading date range...</div>
										<!--end::Display range-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
										<span class="svg-icon svg-icon-1 ms-2 me-0">
											<svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
												<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
												<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Daterangepicker-->
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body pt-5 pb-3">
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_contrat($db, 1) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_facture($db, 1) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_encaisse($db, 1) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_creance($db, 1) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::LIst widget 25-->
					</div>

					<div class="col-md-3 col-lg-2 mb-5 mb-lg-0">
						<!--begin::List widget 25-->
						<div class="card card-flush min-h-225px">
							<!--begin::Header-->
							<div class="card-header pt-5">
								<!--begin::Title-->
								<div class="card-title d-flex flex-column">
									<!--begin::Subtitle-->
									<span class="text-dark pt-1 fw-bold fs-15">CA DAC</span>
									<!--end::Subtitle-->
								</div>
								<!--end::Title-->
								<!--begin::Toolbar-->
								<div class="card-toolbar d-none">
									<!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
									<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
										<!--begin::Display range-->
										<div class="text-gray-600 fw-bold">Loading date range...</div>
										<!--end::Display range-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
										<span class="svg-icon svg-icon-1 ms-2 me-0">
											<svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
												<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
												<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Daterangepicker-->
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body pt-5 pb-3">
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_contrat($db, 2) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_facture($db, 2) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_encaisse($db, 2) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_creance($db, 2) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::LIst widget 25-->
					</div>

					<div class="col-md-3 col-lg-2 mb-5 mb-lg-0">
						<!--begin::List widget 25-->
						<div class="card card-flush min-h-225px">
							<!--begin::Header-->
							<div class="card-header pt-5">
								<!--begin::Title-->
								<div class="card-title d-flex flex-column">
									<!--begin::Subtitle-->
									<span class="text-dark pt-1 fw-bold fs-15">CA DC</span>
									<!--end::Subtitle-->
								</div>
								<!--end::Title-->
								<!--begin::Toolbar-->
								<div class="card-toolbar d-none">
									<!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
									<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
										<!--begin::Display range-->
										<div class="text-gray-600 fw-bold">Loading date range...</div>
										<!--end::Display range-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
										<span class="svg-icon svg-icon-1 ms-2 me-0">
											<svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
												<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
												<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Daterangepicker-->
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body pt-5 pb-3">
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_contrat($db, 3) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_facture($db, 3) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_encaisse($db, 3) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
								<!--begin::Separator-->
								<div class="separator separator-dashed my-2"></div>
								<!--end::Separator-->
								<!--begin::Item-->
								<div class="d-flex flex-stack flex-wrap">
									<!--begin::Statistics-->
									<div class="d-flex align-items-senter">
										<!--begin::Number-->
										<span class="text-gray-900 fw-bolder fs-6"
										data-kt-countup="true" data-kt-countup-separator="." data-kt-countup-value="<?= stat_ca_creance($db, 3) ?>">0</span>
										<!--end::Number-->
									</div>
									<!--end::Statistics-->
								</div>
								<!--end::Item-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::LIst widget 25-->
					</div>


				</div>
				<!--end::Row-->

				<!--begin::Row-->
				<div class="row g-5 g-lg-8">
					<!--begin::Col-->
					<div class="col-lg-4">
						<!--begin::Mixed Widget 5-->
						<div class="card card-xl-stretch mb-5 mb-xl-8">
							<!--begin::Beader-->
							<div class="card-header border-0 py-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bold fs-3 mb-1">Saisies clients</span>
									<span class="text-muted fw-semibold fs-7">Tendance mensuelle (Saisies à jour)</span>
								</h3>
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body d-flex flex-column">
								<!--begin::Chart-->
								<div class="mixed-widget-5-chart card-rounded-top" data-kt-chart-color="warning" style="height: 150px"></div>
								<!--end::Chart-->
								<!--begin::Items-->
								<div class="mt-5">
									<!--begin::Item-->
									<div class="d-flex flex-stack flex-wrap">
										<!--begin::Section-->
										<div class="text-gray-700 fw-semibold fs-6 me-2">Octobre</div>
										<!--end::Section-->
										<!--begin::Statistics-->
										<div class="d-flex align-items-senter">
											<!--begin::Number-->
											<span class="text-gray-900 fw-bolder fs-6">5 clients à jour</span>
											<!--end::Number-->
										</div>
										<!--end::Statistics-->
									</div>
									<!--end::Item-->
									<!--begin::Separator-->
									<div class="separator separator-dashed my-3"></div>
									<!--end::Separator-->
									<!--begin::Item-->
									<div class="d-flex flex-stack flex-wrap">
										<!--begin::Section-->
										<div class="text-gray-700 fw-semibold fs-6 me-2">Septembre</div>
										<!--end::Section-->
										<!--begin::Statistics-->
										<div class="d-flex align-items-senter">
											<!--begin::Number-->
											<span class="text-gray-900 fw-bolder fs-6">15 clients à jour</span>
											<!--end::Number-->
										</div>
										<!--end::Statistics-->
									</div>
									<!--end::Item-->
									<!--begin::Separator-->
									<div class="separator separator-dashed my-3"></div>
									<!--end::Separator-->
									<!--begin::Item-->
									<div class="d-flex flex-stack flex-wrap">
										<!--begin::Section-->
										<div class="text-gray-700 fw-semibold fs-6 me-2">Août</div>
										<!--end::Section-->
										<!--begin::Statistics-->
										<div class="d-flex align-items-senter">
											<!--begin::Number-->
											<span class="text-gray-900 fw-bolder fs-6">10 clients à jour</span>
											<!--end::Number-->
										</div>
										<!--end::Statistics-->
									</div>
									<!--end::Item-->
									<!--begin::Separator-->
									<div class="separator separator-dashed my-3"></div>
									<!--end::Separator-->
									<!--begin::Item-->
									<div class="d-flex flex-stack flex-wrap">
										<!--begin::Section-->
										<div class="text-gray-700 fw-semibold fs-6 me-2">Juillet</div>
										<!--end::Section-->
										<!--begin::Statistics-->
										<div class="d-flex align-items-senter">
											<!--begin::Number-->
											<span class="text-gray-900 fw-bolder fs-6">14 clients à jour</span>
											<!--end::Number-->
										</div>
										<!--end::Statistics-->
									</div>
									<!--end::Item-->
									<!--begin::Separator-->
									<div class="separator separator-dashed my-3"></div>
									<!--end::Separator-->
									<!--begin::Item-->
									<div class="d-flex flex-stack flex-wrap">
										<!--begin::Section-->
										<div class="text-gray-700 fw-semibold fs-6 me-2">Juin</div>
										<!--end::Section-->
										<!--begin::Statistics-->
										<div class="d-flex align-items-senter">
											<!--begin::Number-->
											<span class="text-gray-900 fw-bolder fs-6">4 clients à jour</span>
											<!--end::Number-->
										</div>
										<!--end::Statistics-->
									</div>
									<!--end::Item-->
								</div>
								<!--end::Items-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Mixed Widget 5-->
					</div>
					<!--end::Col-->
					<!--begin::Col-->
					<div class="col-lg-8">
						<!--begin::Tables Widget 9-->
						<div class="card card-lg-stretch mb-5 mb-lg-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bold fs-3 mb-1">Secteurs d'activés des clients</span>
									<span class="text-muted mt-1 fw-semibold fs-7">plus de 25 secteurs d'activités</span>
								</h3>
								<div class="card-toolbar">
									<div id="add_secteur_activite_client" data-bs-toggle="modal" data-bs-target="#add_secteur_activite_client_modal" class="btn btn-sm btn-light btn-active-primary">
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
										<span class="svg-icon svg-icon-3">
											<svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
												<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
											</svg>
										</span>Ajouter un secteur d'activité
										<!--end::Svg Icon-->
									</div>
								</div>
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body py-3">
								<!--begin::Table container-->
								<div class="table-responsive">
									<!--begin::Table-->
									<table id="secteur_activite_client" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
										<!--begin::Table head-->
										<thead>
											<tr class="fw-bold text-muted">
												<th class="min-w-200px">Secteurs d'activités</th>
												<th class="min-w-150px">Clients</th>
											</tr>
										</thead>
										<!--end::Table head-->
										<tbody>
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>
								<!--end::Table container-->
							</div>
							<!--begin::Body-->
						</div>
						<!--end::Tables Widget 9-->
					</div>
					<!--end::Col-->
				</div>
				<!--end::Row-->
			</div>
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->

	<!-- begin::Modal Ajouter un secteur d'activité-->
    <div class="modal fade" id="add_secteur_activite_client_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="form_add_secteur_activite_client" method="POST" class="form modal-content" action="">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Ajouter un secteur d'activité</h4>
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
							<label class="fs-5 mb-2">Secteur d'activité</label>
							<input id="id_nom_secteur_activite" type="text" class="form-control form-control-solid" placeholder="Désignation" name="nom_secteur_activite">
						</div>
					</div>

					<div class="row mb-5">
						<div class="form-group">
							<label class="fs-5 mb-2">Description</label>
							<textarea id="id_description_secteur_activite" class="form-control form-control-solid" rows="3"
							placeholder="Entrez une description du secteur d'activité" name="description_secteur_activite"></textarea>
						</div>
					</div>

                </div>
				<!--end::Modal body-->

				<!--begin::Modal footer-->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_secteur_activite_client">
                    <button type="button" class="btn btn-light font-weight-bold" data-bs-dismiss="modal">Annuler</button>
                    <button id="btn_add_secteur_activite_client" type="submit" class="btn btn-lg btn-primary ms-2">
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
    <!-- end::Modal Ajouter un secteur d'activité-->
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
				url: "roll/ag/fetch.php",
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
			url: "roll/ag/fetch.php",
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

		// Pour l'ajout d'un nouveau secteur d'activité
		$(document).on('submit', '#form_add_secteur_activite_client', function(event) {
			event.preventDefault();

			// Show loading indication
			formSubmitButton = document.querySelector('#btn_add_secteur_activite_client');
			formSubmitButton.setAttribute('data-kt-indicator', 'on');

			$.ajax({
				url: "roll/ag/fetch.php",
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