@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Users') }}</h1>

	<!-- <a class="btn btn-danger" href="{{ route('admin.robots.create') }}">
		{{ __('Create robot') }}
	</a> -->
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-end">

			</div>
			<!-- </div> -->


			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="users">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Full name') }}</th>
							<th>{{ __('E-mail') }}</th>
							<th>{{ __('Avatar') }}</th>
							<th>{{ __('Phone') }}</th>
							<th style="display: none2;">{{ __('Account numbers') }}</th>
							<th>{{ __('Date registration') }}</th>
						</tr>
					</thead>
					<tbody>

						@forelse ($users as $user)
						<tr>

							<td>
								<a href="{{ route('admin.users.info', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }}</a>
							</td>
							<td>
								{{ $user->email }}
							</td>
							<td>
								@if ($user->getFirstMediaUrl('avatars', 'thumb'))
								<img class="rounded-circle" width="60" height="60" src="{{ $user->getFirstMediaUrl('avatars', 'thumb') }}">
								@endif
							</td>
							<td>
								{{ $user->phone }}
							</td>
							<td style="display: none2;">

								@forelse ($user->accounts as $account)
								@if ($account->number)
								<div>{{ $account->number }}</div>
								@endif
								@empty
								Нет счетов
								@endforelse

							</td>
							<td>
								@if ($user->created_at)
								{{ date('d.m.Y H:i', strtotime($user->created_at)) }}
								@else
								–
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

<!-- Page level custom scripts -->
<script>
	$(document).ready(function() {

		// Таблица
		$('#users').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

	});
</script>
@endsection