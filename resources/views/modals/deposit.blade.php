<!-- <div class="alert alert-success mt-4 success_withdraw" role="alert">
		{{ __('Operation was successfully completed. Wait for confirmation') }}
	</div> -->

<form class="user withdraw" method="POST">
	@csrf

	<div class="invalid-feedback alert alert-danger other_text_error" role="alert">
		<strong></strong>
	</div>

	<div class="form-group">
		<label>{{ __('Payment system') }}</label>
		<select class="form-control" name="system" id="system">
			<option value="adv">{{ __('AVD Cash') }}</option>
		</select>

		<div class="invalid-feedback alert2 alert-danger2 system_text_error" role="alert">
			<strong></strong>
		</div>
	</div>

	<div class="form-group">
		<label for="text">{{ __('Amount') }}</label>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">$</span>
			</div>
			<input id="deposit_amount" type="text" class="form-control amount_input_error" name="amount" aria-label="{{ __('Amount') }}">
			<div class="input-group-append">
				<span class="input-group-text">.00</span>
			</div>
		</div>

		<div class="invalid-feedback alert2 alert-danger2 amount_text_error" role="alert">
			<strong></strong>
		</div>
	</div>

</form>

<div class="form-group">
	<button type="submit" class="btn btn-primary to-deposit">
		{{ __('Deposit') }}
	</button>
</div>



<script>
	$(document).ready(function() {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

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

		// Вывести
		$('.to-deposit').on('click', function() {
			console.log($('#system').val());
			$.ajax({
				url: "{{ route('to_deposit') }}",
				type: 'post',
				data: {
					'amount': $('#deposit_amount').val(),
					'system': $('#system').val(),
					'_token': $('input[name="_token"]').val()
				},
				success: function(data) {

					error_field('other', false);
					error_field('amount', false);
					error_field('system', false);

					if (data.errors) {
						if (data.errors.amount) {
							error_field('amount', true, data.errors.amount[0]);
						}

						if (data.errors.system) {
							error_field('system', true, data.errors.system[0]);
						}

						if (data.errors.other) {
							error_field('other', true, data.errors.other[0]);
						}

					} else {
						if (data.success) {
							window.location.replace(data.url);
						}
					}

				}
			});
		});

	});
</script>