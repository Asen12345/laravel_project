@extends('layouts.blank')

@section('content')

<!-- Login Content -->
<div class="container-login">
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-12 col-md-9">
			<div class="card shadow-sm my-5">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-lg-12">
							<div class="login-form">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">{{ __('Login form') }}</h1>
								</div>



								<form class="user" method="POST" action="{{ route('login') }}">
									@csrf

									<div class="form-group">
										<label for="email">{{ __('E-Mail Address') }}</label>

										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="password">{{ __('Password') }}</label>

										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

										@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

											<label class="form-check-label" for="remember">
												{{ __('Remember Me') }}
											</label>
										</div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-block">
											{{ __('Login') }}
										</button>

										@if (Route::has('password.request'))
										<a class="btn btn-light  btn-block" href="{{ route('password.request') }}">
											{{ __('Forgot Your Password?') }}
										</a>
										@endif
									</div>
								</form>

								<hr>
								<div class="text-center">
									<a class="font-weight-bold small" href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
								</div>
								<div class="text-center">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Login Content -->
@endsection