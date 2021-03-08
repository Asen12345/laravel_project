@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Edit user info') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.users') }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">

	<div class="col-md-6">
		<div class="card mb-4">

			<div class="card-body">

				@if (session('personal_data_success'))
				<div class="alert alert-success" role="alert">
					{{ session('personal_data_success') }}
				</div>
				@endif


				<form class="user" method="POST" action="{{ route('admin.users.personal_data', $user) }}">
					@csrf

					<div class="my-3 row">
						<div class="col-md-6">{{ __('Firstname') }}</div>
						<div class="col-md-6">

							<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}">

							@error('first_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror

						</div>
					</div>
					<div class="my-3 row">
						<div class="col-md-6">{{ __('Lastname') }}</div>
						<div class="col-md-6">
							<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}">

							@error('last_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="my-3 row">
						<div class="col-md-6">{{ __('E-mail') }}</div>
						<div class="col-md-6">
							<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">

							@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="my-3 row">
						<div class="col-md-6">{{ __('Phone') }}</div>
						<div class="col-md-6">
							<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}">

							@error('phone')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					@if ($user->curator)
					<div class="my-3 row">
						<div class="col-md-6">{{ __('Curator') }}</div>
						<div class="col-md-6"><a href="{{ route('admin.users.info', $user->curator->id) }}">{{ $user->curator->first_name }} {{ $user->curator->last_name }}</a></div>
					</div>
					@endif

					<div class="my-3 row">
						<div class="col-md-6"></div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary">
								{{ __('Save') }}
							</button>
						</div>
					</div>

				</form>

				<form class="float-left mr-1" method="POST" action="{{ route('admin.users.login_as') }}">
					@csrf
					<input type="hidden" name="user_id" value="{{ $user->id }}">
					<button type="submit" class="btn btn-success">
						{{ __('Login as user') }}
					</button>
				</form>

			</div>

		</div>
	</div>



	<div class="col-md-6">
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

				<form class="user" method="POST" action="{{ route('admin.users.change_password', $user) }}">
					@csrf

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
	</div>

</div>

<div class="row">

	<div class="col-md-12">
		<div class="card mb-4">
			<div class="card-header">
				<h3>{{ __('Licenses') }}</h3>
			</div>
			<div class="card-body">

				<!-- ключ, дата активации, номер счета (accounts->number). При нажатии на номер счета должна выводиться полная информация по счету из базы. Во всплывающем окне должно быть несколько кнопок: блокироват, отвязать от счет, продлить доступ. -->

				<div class="table-responsive">
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
						<tbody>


							@forelse ($user->accounts as $account)
							<tr>
								<td>{{ $account->active_kod }}</td>
								<td>
									@if ($account->date_activation)
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
									@if ($account->real)
									<span class="badge badge-success">{{ __('Real') }}</span>
									@else
									@if ($account->real === NULL)
									–
									@else
									<span class="badge badge-danger">{{ __('Demo') }}</span>
									@endif
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

				<form class="to-appoint" method="post" action="{{ route('to_appoint') }}">
					@csrf

					<input id="account_id" name="id" value="0" type="hidden">

					<div class="form-group">
						<label for="email">{{ __('Account number') }}</label>

						<input id="account_number" type="text" class="form-control account_number_input_error" name="number" value="">

						<span class="invalid-feedback account_number_error" role="alert">
							<strong></strong>
						</span>

					</div>

					<div class="form-group">
						<button class="btn btn-success">{{ __('To appoint') }}</button>
					</div>

				</form>



			</div>
		</div>
	</div>
</div>


@forelse ($user->accounts as $account)
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
						@if ($account->real)
						<span class="badge badge-success">{{ __('Real') }}</span>
						@else
						@if ($account->real === NULL)
						–
						@else
						<span class="badge badge-danger">{{ __('Demo') }}</span>
						@endif
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

<style>
	.custom-file-label::after {
		content: "{{ __('Browse') }}"
	}
</style>

@endsection

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

@if (app()->getLocale() == 'ru')
@php ($locale = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json")
@else
@php ($locale = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json")
@endif

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
		});


		$("body").on('submit', '.to-appoint', function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: form.serialize(),
				success: function(data) {
					if (data.error) {
						$('.account_number_error strong').html(data.error[0]);
						$('.account_number_error').show();
						$('.account_number_input_error').addClass('is-invalid');
					} else {
						location.reload();
					}
					console.log(data);
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