@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Licenses') }}</h1>

</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">
			<!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> -->
			<!-- <h6 class="m-0 font-weight-bold text-primary">{{ __('Licenses') }}</h6> -->
			<!-- </div> -->
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="licenses">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Activation key') }}</th>
							<th>{{ __('Date activation') }}</th>
							<th>{{ __('Check number') }}</th>
							<th>{{ __('Check type') }}</th>
							<th></th>
						</tr>
					</thead>
					<!-- <tfoot>
						<tr>
							<th>{{ __('Activation key') }}</th>
							<th>{{ __('Date activation') }}</th>
							<th>{{ __('Check number') }}</th>
							<th>{{ __('Check type') }}</th>
							<th></th>
						</tr>
					</tfoot> -->
					<tbody>



						@forelse ($accounts as $account)
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

				<form class="user">
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


				<div class="mt-5 mb-3">

					<form class="block-account float-left mr-1" method="POST" action="{{ route('admin.users.licenses.block') }}">
						@csrf
						<input type="hidden" name="account_id" value="{{ $account->id }}">

						<button type="submit" class="btn btn-primary unblock-button" @if (!$account->blocked) hidden @endif >
							{{ __('Unblock') }}
						</button>
						<button type="submit" class="btn btn-danger block-button" @if ($account->blocked) hidden @endif >
							{{ __('Block') }}
						</button>
					</form>


					@if ($account->number)
					<form class="detach-account float-left mr-1" method="POST" action="{{ route('admin.users.licenses.detach') }}">
						@csrf
						<input type="hidden" name="account_id" value="{{ $account->id }}">

						<button type="submit" class="btn btn-danger">
							{{ __('Detach from account') }}
						</button>
					</form>
					@endif


					<form class="renew-account float-left mr-1" method="POST" action="{{ route('admin.users.licenses.renew') }}">
						@csrf
						<input type="hidden" name="account_id" value="{{ $account->id }}">

						<button type="submit" class="btn btn-success">
							{{ __('Renew access') }}
						</button>
					</form>



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
		$('#licenses').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

		$('#window-account-number').on('show.bs.modal', function(e) {
			$('#account_id').val($(e.relatedTarget).attr('num'));
		})

		$('.to-appoint').on('click', function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
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

						// $('#window-account-number').modal('hide');
						// $('.account_number_error').hide();
						// $('.account_number_input_error').removeClass('is-invalid');
					}

				},
				error: function(error) {
					console.log(error);
				}
			});
		});

		$("body").on('submit', '.block-account', function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: form.serialize(),
				success: function(data) {
					if (data.success) {
						if (data.value) {
							$('.unblock-button').removeAttr('hidden');
							$('.block-button').attr('hidden', 'hidden');
						} else {
							$('.block-button').removeAttr('hidden');
							$('.unblock-button').attr('hidden', 'hidden');
						}
					}
					console.log(data);
				}
			});
		});

		$("body").on('submit', '.detach-account', function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: form.serialize(),
				success: function(data) {
					location.reload();
				}
			});
		});

		$("body").on('submit', '.renew-account', function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: form.serialize(),
				success: function(data) {
					location.reload();
				}
			});
		});

	});
</script>
@endsection