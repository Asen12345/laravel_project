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
									<h1 class="h4 text-gray-900 mb-4">{{ __('Reset Password') }}</h1>
								</div>

								@if (session('status'))
								<div class="alert alert-success" role="alert">
									{{ session('status') }}
								</div>
								@endif

								<form method="POST" action="{{ route('password.email') }}">
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

									<div class="form-group mb-0">
										<button type="submit" class="btn btn-primary btn-block">
											{{ __('Send Password Reset Link') }}
										</button>
									</div>
								</form>

								<!-- <hr>
								<div class="text-center">
									<a class="font-weight-bold small" href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
								</div> -->
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