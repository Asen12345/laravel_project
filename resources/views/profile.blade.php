@extends('layouts.panel')

@section('content')

<!-- @if (session('status'))
<div class="alert alert-success" role="alert">
	{{ session('status') }}
</div>
@endif -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Profile') }}</h1>
</div>


@if (!auth()->user()->phone)
<div class="alert alert-danger alert-danger-phone" role="alert">
	{{ __('Confirm your phone number to get started') }}
</div>
@endif


<div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" id="toast" data-delay="2000" style="position: absolute; top: 85px; right: 20px; z-index: 1000;">
	<div class="toast-header">
		<svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
			<rect width="100%" height="100%" fill="#007aff"></rect>
		</svg>

		<strong class="mr-auto">{{ __('Copying') }}</strong>
		<!-- <small>только что</small> -->
		<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="toast-body">
		{{ __('Successfully!') }}
	</div>
</div>


<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Personal data') }}</h6>
			</div>

			<div class="card-body">

				<!-- Смена пароля. Добавление аватарки.
				телефон (с верификацией) -->


				@if (session('personal_data_success'))
				<div class="alert alert-success" role="alert">
					{{ session('personal_data_success') }}
				</div>
				@endif

				<form class="user" method="POST" action="{{ route('personal_data') }}">
					@csrf

					<div class="form-group">
						<label for="email">{{ __('E-mail') }}</label>

						<input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" disabled>

						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="first_name">{{ __('First Name') }}</label>

						<input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ auth()->user()->first_name }}">

						@error('first_name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="last_name">{{ __('Last Name') }}</label>

						<input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ auth()->user()->last_name }}">

						@error('last_name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>



					<div class="form-group">
						<label for="telegram">{{ __('Telegram') }}</label>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-telegram">@</span>
							</div>
							<input aria-describedby="basic-telegram" id="telegram" type="text" class="form-control @error('telegram') is-invalid @enderror" name="telegram" value="{{ auth()->user()->telegram }}">
						</div>

						@error('telegram')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="whatsapp">{{ __('WhatsApp') }}</label>


						<input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ auth()->user()->whatsapp }}">

						@error('whatsapp')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="viber">{{ __('Viber') }}</label>


						<input id="viber" type="text" class="form-control @error('viber') is-invalid @enderror" name="viber" value="{{ auth()->user()->viber }}">


						@error('viber')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="vk">{{ __('Vkontakte') }}</label>


						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-vk">https://vk.com/</span>
							</div>
							<input aria-describedby="basic-vk" id="vk" type="text" class="form-control @error('vk') is-invalid @enderror" name="vk" value="{{ auth()->user()->vk }}">
						</div>


						@error('vk')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="fb">{{ __('Facebook') }}</label>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-fb">https://www.facebook.com/</span>
							</div>
							<input aria-describedby="basic-fb" id="fb" type="text" class="form-control @error('fb') is-invalid @enderror" name="fb" value="{{ auth()->user()->fb }}">
						</div>

						@error('fb')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="instagram">{{ __('Instagram') }}</label>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-instagram">https://www.instagram.com/</span>
							</div>
							<input aria-describedby="basic-instagram" id="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{ auth()->user()->instagram }}">
						</div>

						@error('instagram')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>



					<div class="form-group">
						<button type="submit" class="btn btn-primary">
							{{ __('Save') }}
						</button>
					</div>
				</form>


			</div>
		</div>
	</div>


	<div class="col-md-6">

		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Telegram bot') }}</h6>
			</div>

			<div class="card-body">

				<div class="form-group">
					<label>{{ __('Link') }}</label>

					<div class="input-group is-invalid">
						<input id="bot_link" type="text" class="form-control" value="{{ auth()->user()->tg_bot() }}">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button" onclick="copytext('#bot_link')">{{ __('Copy') }}</button>
						</div>
					</div>

				</div>

			</div>
		</div>

		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Phone number') }}</h6>
			</div>

			<div class="card-body">

				<div class="alert alert-success phone_changed" role="alert">
					{{ __('Phone number has been successfully changed') }}
				</div>



				<div class="mb-3 current_phone_number">{{ __('Current phone number') }}: <b><span>+{{ auth()->user()->phone }}</span></b></div>


				<form method="POST">
					@csrf

					<div class="form-group new_phone">
						<label for="phone">{{ __('New phone') }}</label>

						<input id="phone" type="text" class="phone_mask form-control phone_input_error" name="phone">

						<span class="invalid-feedback phone_text_error" role="alert">
							<strong></strong>
						</span>

					</div>

					<div class="form-group sms_code">
						<label for="text">{{ __('Code from sms') }}</label>
						<input id="phone_code" type="text" class="form-control code_input_error" name="phone_code">

						<span class="invalid-feedback code_text_error" role="alert">
							<strong></strong>
						</span>
					</div>

				</form>

				<div class="form-group sms_code">
					<button class="btn btn-primary check_sms_code">{{ __('Save phone') }}</button>
				</div>

				<div class="form-group new_phone">
					<div class="timer"><span></span></div>
					<button class="btn btn-success send_sms_code">{{__('Send sms code') }}</button>
				</div>

			</div>
		</div>




		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Change password') }}</h6>
			</div>

			<div class="card-body">

				@if (session('change_password_success'))
				<div class="alert alert-success" role="alert">
					{{ session('change_password_success') }}
				</div>
				@endif

				<form class="user" method="POST" action="{{ route('change_password') }}">
					@csrf

					<div class="form-group">
						<label for="current_password">{{ __('Current Password') }}</label>

						<input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">

						@error('current_password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="new_password">{{ __('New Password') }}</label>

						<input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">

						@error('new_password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="new_password_confirmation">{{ __('Confirm Password') }}</label>

						<input id="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation">

						@error('new_password_confirmation')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>


					<div class="form-group">
						<button type="submit" class="btn btn-primary">
							{{ __('Change password') }}
						</button>
					</div>
				</form>


			</div>
		</div>


		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Change avatar') }}</h6>
			</div>

			<div class="card-body">

				@if (session('change_avatar_success'))
				<div class="alert alert-success" role="alert">
					{{ session('change_avatar_success') }}
				</div>
				@endif

				@if (auth()->user()->getMedia('avatars')->first())
				<div class="my-3">
					<img width="60" height="60" class="img-profile rounded-circle" src="{{ auth()->user()->getMedia('avatars')->first()->getUrl('thumb') }}">
				</div>
				@endif

				<form class="user" method="POST" action="{{ route('change_avatar') }}" enctype="multipart/form-data">
					@csrf

					<div class="form-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="avatar" name="avatar">
							<label class="custom-file-label" for="avatar">{{ __('Avatar') }}</label>
						</div>

						@error('avatar')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<!-- <div class="form-group">
						<label for="avatar">{{ __('Avatar') }}</label>

						<input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">

					</div> -->

					<div class="form-group">
						<button type="submit" class="btn btn-primary">
							{{ __('Change') }}
						</button>
					</div>
				</form>


			</div>
		</div>

	</div>




</div>

<style>
	.custom-file-label::after {
		content: "{{ __('Browse') }}"
	}
</style>

@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>

@if(auth()->user()->phone)
<script>
	$('.current_phone_number').show();
</script>
@else
<script>
	$('.current_phone_number').hide();
</script>
@endif


<script>
	function copytext(el) {
		console.log(1);
		var $tmp = $("<textarea>");
		$("body").append($tmp);
		$tmp.val($(el).val()).select();
		document.execCommand("copy");
		$tmp.remove();
		console.log(2);
		$('#toast').toast('show');
	}

	$('input#instagram').on('change', function() {
		var value = $(this).val();
		value = value.replace('https://', '');
		value = value.replace('http://', '');
		value = value.replace('www.', '');
		value = value.replace('instagram.com/', '');
		$(this).val(value);
	});

	$('input#fb').on('change', function() {
		var value = $(this).val();
		value = value.replace('https://', '');
		value = value.replace('http://', '');
		value = value.replace('www.', '');
		value = value.replace('facebook.com/', '');
		$(this).val(value);
	});

	$('input#vk').on('change', function() {
		var value = $(this).val();
		value = value.replace('https://', '');
		value = value.replace('http://', '');
		value = value.replace('www.', '');
		value = value.replace('vk.com/', '');
		$(this).val(value);
	});

	$(".phone_mask").mask("+9 (999) 999-9999");

	$('.phone_changed').hide();
	$('.sms_code').hide();

	$('.phone_text_error').hide();
	$('.phone_input_error').removeClass('is-invalid');

	$('.code_text_error').hide();
	$('.code_input_error').removeClass('is-invalid');

	$('.send_sms_code').on('click', function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "{{ route('send_sms_code_new_phone') }}",
			type: 'post',
			data: {
				'phone': $('#phone').val()
			},
			success: function(data) {
				console.log(data);
				$('.phone_text_error').hide();
				$('.sms_code').hide();
				$('.new_phone').show();
				$('.phone_input_error').removeClass('is-invalid');
				if (data.error) {
					$('.phone_text_error strong').html(data.error[0]);
					$('.phone_text_error').show();
					$('.phone_input_error').addClass('is-invalid');
				} else {
					$('.sms_code').show();
					$('.new_phone').hide();
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
	});



	$('.check_sms_code').on('click', function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "{{ route('check_sms_code_new_phone') }}",
			type: 'post',
			data: {
				'phone_code': $('#phone_code').val()
			},
			success: function(data) {
				console.log(data);
				$('.code_text_error').hide();
				$('.new_phone').hide();
				$('.sms_code').show();
				$('.code_input_error').removeClass('is-invalid');
				if (data.error) {
					$('.code_text_error strong').html(data.error[0]);
					$('.code_text_error').show();
					$('.code_input_error').addClass('is-invalid');
				} else {
					$('.new_phone').hide();
					$('.sms_code').hide();

					$('.phone_changed').show();
					$('.current_phone_number span').html(data.phone);
					$('.current_phone_number').show();

					$('.alert-danger-phone').hide();
				}
			},
			error: function(error) {
				console.log(error);
			}
		});

		function startCountdown(startFrom) {
			countdown = $('.timer span');
			countdown.text('00:' + startFrom);
			countdown.show();
			$('.send-code-link').hide();
			timer = setInterval(function() {
				startFrom = parseInt(startFrom - 1);
				if (startFrom < 10) {
					startFrom = '0' + startFrom;
				}
				countdown.text('00:' + startFrom);
				if (startFrom <= 0) {
					clearInterval(timer);
					$('.send-code-link').show();
					countdown.hide();
				}
			}, 1000);
		}
	});
</script>
@endsection