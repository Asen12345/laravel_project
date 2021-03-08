<!-- <div class="alert alert-success mt-4 success_withdraw" role="alert">
		{{ __('Operation was successfully completed. Wait for confirmation') }}
	</div> -->

<form class="user withdraw" method="POST">
	@csrf

	<div class="form-group">
		<div class="alert alert-danger invalid-feedback other_text_error mb-4" role="alert">
			<strong></strong>
		</div>
	</div>

	<div class="form-group">
		<select class="form-control" id="payment_system">
    <option value="1">{{ __('Withdrawal to the card') }}</option>
    <option selected value="0">{{ __('Withdrawal to Adv Cash') }}</option>
   </select>
	</div>
	
	<div class="form-group">
		<label for="text">{{ __('Wallet') }}</label>
		<input id="wallet" type="text" class="form-control wallet_input_error" name="wallet" value="{{ auth()->user()->purse }}">

		<span class="invalid-feedback wallet_text_error" role="alert">
			<strong></strong>
		</span>
	</div>



	<div class="form-group">
		<label for="text">{{ __('Amount') }}</label>
		<!--  -->

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">$</span>
			</div>
			<input id="withdraw_amount" type="text" class="form-control amount_input_error" name="amount" aria-label="{{ __('Amount') }}">
			<div class="input-group-append">
				<span class="input-group-text">.00</span>
			</div>
		</div>

		<div class="invalid-feedback alert2 alert-danger2 amount_text_error" role="alert">
			<strong></strong>
		</div>
	</div>


	<div class="form-group">
		<label for="text">{{ __('Fee') }}</label>
		<span class="fee_withdraw"></span>
	</div>

</form>

<div class="form-group withdraw_button">
	<button type="submit" class="btn btn-primary to-withdraw">
		{{ __('Withdraw') }}
	</button>
</div>

<form class="user withdraw_go" method="POST">
	@csrf

	<div class="form-group">

		<label for="text">{{ __('Code from sms') }}</label>
		<input id="code" type="text" class="form-control code_input_error" name="code">

		<span class="invalid-feedback code_text_error" role="alert">
			<strong></strong>
		</span>
	</div>

</form>

<div class="form-group">
	<button class="btn btn-light disabled new_code_link_disabled">
		{{ __('Get a new code') }} ({{ __('after') }} <span class="new_code_timer">60</span> {{ __('seconds') }})
	</button>

	<button class="btn btn-info new_code_link">
		{{ __('Get a new code') }}
	</button>
</div>


<div class="form-group withdraw_go_button">
	<button type="submit" class="btn btn-primary go-withdraw">
		{{ __('Withdraw') }}
	</button>
</div>

<script>
	$(document).ready(function() {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('.new_code_link_disabled').hide();
		$('.new_code_link').hide();
		$('.other_text_errors').hide();
		$('form.withdraw_go').hide();
		$('.withdraw_go_button').hide();
		$('.success_withdraw').hide();

		// Таймер
		const time = $('.new_code_timer');

		function timer() {
			setTimeout(function() {
				const newTime = time.text() - 1;
				time.text(newTime);
				if (newTime > 0) {
					$('.new_code_link').hide();
					$('.new_code_link_disabled').show();
					timer();
				} else {
					$('.new_code_link_disabled').hide();
					$('.new_code_link').show();
				}
			}, 1000);
		}

		// Функция показать ошибку
		function error_field(field, error = true, text) {
			if (error) {
				$('.' + field + '_text_error strong').html(text);
				$('.' + field + '_text_error').show();
				$('.' + field + '_input_error').addClass('is-invalid');
			} else {
				$('.' + field + '_text_error strong').html('');
				$('.' + field + '_text_error').hide();
				$('.' + field + '_input_error').removeClass('is-invalid');
			}
		}

		// Комиссия
		$("#payment_system").change(function(){
		var val = $("input.amount_input_error").val();
		if(Number($(this).val()) == 1){		
		var fee = val * "{{ $card_finance_fee }}" / 100;
		$('.fee_withdraw').html(fee + " $");
		}
		else{
		var fee = val * "{{ $finance_fee }}" / 100;
		$('.fee_withdraw').html(fee + " $");
		}
		});
		$('input.amount_input_error').on('keyup', function() {
			if(Number($("#payment_system").val()) == 1){	
			var val = $(this).val();
			var fee = val * "{{ $card_finance_fee }}" / 100;
			}
			else{
			var val = $(this).val();
			var fee = val * "{{ $finance_fee }}" / 100;
			}
			if (!isNaN(fee)) {
				$('.fee_withdraw').html(fee + " $");
			} else {
				$('.fee_withdraw').html(0);
			}
		});

		// Вывести
		$('.to-withdraw').on('click', function() {
			$.ajax({
				url: "{{ route('to_withdraw') }}",
				type: 'post',
				data: {
					'amount': $('#withdraw_amount').val(),
					'wallet': $('#wallet').val(),
					'payment_system': $('#payment_system').val(),					
					'_token': $('input[name="_token"]').val()
				},
				success: function(data) {

					error_field('other', false);
					error_field('amount', false);
					error_field('wallet', false);

					if (data.errors) {
						if (data.errors.amount) {
							error_field('amount', true, data.errors.amount[0]);
						}

						if (data.errors.wallet) {
							error_field('wallet', true, data.errors.wallet[0]);
						}

						if (data.errors.other) {
							error_field('other', true, data.errors.other[0]);
						}

					} else {
						$('form.withdraw').hide();
						$('form.withdraw_go').show();
						$('.withdraw_button').hide();
						$('.withdraw_go_button').show();
						timer();
					}

				}
			});
		});


		// Вывести (подтверждение)
		$('.go-withdraw').on('click', function() {
			$.ajax({
				url: "{{ route('withdraw_go') }}",
				type: 'post',
				data: {
					'code': $('#code').val()
				},
				success: function(data) {

					error_field('code', false);
					error_field('other', false);

					if (data.errors) {
						if (data.errors.code) {
							error_field('code', true, data.errors.code[0]);
						}

						if (data.errors.other) {
							error_field('other', true, data.errors.code[0]);
						}

					} else {
						location.reload();
					}

				}
			});
		});


		// Отправить новый код подтверждения
		$('.new_code_link').on('click', function() {
			$.ajax({
				url: "{{ route('get_code') }}",
				type: 'post',
				success: function(data) {
					console.log(data);

					error_field('code', false);

					if (data.errors) {
						if (data.errors.code) {
							error_field('code', true, data.errors.code[0]);
						}
					} else {
						$('.new_code_timer').text(60);
						timer();
					}

				}
			});
		});




	});
</script>