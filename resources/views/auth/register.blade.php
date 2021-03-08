@extends('layouts.blank')

@section('content')
<!-- Register Content -->
<div class="container-login">
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-12 col-md-9">
			<div class="card shadow-sm my-5">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-lg-12">
							<div class="login-form">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">{{ __('Register form') }}</h1>
								</div>


								<form method="POST" action="{{ route('register') }}">
									@csrf

									<!-- @if (Cookie::get('remembered') == 'remembered') checked="checked" @endif -->
									<div class="form-group">
										<label for="name">{{ __('Partner code') }}</label>       

										@if (request()->get('partner'))
										@php ($code = request()->get('partner'))
										@php ($readonly = true)

										@elseif (cookie('partner'))
										@php ($code = cookie('partner'))
										@php ($readonly = true)
										@else
										@php ($code = old('referral_code'))
										@php ($readonly = false)
										@endif

										<input id="name" type="text" class="form-control @error('referral_code') is-invalid @enderror" name="referral_code" value="{{ $code }}" @if ($readonly) readonly @endif>

										@error('referral_code')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="first_name">{{ __('First Name') }}</label>

										<input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required2 autocomplete="name" autofocus>

										@error('first_name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="email">{{ __('E-mail') }}</label>

										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required2 autocomplete="email">

										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="password">{{ __('Password') }}</label>

										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required2 autocomplete="new-password">

										@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="password-confirm">{{ __('Confirm Password') }}</label>

										<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required2 autocomplete="new-password">

									</div>

									<div class="form-group">
									<input name="policy" type="checkbox">
									<label @error('policy') style="color:red;" @enderror>{{ __('I agree with the privacy policy') }}</label>
									</div>
									
									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-block">
											{{ __('Register') }}
										</button>
									</div>
								</form>


								<hr>
								<div class="text-center">
									<a class="font-weight-bold small" href="{{ route('login') }}">{{ __('Already have an account?') }}</a>
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
<!-- Register Content -->
@endsection