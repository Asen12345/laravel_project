@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Robot settings') }}</h1>

	<div>
		<a class="btn btn-light mr-2" href="{{ route('admin.robots.index') }}">
			{{ __('Back') }}
		</a>

		<a class="btn btn-danger" href="{{ route('admin.robot-settings.create', $robot) }}">
			{{ __('Create setting') }}
		</a>
	</div>
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
				<table class="table align-items-center table-flush table-hover" id="robot-settings">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Setting name') }}</th>
							<th>{{ __('Symbol') }}</th>
							<th>{{ __('Active') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@forelse ($settings as $setting)
						<tr>
							<td>
								{{ $setting->name }}
							</td>
							<td>
								{{ $setting->symbol }}
							</td>
							<td>
								@if ($setting->active)
								<span class="badge badge-success">{{ __('Active') }}</span>
								@else
								<span class="badge badge-danger">{{ __('Inactive') }}</span>
								@endif
							</td>
							<td>
								<a class="btn btn-primary mr-2" href="{{ route('admin.robot-setting-parametrs.index', $setting) }}"><i class="fas fa-cogs""></i></a>
								
								<a class=" btn btn-primary mr-2" href="{{ route('admin.robot-settings.edit', $setting->id) }}"><i class="far fa-edit"></i></a>

								<form onsubmit="return confirm('{{ __('Are you sure you want to delete this entry?') }}')" style="display: inline-block;" method="POST" action="{{ route('admin.robot-settings.destroy', $setting->id) }}">
									@csrf
									@method('DELETE')
									<button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
								</form>

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
		$('#robot-settings').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

	});
</script>
@endsection