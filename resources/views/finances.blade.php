@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-3">
	<h1 class="h3 mb-0 text-gray-800">{{ __('My finances') }}</h1>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-3">
	<h1 class="h3 mb-3 text-gray-800"><span class="finance-user">{{ __('Balance') }}: <b>{{ number_format(auth()->user()->balance(), 0, " ", " ") }}</b> $</span></h1>
	<div>
		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#window-deposit" id="#modalCenter">
			{{ __('Deposit') }}
		</button>

		<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#window-withdraw" id="#modalCenter">
			{{ __('Withdraw') }}
		</button>

		<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-remittance" id="#modalCenter">
			{{ __('Remittance') }}
		</button>
	</div>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">
			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="finances">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Date') }}</th>
							<th>{{ __('Amount') }}</th>
							<th>{{ __('Description') }}</th>
							<th>{{ __('Status') }}</th>
						</tr>
					</thead>
					<tbody>

						@forelse ($payments as $payment)
						<tr>
							<td>
								@if ($payment->created_at)
								{{ date('d.m.Y H:i', strtotime($payment->created_at)) }}
								@else
								–
								@endif</td>
							<td>
								@if ($payment->amount < 0) <span style="color: red;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
									@else
									<span style="color: #00b300;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
									@endif

							</td>
							<td>
								{{ $payment->status_title() }}
							</td>
							<td>

								@if ($payment->status == 0)
								<span class="badge badge-info">{{ __('In process') }}</span>
								@endif
								@if ($payment->status == 1)
								<span class="badge badge-success">{{ __('Completed') }}</span>
								@endif
								@if ($payment->status == 2)
								<span class="badge badge-warning">{{ __('Canceled') }}</span>
								@endif
								@if ($payment->status == 3)
								<span class="badge badge-danger">{{ __('Rejected') }}</span>
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


<!-- Пополнить -->
<div class="modal fade" id="window-deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Deposit') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">


			</div>
		</div>
	</div>
</div>

<!-- Перевести -->
<div class="modal fade" id="window-remittance" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Remittance') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">


			</div>
		</div>
	</div>
</div>


<!-- Вывести -->
<div class="modal fade" id="window-withdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Withdraw') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
		</div>
	</div>
</div>

<style>
	.finance-user {
		/* margin-left: 1rem; */
		font-size: 0.8em;
		color: rgba(0, 0, 0, 0.4);
	}
</style>

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

		// Таблица
		$('#finances').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

		// Пополнить
		$('#window-deposit').on('show.bs.modal', function(e) {
			$.ajax({
				url: "{{ route('deposit_modal') }}",
				type: 'get',
				success: function(data) {
					$('#window-deposit .modal-body').html(data);
				}
			});
		});



		// Вывод денег
		$('#window-withdraw').on('show.bs.modal', function(e) {
			$.ajax({
				url: "{{ route('withdraw_modal') }}",
				type: 'get',
				success: function(data) {
					$('#window-withdraw .modal-body').html(data);
				}
			});
		});

		// Перевод денег
		$('#window-remittance').on('show.bs.modal', function(e) {
			$.ajax({
				url: "{{ route('remittance_modal') }}",
				type: 'get',
				success: function(data) {
					$('#window-remittance .modal-body').html(data);
				}
			});
		});


	});
</script>
@endsection