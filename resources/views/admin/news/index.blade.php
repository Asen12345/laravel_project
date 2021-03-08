@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('News') }}</h1>

	<a class="btn btn-danger" href="{{ route('admin.news.create') }}">
		{{ __('Create news') }}
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
				<table class="table align-items-center table-flush table-hover" id="news">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Date') }}</th>
							<th>{{ __('Title') }}</th>
							<th>{{ __('Cover') }}</th>
							<th>{{ __('Published') }}</th>
							<th>{{ __('Language') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@forelse ($news as $new)
						<tr>
							<td>
								@if ($new->created_at)
								{{ date('d.m.Y H:i', strtotime($new->created_at)) }}
								@else
								–
								@endif
							</td>
							<td>
								{{ $new->title }}
							</td>
							<td>
								@if ($new->getFirstMediaUrl('images', 'thumb'))
								<img width="60" height="60" src="{{ $new->getFirstMediaUrl('images', 'thumb') }}">
								@endif
							</td>
							<td>
								@if ($new->public)
								<span class="badge badge-success">{{ __('Published') }}</span>
								@else
								<span class="badge badge-danger">{{ __('Draft') }}</span>
								@endif
							</td>
							<td>

								@if ($new->lang == 'en')
								<span class="badge badge-dark">{{ __('English') }}</span>
								@endif
								@if ($new->lang == 'ru')
								<span class="badge badge-light">{{ __('Russian') }}</span>
								@endif

							</td>
							<td>
								<a class="btn btn-primary mr-2" href="{{ route('admin.news.edit', $new->id) }}"><i class="far fa-edit"></i></a>

								<form onsubmit="return confirm('{{ __('Are you sure you want to delete this entry?') }}')" style="display: inline-block;" method="POST" action="{{ route('admin.news.destroy', $new->id) }}">
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
		$('#news').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

	});
</script>
@endsection