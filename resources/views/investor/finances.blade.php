@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-3">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Investor finance') }}</h1>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-3">
	<h1 class="h3 mb-0 text-gray-800"><span class="finance-investor">({{ __('Balance') }}: <b>{{ number_format(auth()->user()->investor_balance(), 0, " ", " ") }}</b> $)</span></h1>

	<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#window-withdraw" id="#modalCenter">
		{{ __('Withdraw') }}
	</button>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">
			<!-- 
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<div></div>

				<div>

				</div>
			</div> -->


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
					<!-- <tfoot>
						<tr>
							<th>{{ __('Date') }}</th>
							<th>{{ __('Amount') }}</th>
							<th>{{ __('Description') }}</th>
							<th>{{ __('Status') }}</th>
						</tr>
					</tfoot> -->
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
	.finance-investor {
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

		// Вывод денег
		$('#window-withdraw').on('show.bs.modal', function(e) {
			$.ajax({
				url: "{{ route('investor_withdraw_modal') }}",
				type: 'get',
				success: function(data) {
					$('#window-withdraw .modal-body').html(data);
				}
			});
		});

	});
</script>
@endsection