@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Licenses') }}</h1>
	<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-buy" id="#modalCenter">
		{{ __('Buy a license') }}
	</button>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Free licenses') }}</h6>
			</div>

			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="licenses_one">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Activation key') }}</th>
							<th>{{ __('Date activation') }}</th>
							<th>{{ __('Check number') }}</th>
							<th>{{ __('Check type') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>



						@forelse ($accounts_one as $account)
						<tr>
							<td>{{ $account->active_kod }}</td>
							<td>
								@if ($account->date_activation AND $account->date_activation != '0000-00-00 00:00:00' AND $account->date_activation != NULL)
								{{ date('d.m.Y H:i', strtotime($account->date_activation)) }}
								@else
								–
								@endif</td>
							<td>
								@if ($account->number)
								{{ $account->number }}
								@else
								–
								@endif
							</td>
							<td>
								@if ($account->activated)
								@if ($account->real)
								<span class="badge badge-success">{{ __('Real') }}</span>
								@else
								@if ($account->real === NULL)
								–
								@else
								<span class="badge badge-danger">{{ __('Demo') }}</span>
								@endif
								@endif
								@else
								–
								@endif
							</td>
							<td>
								{{--
								<!-- @if ($account->number)
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-detail{{ $account->id }}" id="#modalCenter">
								{{ __('Detail') }}
								</button>
								@endif -->
								--}}

								<button class="btn btn-success" type="button" data-toggle="modal" data-target="#window-activate{{ $account->id }}" id="#modalCenter">
									{{ __('To activate') }}
								</button>

							</td>
						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
		</div>

		<div class="card mb-4">

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('My licenses') }}</h6>
			</div>

			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="licenses_two">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Activation key') }}</th>
							<th>{{ __('Date activation') }}</th>
							<th>{{ __('Check number') }}</th>
							<th>{{ __('Check type') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>



						@forelse ($accounts_two as $account)
						<tr>
							<td>{{ $account->active_kod }}</td>
							<td>
								@if ($account->date_activation AND $account->date_activation != '0000-00-00 00:00:00' AND $account->date_activation != NULL)
								{{ date('d.m.Y H:i', strtotime($account->date_activation)) }}
								@else
								–
								@endif</td>
							<td>
								@if ($account->number)
								{{ $account->number }}
								@else
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-account-number" num="{{ $account->id }}" id="#modalCenter">
									{{ __('To appoint') }}
								</button>
								@endif
							</td>
							<td>
								@if ($account->activated)
								@if ($account->real)
								<span class="badge badge-success">{{ __('Real') }}</span>
								@else
								@if ($account->real === NULL)
								–
								@else
								<span class="badge badge-danger">{{ __('Demo') }}</span>
								@endif
								@endif
								@else
								–
								@endif
							</td>
							<td>
								@if ($account->number)
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-detail{{ $account->id }}" id="#modalCenter">
									{{ __('Detail') }}
								</button>
								@endif
							</td>
						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
		</div>

		<div class="card mb-4">

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Client licenses') }}</h6>
			</div>

			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="licenses_three">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Activation key') }}</th>
							<th>{{ __('Date activation') }}</th>
							<th>{{ __('Check number') }}</th>
							<th>{{ __('Check type') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>



						@forelse ($accounts_three as $account)
						<tr>
							<td>{{ $account->active_kod }}</td>
							<td>
								@if ($account->date_activation AND $account->date_activation != '0000-00-00 00:00:00' AND $account->date_activation != NULL)
								{{ date('d.m.Y H:i', strtotime($account->date_activation)) }}
								@else
								–
								@endif</td>
							<td>
								@if ($account->number)
								{{ $account->number }}
								@else
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-account-number" num="{{ $account->id }}" id="#modalCenter">
									{{ __('To appoint') }}
								</button>
								@endif
							</td>
							<td>
								@if ($account->activated)
								@if ($account->real)
								<span class="badge badge-success">{{ __('Real') }}</span>
								@else
								@if ($account->real === NULL)
								–
								@else
								<span class="badge badge-danger">{{ __('Demo') }}</span>
								@endif
								@endif
								@else
								–
								@endif
							</td>
							<td>
								@if ($account->number)
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-detail{{ $account->id }}" id="#modalCenter">
									{{ __('Detail') }}
								</button>
								@endif
							</td>
						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>
<!--Row-->



@forelse ($accounts_one as $account)
<!-- Modal Center -->
<div class="modal fade" id="window-activate{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Activate license') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form class="form_activate" num="{{ $account->id }}">
					@csrf

					<input id="license_id{{ $account->id }}" name="license_id{{ $account->id }}" value="{{ $account->id }}" type="hidden">

					<div class="form-group">
						<label for="person">{{ __('Account number') }}</label>

						<select id="person{{ $account->id }}" name="person{{ $account->id }}" class="form-control person_input_error person_select">
							<option value="my">{{ __('Activate yourself') }}</option>
							<option value="email">{{ __('Activate user') }}</option>
						</select>

						<span class="invalid-feedback person_error" role="alert">
							<strong></strong>
						</span>
					</div>

					<div class="form-group activate_email">
						<label for="activate_email">{{ __('Email') }}</label>
						<input id="activate_email{{ $account->id }}" type="text" class="form-control activate_email_input_error" name="activate_email{{ $account->id }}">

						<span class="invalid-feedback activate_email_text_error" role="alert">
							<strong></strong>
						</span>
					</div>

					<div class="invalid-feedback alert alert-danger other_text_error" role="alert">
						<strong></strong>
					</div>

				</form>

				<div class="form-group">
					<button class="btn btn-success to-activate-license" num="{{ $account->id }}">
						<div class="activate_license_loader spinner-border spinner-border-sm float-left text-light mr-2 mt-1" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						{{ __('Activate') }}
					</button>
				</div>

			</div>
		</div>
	</div>
</div>
@empty
@endforelse


<!-- Назначить номер счета -->
<div class="modal fade" id="window-account-number" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('To appoint account number') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form class="to_appoint_form">
					@csrf

					<input id="account_id" name="id" value="0" type="hidden">

					<div class="form-group">
						<label for="email">{{ __('Account number') }}</label>

						<input id="account_number" type="text" class="form-control account_number_input_error" name="number" value="">

						<span class="invalid-feedback account_number_error" role="alert">
							<strong></strong>
						</span>

					</div>

				</form>

				<div class="form-group">
					<button class="btn btn-success to-appoint">{{ __('To appoint') }}</button>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- Купить лицензию -->
<div class="modal fade" id="window-buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Buy a license') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="my-3 row">
					<div class="col-md-6">{{ __('License price') }}</div>
					<div class="col-md-6 text-right">
						{{ number_format($license_price, 0, " ", " ") }} $
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('For partner') }}</div>
					<div class="col-md-6 text-right">
						{{ number_format($for_partner, 0, " ", " ") }} $
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('For pay') }}</div>
					<div class="col-md-6 text-right">
						{{ number_format($for_pay, 0, " ", " ") }} $
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Баланс счета') }}</div>
					<div class="col-md-6 text-right">
						{{ number_format(auth()->user()->balance(), 0, " ", " ") }} $
					</div>
				</div>

				<div class="form-group">
					<div class="alert alert-danger invalid-feedback other_text_error mt-4" role="alert">
						<strong></strong>
					</div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary to-buy">
						{{ __('Pay') }}
					</button>
				</div>


			</div>
		</div>
	</div>
