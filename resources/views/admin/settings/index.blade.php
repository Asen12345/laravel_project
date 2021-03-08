@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Settings') }}</h1>

	<a class="btn btn-danger" href="{{ route('admin.settings.create') }}">
		{{ __('Create setting') }}
	</a>
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
				<table class="table align-items-center table-flush table-hover" id="settings">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Index') }}</th>
							<th>{{ __('Value') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@forelse ($settings as $setting)
						<tr>
							<td>
								{{ $setting->key }}
							</td>
							<td>
								{{ $setting->value }}
							</td>

							<td>

								<a class=" btn btn-primary mr-2" href="{{ route('admin.settings.edit', $setting) }}"><i class="far fa-edit"></i></a>

								<form onsubmit="return confirm('{{ __('Are you sure you want to delete this entry?') }}')" style="display: inline-block;" method="POST" action="{{ route('admin.settings.destroy', $setting) }}">
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
		$('#settings').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

	});
</script>
@endsection