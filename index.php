<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/fonctions-sql.php');

if (isset($_SESSION['id_compte'])) {
	if ($_SESSION['type_compte'] == "ag") {
		header("Location:/ged/roll/ag");
	}

	if ($_SESSION['type_compte'] == "dd") {
		header("Location:/ged/roll/dd");
	}

	if ($_SESSION['type_compte'] == "dm") {
		header("Location:/ged/roll/dm");
	}

	if ($_SESSION['type_compte'] == "cm") {
		header("Location:/ged/roll/cm");
	}

	if ($_SESSION['type_compte'] == "am") {
		header("Location:/ged/roll/am");
	}

	if ($_SESSION['type_compte'] == "stg") {
		header("Location:/ged/roll/stg");
	}

	if ($_SESSION['type_compte'] == "admin") {
		header("Location:/ged/roll/ag");
	}
}
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
<html lang="fr">
<!--begin::Head-->

<head>
	<!-- <base href="/ged/" /> -->
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
	<link rel="shortcut icon" href="https://elyonsas.github.io/ged-assets/assets/media/logos/ged-logo-mini.png" />
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
							<div class="d-flex justify-content-center">
								<div id="buttonDiv"></div>
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
		function handleCredentialResponse(response) {

			submitButton = document.querySelector('#kt_sign_in_submit');
			// Show loading indication
			submitButton.setAttribute('data-kt-indicator', 'on');
			// Disable button to avoid multiple click 
			submitButton.disabled = true;

			// Faire une requete ajax pour envoyer le token au serveur
			$.ajax({
				url: 'connexion.php',
				type: 'POST',
				data: {
					'credential': response.credential,
				},
				dataType: 'JSON',
				success: function(data) {
					if (data == "compte inexistant") {
						// Hide loading indication
						submitButton.removeAttribute('data-kt-indicator');
						// Enable button
						submitButton.disabled = false;

						Swal.fire({
							title: "Compte inexistant",
							text: "Ce compte n'existe pas dans notre base de données. Pour plus d'infos veuillez contacter l'administrateur",
							icon: "error",
						});
					} else if(data == "compte inactif"){
						// Hide loading indication
						submitButton.removeAttribute('data-kt-indicator');
						// Enable button
						submitButton.disabled = false;

						Swal.fire({
							title: "Compte inactif",
							text: "Votre compte est inactif. Veuillez contacter l\'administrateur.",
							icon: "error",
						});
					}else {
						<?php if (isset($_GET['redirect_uri'])) { ?>
							var redirect = "<?= $_GET['redirect_uri'] ?>";
						<?php } else { ?>
							var redirect = false;
						<?php } ?>

						if (data == "parametres corrects - ag") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/ag/";
							}
						}

						if (data == "parametres corrects - dd") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/dd/";
							}
						}

						if (data == "parametres corrects - dm") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/dm/";
							}
						}

						if (data == "parametres corrects - cm") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/cm/";
							}
						}

						if (data == "parametres corrects - am") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/am/";
							}
						}

						if (data == "parametres corrects - stg") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/stg/";
							}
						}

						if (data == "parametres corrects - admin") {
							if (redirect) {
								window.location = redirect;
							} else {
								window.location = "roll/ag/";
							}
						}	
					}
				},
			});
		}

		window.onload = function() {
			google.accounts.id.initialize({
				client_id: "<?= GOOGLE_ID ?>",
				callback: handleCredentialResponse
			});
			// avec une size très grande

			google.accounts.id.renderButton(
				document.getElementById("buttonDiv"), {
					theme: "outline",
					size: "large",
				} // customization attributes
			);

			google.accounts.id.prompt(); // also display the One Tap dialog
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

								// Submit form request
								var form_data = $(form).serialize();
								$.ajax({
									url: 'connexion.php',
									method: 'POST',
									data: form_data,
									dataType: 'json',
									success: function(data) {

										<?php if (isset($_GET['redirect_uri'])) { ?>
											var redirect = "<?= $_GET['redirect_uri'] ?>";
										<?php } else { ?>
											var redirect = false;
										<?php } ?>


										if (data == "parametres corrects - ag") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/ag/";
											}
										}

										if (data == "parametres corrects - dd") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/dd/";
											}
										}

										if (data == "parametres corrects - dm") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/dm/";
											}
										}

										if (data == "parametres corrects - cm") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/cm/";
											}
										}

										if (data == "parametres corrects - am") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/am/";
											}
										}

										if (data == "parametres corrects - stg") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/stg/";
											}
										}

										if (data == "parametres corrects - admin") {
											if (redirect) {
												window.location = redirect;
											} else {
												window.location = "roll/ag/";
											}
										}


										if (data == "Email invalide") {
											swal.fire('Erreur de connexion', 'Email ou mot de passe incorrect', 'error');
										}

										if (data == "Mot de passe erroné") {
											swal.fire('Erreur de connexion', 'Email ou mot de passe incorrect', 'error');
										}

										if (data == "compte inactif") {
											swal.fire('Compte inactif', 'Votre compte est inactif. Veuillez contacter l\'administrateur.', 'error');
										}
									}
								});


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