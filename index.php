<?php
require($_SERVER['DOCUMENT_ROOT'] . '/ged/global.php');
?>
<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	<base href="/ged/" />
	<title>GED-ELYON - Connexion</title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="assets/media/logos/ged-icon.png" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	<!--begin::Theme mode setup on page load-->
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-theme-mode");
			} else {
				if (localStorage.getItem("data-theme") !== null) {
					themeMode = localStorage.getItem("data-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-theme", themeMode);
		}
	</script>
	<!--end::Theme mode setup on page load-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
			body {
				background-image: url('assets/media/auth/bg10.jpeg');
			}

			[data-theme="dark"] body {
				background-image: url('assets/media/auth/bg10-dark.jpeg');
			}
		</style>
		<!--end::Page bg image-->
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<!--begin::Aside-->
			<div class="d-flex flex-lg-row-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
					<!--begin::Image-->
					<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-ged.png" alt="" />
					<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-ged.png" alt="" />
					<!--end::Image-->
					<!--begin::Title-->
					<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Quality in Everything We Do !</h1>
					<!--end::Title-->
					<!--begin::Text-->
					<div class="text-gray-600 fs-base text-center fw-semibold">
						Audit, Commissariat aux comptes, Expertise Comptable & Conseils<br>
						Nous avons pour mission de donner confiance à notre clientèle et au public<br>
						et de résoudre ce qui est important pour vous.
					</div>
					<!--end::Text-->
				</div>
				<!--end::Content-->
			</div>
			<!--begin::Aside-->
			<!--begin::Body-->
			<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
				<!--begin::Wrapper-->
				<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
					<!--begin::Content-->
					<div class="w-md-400px">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="" action="#">
							<!--begin::Heading-->
							<div class="text-center mb-11">
								<!--begin::Title-->
								<h1 class="text-dark fw-bolder mb-3">Connexion</h1>
								<!--end::Title-->
							</div>
							<!--begin::Heading-->
							<!--begin::Login options-->
							<div class="row g-3 mb-9">
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Google link=-->
									<a href="#" data-onsuccess="onSignIn" class="g-signin2 btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
										<img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-15px me-3" />Connexion avec Google</a>
									<!--end::Google link=-->
								</div>
								<div id="g_id_onload" data-client_id="<?= GOOGLE_ID ?>" data-callback="handleCredentialResponse" data-auto_prompt="false">
								</div>
								<div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left">
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Google link=-->
									<a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
										<img alt="Logo" src="assets/media/svg/brand-logos/facebook-2.svg" class="theme-light-show h-15px me-2" />
										<img alt="Logo" src="assets/media/svg/brand-logos/facebook-3.svg" class="theme-dark-show h-15px me-2" />Connexion avec facebook</a>
									<!--end::Google link=-->
								</div>
								<!--end::Col-->
							</div>
							<!--end::Login options-->
							<!--begin::Separator-->
							<div class="separator separator-content my-14">
								<span class="w-125px text-gray-500 fw-semibold fs-7">Ou avec email</span>
							</div>
							<!--end::Separator-->
							<!--begin::Input group=-->
							<div class="fv-row mb-8">
								<!--begin::Email-->
								<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
								<!--end::Email-->
							</div>
							<!--end::Input group=-->
							<div class="fv-row mb-3">
								<!--begin::Password-->
								<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
								<!--end::Password-->
							</div>
							<!--end::Input group=-->
							<!--begin::Wrapper-->
							<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
								<div></div>
								<!--begin::Link-->
								<a href="" class="link-primary">Mot de passe oublié ?</a>
								<!--end::Link-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Submit button-->
							<div class="d-grid mb-10">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
									<!--begin::Indicator label-->
									<span class="indicator-label">Connexion</span>
									<!--end::Indicator label-->
									<!--begin::Indicator progress-->
									<span class="indicator-progress">Veuillez patienter...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
								</button>
							</div>
							<!--end::Submit button-->
							<!--begin::Sign up-->
							<!-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
								<a href="" class="link-primary">Sign up</a></div> -->
							<!--end::Sign up-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Root-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Custom Javascript(used by this page)-->
	<!-- <script src="assets/js/custom/authentication/sign-in/general.js"></script> -->
	<script>
		const jose = require('jose')

		function decodeJwtResponse(response) {
			const { id_token } = response
			const { payload } = jose.JWT.decode(id_token)
			return payload
		}
		
		function handleCredentialResponse(response) {
			// decodeJwtResponse() is a custom function defined by you
			// to decode the credential response.
			const responsePayload = decodeJwtResponse(response.credential);

			console.log("ID: " + responsePayload.sub);
			console.log('Full Name: ' + responsePayload.name);
			console.log('Given Name: ' + responsePayload.given_name);
			console.log('Family Name: ' + responsePayload.family_name);
			console.log("Image URL: " + responsePayload.picture);
			console.log("Email: " + responsePayload.email);

			console.log(response.credential);
		}

		$(document).ready(function() {

			"use strict";

			// Class definition
			var KTSigninGeneral = function() {
				// Elements
				var form;
				var submitButton;
				var validator;

				// Handle form
				var handleForm = function(e) {
					// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
					validator = FormValidation.formValidation(
						form, {
							fields: {
								'email': {
									validators: {
										regexp: {
											regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
											message: 'The value is not a valid email address',
										},
										notEmpty: {
											message: 'Email address is required'
										}
									}
								},
								'password': {
									validators: {
										notEmpty: {
											message: 'The password is required'
										}
									}
								}
							},
							plugins: {
								trigger: new FormValidation.plugins.Trigger(),
								bootstrap: new FormValidation.plugins.Bootstrap5({
									rowSelector: '.fv-row',
									eleInvalidClass: '', // comment to enable invalid state icons
									eleValidClass: '' // comment to enable valid state icons
								})
							}
						}
					);

					// Handle form submit
					submitButton.addEventListener('click', function(e) {
						// Prevent button default action
						e.preventDefault();

						// Validate form
						validator.validate().then(function(status) {
							if (status == 'Valid') {
								// Show loading indication
								submitButton.setAttribute('data-kt-indicator', 'on');

								// Disable button to avoid multiple click 
								submitButton.disabled = true;


								// Simulate ajax request
								setTimeout(function() {
									// Hide loading indication
									submitButton.removeAttribute('data-kt-indicator');

									// Enable button
									submitButton.disabled = false;

									// Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
									// Swal.fire({
									// 	text: "You have successfully logged in!",
									// 	icon: "success",
									// 	buttonsStyling: false,
									// 	confirmButtonText: "Ok, got it!",
									// 	customClass: {
									// 		confirmButton: "btn btn-primary"
									// 	}
									// }).then(function(result) {
									// 	if (result.isConfirmed) {
									// 		form.querySelector('[name="email"]').value = "";
									// 		form.querySelector('[name="password"]').value = "";

									// 		//form.submit(); // submit form
									// 		var redirectUrl = form.getAttribute('data-kt-redirect-url');
									// 		if (redirectUrl) {
									// 			location.href = redirectUrl;
									// 		}
									// 	}
									// });

								}, 2000);
							} else {
								// Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
								Swal.fire({
									text: "Sorry, looks like there are some errors detected, please try again.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
							}
						});

						// Submit form request
						var form_data = $(form).serialize();
						$.ajax({
							url: 'connexion.php',
							method: 'POST',
							data: form_data,
							dataType: 'json',
							success: function(data) {


								if (data == "parametres corrects - dg") {
									window.location = "roll/dg/";
								}

								if (data == "parametres corrects - dd") {
									window.location = "roll/dd/";
								}

								if (data == "parametres corrects - dm") {
									window.location = "roll/dm/";
								}

								if (data == "parametres corrects - cm") {
									window.location = "roll/cm/";
								}

								if (data == "parametres corrects - am") {
									window.location = "roll/am/";
								}

								if (data == "parametres corrects - stg") {
									window.location = "roll/stg/";
								}


								if (data == "Email invalide") {
									swal.fire('Erreur de connexion', 'Email incorrect', 'error');
								}

								if (data == "Mot de passe erroné") {
									swal.fire('Erreur de connexion', 'Mot de passe incorrect', 'error');
								}

								if (data == "Compte désactivé") {
									swal.fire('Erreur de connexion', 'Compte désactivé', 'error');
								}
							}
						});
					});
				}

				// Public functions
				return {
					// Initialization
					init: function() {
						form = document.querySelector('#kt_sign_in_form');
						submitButton = document.querySelector('#kt_sign_in_submit');

						handleForm();
					}
				};
			}();

			// On document ready
			KTUtil.onDOMContentLoaded(function() {
				KTSigninGeneral.init();
			});


		})
	</script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>