</div>

@forelse ($accounts as $account)
<!-- Modal Center -->
<div class="modal fade" id="window-detail{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('License details') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Activation key') }}</div>
					<div class="col-md-6 text-right">{{ $account->active_kod }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Robot') }}</div>
					<div class="col-md-6 text-right">
						@if ($account->project)
						{{ $account->project->name }}
						@else
						{{ $account->project_id }}
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Robot version') }}</div>
					<div class="col-md-6 text-right">{{ $account->ver }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Date activation') }}</div>
					<div class="col-md-6 text-right">
						@if ($account->date_activation)
						{{ date('d.m.Y H:i', strtotime($account->date_activation)) }}
						@else
						–
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Date end of license') }}</div>
					<div class="col-md-6 text-right">
						@if ($account->date_expiration)
						{{ date('d.m.Y H:i', strtotime($account->date_expiration)) }}
						@else
						–
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Check number') }}</div>
					<div class="col-md-6 text-right">{{ $account->number }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Shoulder') }}</div>
					<div class="col-md-6 text-right">
						@if ($account->leverage)
						1:{{ $account->leverage }}
						@else
						–
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Check type') }}</div>
					<div class="col-md-6 text-right">
						@if ($account->activated)
						@if ($account->real)
						<span class="badge badge-success">{{ __('Real') }}</span>
						@else
						@if ($account->real === NULL)
						–
						@else
						<span class="badge badge-danger">{{ __('Demo') }}</span>
						@endif
						@endif
						@else
						–
						@endif
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@empty
@endforelse

@endsection

<!-- 33028645 -->


@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

@if (app()->getLocale() == 'ru')
@php ($locale = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json")
@else
@php ($locale = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json")
@endif

<!-- Page level custom scripts -->
<script>
	$(document).ready(function() {
		$('#licenses_one').DataTable({
			"language": {
				"url": "{{ $locale }}"
			}
		});

		$('#licenses_two').DataTable({
			"language": {
				"url": "{{ $locale }}"
			}
		});

		$('#licenses_three').DataTable({
			"language": {
				"url": "{{ $locale }}"
			}
		});

		$('.activate_license_loader').hide();

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

		error_field('other', false);

		$('.activate_email').hide();

		$('select.person_select').on('change', function() {
			if ($(this).val() == 'email') {
				$('.activate_email').show();
			} else {
				$('.activate_email').hide();
			}
		});

		$('#window-account-number').on('show.bs.modal', function(e) {
			$('#account_id').val($(e.relatedTarget).attr('num'));
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('.to-activate-license').on('click', function() {
			var num = $(this).attr('num');
			$('button[num=' + num + ']' + ' .activate_license_loader').show();
			$.ajax({
				url: "{{ route('to_activate_license') }}",
				type: 'post',
				data: {
					'id': $('#license_id' + num).val(),
					'person': $('#person' + num).val(),
					'email': $('#activate_email' + num).val()
				},
				success: function(data) {
					console.log(data);

					error_field('other', false);
					error_field('activate_email', false);

					$('.activate_license_loader').hide();

					if (data.error) {
						if (data.error.other) {
							error_field('other', true, data.error.other[0]);
						}
						if (data.error.email) {
							error_field('activate_email', true, data.error.email[0]);
						}
					} else {
						location.reload();
					}

				},
				error: function(error) {
					console.log(error);
				}
			});
		});


		$(document).on('submit', 'form.to_appoint_form', function(event) {
			event.preventDefault();
			console.log('asdadsasd');
			to_appoint();
		});



		$('.to-appoint').on('click', function() {
			to_appoint();
		});


		function to_appoint() {
			$.ajax({
				url: "{{ route('to_appoint') }}",
				type: 'post',
				data: {
					'id': $('#account_id').val(),
					'number': $('#account_number').val()
				},
				success: function(data) {
					console.log(data);

					if (data.error) {
						$('.account_number_error strong').html(data.error[0]);
						$('.account_number_error').show();
						$('.account_number_input_error').addClass('is-invalid');
					} else {
						location.reload();
					}

				},
				error: function(error) {
					console.log(error);
				}
			});
		}


		// Купить лицензию
		$('.to-buy').on('click', function() {
			$.ajax({
				url: "{{ route('license_buy') }}",
				type: 'post',
				success: function(data) {

					error_field('other', false);

					if (data.errors) {
						if (data.errors.other) {
							error_field('other', true, data.errors.other[0]);
						}
					} else {
						location.reload();
					}

				}
			});
		});


	});
</script>
@endsection