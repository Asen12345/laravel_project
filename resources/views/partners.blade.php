@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Partners') }}</h1>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">
			<!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> -->
			<!-- <h6 class="m-0 font-weight-bold text-primary"></h6> -->
			<!-- </div> -->
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="partners">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Registration date') }}</th>
							<th>{{ __('Fullname') }}</th>
							<th>{{ __('E-mail') }}</th>
							<th>{{ __('Status') }}</th>
						</tr>
					</thead>
					<!-- <tfoot>
						<tr>
							<th>{{ __('Registration date') }}</th>
							<th>{{ __('Fullname') }}</th>
							<th>{{ __('E-mail') }}</th>
							<th>{{ __('Status') }}</th>
						</tr>
					</tfoot> -->
					<tbody>

						@forelse ($partners as $partner)
						<tr>
							<td>{{ date('d.m.Y H:i', strtotime($partner->created_at)) }}</td>
							<td>{{ $partner->first_name }} {{ $partner->last_name }}</td>
							<td>{{ $partner->email }}</td>																					
							<td>{!! $partner->status() !!}</td>
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


@forelse ($partners as $partner)
<!-- Modal Center -->
<div class="modal fade" id="window-partner{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ $partner->first_name }} {{ $partner->last_name }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Registration date') }}</div>
					<div class="col-md-8 text-right">{{ date('d.m.Y H:i', strtotime($partner->created_at)) }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Tariff') }}</div>
					<div class="col-md-8 text-right">
						<b>
							@if ($partner->binar)
							@if ($partner->binar->type == 1)
							Standard
							@endif
							@if ($partner->binar->type == 2)
							Gold
							@endif
							@if ($partner->binar->type == 3)
							VIP
							@endif

							@else
							–
							@endif
						</b>
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Status') }}</div>
					<div class="col-md-8 text-right">{!! $partner->status() !!}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('E-mail') }}</div>
					<div class="col-md-8 text-right"><a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a></div>
				</div>

				@if ($partner->phone)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Phone') }}</div>
					<div class="col-md-8 text-right"><a href"tel:+{{ $partner->phone }}">{{ $partner->phoneNumber() }}</a></div>
				</div>
				@endif

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Contacts') }}</div>
					<div class="col-md-8 text-right fs-medium">
						@if ($partner->telegram)
						<a target="_blank" href="https://t.me/{{ $partner->telegram }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('Telegram') }}" class="fab fa-telegram-plane ml-2"></i></a>
						@endif

						@if ($partner->whatsapp)
						<a target="_blank" href="https://wa.me/{{ $partner->whatsapp }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('WhatsApp') }}" class="fab fa-whatsapp ml-2"></i></a>
						@endif

						@if ($partner->viber)
						<a target="_blank" href="viber://chat?number={{ $partner->viber }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('Viber') }}" class="fab fa-viber ml-2"></i></a>
						@endif

						@if ($partner->instagram)
						<a target="_blank" href="https://www.instagram.com/{{ $partner->instagram }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('Instagram') }}" class="fab fa-instagram ml-2"></i></a>
						@endif

						@if ($partner->fb)
						<a target="_blank" href="https://www.facebook.com/{{ $partner->fb }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('Facebook') }}" class="fab fa-facebook-f ml-2"></i></a>
						@endif

						@if ($partner->vk)
						<a target="_blank" href="https://vk.com/{{ $partner->vk }}"><i data-toggle="tooltip" data-placement="top" title="{{ __('Vkontakte') }}" class="fab fa-vk ml-2"></i></a>
						@endif
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@empty
@endforelse

<style>
	.fs-medium {
		font-size: 20px;
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

<!-- Page level custom scripts -->
<script>
	$(document).ready(function() {
		$('#partners').DataTable({
			"language": {
				"url": "{{ $locale }}"
			}
		});
	});

	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
@endsection