<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="light">

<head>
	<!-- BEGIN Import Firebase Auth Scripts -->
	<!-- BEGIN Import Analytics Scripts -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;family=Roboto+Mono&amp;display=swap" rel="stylesheet">
	<link href="/dashboard_assets/assets/build/styles/ltr-core.css" rel="stylesheet">
	<link href="/dashboard_assets/assets/build/styles/ltr-vendor.css" rel="stylesheet">
	<link href="/logo.png" rel="shortcut icon" type="image/x-icon">
	<title>Reset Password | SIMEKAR</title>
</head>

<body class="preload-active">
	<!-- BEGIN Preload -->
	<div class="preload">
		<div class="preload-dialog">
			<!-- BEGIN Spinner -->
			<div class="spinner-border text-primary preload-spinner"></div>
			<!-- END Spinner -->
		</div>
	</div>
	<!-- END Preload -->
	<!-- BEGIN Page Holder -->
	<div class="holder">
		<!-- BEGIN Page Wrapper -->
		<div class="wrapper ">
			<!-- BEGIN Page Content -->
			<div class="content">
				<div class="container-fluid g-4">
					<div class="row g-0 align-items-center justify-content-center h-100" style="flex-direction: column">
						<img src="/logo.png" alt="Logo JR" class="img-fluid" style="width: 150px">
						<h3 class="text-center">Sistem Informasi Manajemen Kendaraan</h3>

						<div class="col-sm-8 col-md-6 col-lg-4 col-xl-4">
							<!-- BEGIN Portlet -->
							<div class="portlet">
								<div class="portlet-body">
									<div class="mt-3 mb-3">
                                        <h5>Reset Password</h5>
									</div>
									<!-- BEGIN Form -->
									<form class="d-grid gap-3" id="login-form" method="POST" action="/reset-password">
										@csrf 
                                        <input type="hidden" name="token" value="{{ $token }}">
										<!-- BEGIN Validation Container -->
										<div class="validation-container">
											<!-- BEGIN Form Floating -->
											<div class="form-floating">
												<input class="form-control form-control-lg" type="text" id="email" name="email" placeholder="Email" value="{{ $email }}" readonly>
												<label for="email">Email</label>
												@error('email')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
											<!-- END Form Floating -->
										</div>
										<!-- END Validation Container -->
                                        {{-- password dan konfirmasi passsword --}}
                                        <div class="validation-container">
                                            <!-- BEGIN Form Floating -->
                                            <div class="form-floating">
                                                <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                                                <label for="password">Password</label>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- END Form Floating -->
                                        </div>
                                        <!-- END Validation Container -->
                                        <div class="validation-container">
                                            <!-- BEGIN Form Floating -->
                                            <div class="form-floating">
                                                <input class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" value="{{ old('password_confirmation') }}">
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- END Form Floating -->
                                        </div>
										<!-- BEGIN Flex -->
										{{-- show error email atau password salah --}}
										@if (session('error'))
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												{{ session('error') }}
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										@endif
										<div class="d-flex align-items-center justify-content-between">
											<button type="submit" class="btn btn-label-primary btn-lg btn-widest w-100" id="login-button">Reset Password</button>
										</div>
										<!-- END Flex -->
									</form>
									<!-- END Form -->
								</div>
							</div>
							<!-- END Portlet -->
						</div>
					</div>
				</div>
			</div>
			<!-- END Page Content -->
		</div>
		<!-- END Page Wrapper -->
	</div>
	<!-- END Page Holder -->
	<script type="text/javascript" src="/dashboard_assets/assets/build/scripts/mandatory.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/build/scripts/core.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/build/scripts/vendor.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/sticky-header.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/copyright-year.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/theme-switcher.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/tooltip-popover.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/dropdown-scrollbar.js"></script>
	<script type="text/javascript" src="/dashboard_assets/assets/app/utilities/fullscreen-trigger.js"></script>
</body>
</html>