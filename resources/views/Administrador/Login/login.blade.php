<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
	<meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

	<!-- Title -->
	<title> MOVILIDAD-EP </title>

	<!-- Favicon -->
	<link rel="icon" href="valex/assets/img/brand/favicon.png" type="image/x-icon" />

	<!-- Icons css -->
	<link href="valex/assets/css/icons.css" rel="stylesheet">

	<!-- Bootstrap css -->
	<link href="valex/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- style css -->
	<link href="valex/assets/css/style.css" rel="stylesheet">

	<!--- Animations css-->
	<link href="valex/assets/css/animate.css" rel="stylesheet">

	<!-- Login css -->
	<link href="valex/assets/css/login.css" rel="stylesheet">

	<style>

	</style>
</head>

<body class="ltr error-page1 main-body bg-light text-dark error-3 imagen-body">


	<!-- Loader -->
	<div id="global-loader">
		<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- /Loader -->


	<!-- Page -->
	<div class="page">
		<div class="main-container container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<!-- <img src="../vale/assets/img/media/login.png"
							<img src="https://lh5.googleusercontent.com/p/AF1QipNOTI3IzIFMyk0unqNk2YaHuKLmsfQ1NKHtKvJd=w650-h486-k-no"
								class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">-->
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white py-4">
					<div class="login d-flex align-items-center py-2 login-img">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 d-flex">
											<a href="index.html"><img src="/valex/assets/img/logo-movilidad.png" class="sign-favicon-a ht-40" alt="logo">
												<img src="/valex/assets/img/logo-movilidad.png" class="sign-favicon-b ht-40" alt="logo">
											</a>
										</div>
										<div class="card-sigin">
											<div class="main-signup-header">
												<h2 align="center" class="fon-size-titu">Sistema de Gestión Interno</h2>
												<!--<h5 class="fw-semibold mb-4">Please sign in to continue.</h5>-->
												<form class="style_width" id="login-form" method="POST" enctype="multipart/form-data">
													<input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="token">
													<div class="form-group">
														<label>Usuario</label>
														<div class="input-group has-validation">
															<span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-user"></i></span>
															<input id="txt-usuario" name="txt-usuario" class="form-control" placeholder="Ingresar usuario" type="text">
															<div class="invalid-feedback">
																Please choose a username.
															</div>
														</div>
													</div>
													<div class="form-group">
														<label>Contraseña</label>
														<div class="input-group has-validation">
															<span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-unlock-alt"></i></span>
															<input id="txt-clave" name="txt-clave" class="form-control" placeholder="Ingresar contraseña" type="password">
															<div class="invalid-feedback">
																Please choose a username.
															</div>
														</div>
													</div>
													<button type="button" class="btn btn-main-primary btn-block" id="btn-iniciar-sesion">Iniciar Sesión</button>
													<!--<div class="row row-xs">
														<div class="col-sm-6">
															<button class="btn btn-block"><i
																	class="fab fa-facebook-f"></i> Signup with
																Facebook</button>
														</div>
														<div class="col-sm-6 mg-t-10 mg-sm-t-0">
															<button class="btn btn-info btn-block btn-b"><i
																	class="fab fa-twitter"></i> Signup with
																Twitter</button>
														</div>
													</div>-->
												</form>
												<div class="main-sig nin-footer mt-5">
													<p><a href="">¿Se te olvidó tu contraseña?</a></p>
													<p>¿No tienes una cuenta? <a href="page-signup.html">Crea una cuenta</a></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>

	</div>
	<!-- End Page -->

	<!-- JQuery min js -->
	<script src="valex/assets/plugins/jquery/jquery.min.js"></script>

	<!-- Bootstrap Bundle js -->
	<script src="valex/assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="valex/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Moment js -->
	<script src="valex/assets/plugins/moment/moment.js"></script>

	<!-- P-scroll js -->
	<script src="valex/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

	<!-- eva-icons js -->
	<script src="valex/assets/js/eva-icons.min.js"></script>

	<!-- Rating js-->
	<script src="valex/assets/plugins/ratings-2/jquery.star-rating.js"></script>
	<script src="valex/assets/plugins/ratings-2/star-rating.js"></script>

	<!--Internal  Notify js -->
	<script src="valex/assets/plugins/notify/js/notifIt.js"></script>
	<script src="valex/assets/plugins/notify/js/notifit-custom.js"></script>

	<!--themecolor js-->
	<script src="valex/assets/js/themecolor.js"></script>

	<!-- custom js -->
	<script src="valex/assets/js/custom.js"></script>

	<script type='text/javascript' src='/js/Login/login.js'></script>

</body>

</html>