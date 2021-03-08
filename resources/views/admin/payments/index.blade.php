@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Payments') }}</h1>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">
			<!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> -->
			<!-- <h6 class="m-0 font-weight-bold text-primary">{{ __('My finances') }}</h6> -->
			<!-- </div> -->

			<!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<div></div>


			</div> -->

			<div class="row mt-4 mx-2 mb-2">
				<div class="col-md-4 col-lg-3 col-xl-2">
					<div class="form-group">
						<label>{{ __('Type operation') }}</label>
						<select class="form-control form-control-sm type-operation">
							<option value="0">{{ __('All') }}</option>
							<option value="1">{{ __('Cash receipts') }}</option>
							<option value="2">{{ __('Withdraw') }}</option>
							<option value="3">{{ __('Buying a robot') }}</option>
							<option value="4">{{ __('Sale of robots') }}</option>
							<option value="5">{{ __('Binar accrual') }}</option>

							<option value="6">{{ __('Investor withdraw') }}</option>
							<option value="7">{{ __('Investor accrual') }}</option>

						</select>
					</div>
				</div>
				<div class="col-md-4 col-lg-3 col-xl-2">
					<div class="form-group">
						<label>{{ __('Status operation') }}</label>
						<select class="form-control form-control-sm status-operation">
							<option value="4">{{ __('All') }}</option>
							<option value="0">{{ __('In process') }}</option>
							<option value="1">{{ __('Completed') }}</option>
							<option value="2">{{ __('Canceled') }}</option>
							<option value="3">{{ __('Rejected') }}</option>
						</select>
					</div>
				</div>
			</div>







			<div class="table-responsive p-3">
				<table class="table align-items-center table-flush table-hover" id="finances">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Date') }}</th>
							<th>{{ __('Amount') }}</th>
							<th>{{ __('Description') }}</th>
							<th style="display: none;">{{ __('Type') }}</th>
							<th>{{ __('Status') }}</th>
							<th style="display: none;">{{ __('Status') }}</th>
							<th style="display: none;">{{ __('Table') }}</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@forelse ($payments as $payment)
						<tr>
							<td>
								@if ($payment->created_at)
								<a href="" data-toggle="modal" data-target="#window-detail{{ $payment->id }}" id="#modalCenter">{{ date('d.m.Y H:i', strtotime($payment->created_at)) }}</a>
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
							<td style="display: none;">
								{{ $payment->type }}
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
							<td style="display: none;">
								{{ $payment->status }}
							</td>
							<td style="display: none;">
								{{ $payment->table }}
							</td>
							<td>
								@if ($payment->status == 0 && $payment->type == 2)
								<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#window-withdraw{{ $payment->id }}" id="#modalCenter">
									{{ __('Withdraw') }}
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





@forelse ($payments as $payment)




<div class="modal fade" id="window-detail{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Payment details') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Date') }}</div>
					<div class="col-md-6 text-right">{{ date('d.m.Y H:i', strtotime($payment->created_at)) }}</div>
				</div>

				@if ($payment->user)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('User') }}</div>
					<div class="col-md-6 text-right">
						<a target="_blank" href="{{ route('admin.users.info', $payment->user->id) }}">{{ $payment->user->email }}</a>
					</div>
				</div>
				@endif

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Amount') }}</div>
					<div class="col-md-6 text-right">
						@if ($payment->amount < 0) <span style="color: red;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
							@else
							<span style="color: #00b300;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
							@endif
					</div>
				</div>

				@if ($payment->fee)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Fee') }}</div>
					<div class="col-md-6 text-right">
						{{ number_format($payment->fee, 0, " ", " ") }} $
					</div>
				</div>
				@endif

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Total') }}</div>
					<div class="col-md-6 text-right">
						@php ($total = $payment->amount - $payment->fee)
						{{ $total }} $
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Type') }}</div>
					<div class="col-md-6 text-right">{{ $payment->status_title() }}</div>
				</div>

				@if ($payment->payee)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Payee') }}</div>
					<div class="col-md-6 text-right">
						{{ $payment->payee }}
					</div>
				</div>
				@endif

				@if ($payment->payer)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Payer') }}</div>
					<div class="col-md-6 text-right">
						{{ $payment->payer }}
					</div>
				</div>
				@endif

				@if ($payment->payment_system)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Payment system') }}</div>
					<div class="col-md-6 text-right">
						{{ $payment->payment_system }}
					</div>
				</div>
				@endif

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Confirm date') }}</div>
					<div class="col-md-6 text-right">{{ date('d.m.Y H:i', strtotime($payment->confirm_date)) }}</div>
				</div>

				<form class="batcn-execute" method="POST" action="{{ route('admin.payments.execute') }}">
					@csrf
					<input name="payment_id" value="{{ $payment->id }}" type="hidden">
					<div class="my-3 row">
						<div class="col-md-6">{{ __('Batcn') }}</div>
						<div class="col-md-6 text-right">
							@if ($payment->status != 1)
							<input id="batcn" type="text" class="form-control batcn_input_error" name="batcn" value="">
							<span class="invalid-feedback batcn_error" role="alert">
								<strong></strong>
							</span>
							@else
							{{ $payment->batcn }}
							@endif
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-success" @if ($payment->status == 1) hidden @endif>{{ __('Execute') }}</button>
						<button class="btn btn-danger" @if ($payment->status != 1) hidden @endif>{{ __('Cancel') }}</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>




<!-- Modal Center -->
<div class="modal fade" id="window-withdraw{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Withdraw') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				@if ($payment->user)
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Wallet') }}</div>
					<div class="col-md-6 text-right">{{ $payment->user->purse }}</div>
				</div>
				@endif
				
				<div class="my-3 row">
					<div class="col-md-6">{{ __('Withdrawal to') }}</div>
					<div class="col-md-6 text-right">
						@if ($payment->payment_system == 0) 
						{{ __('Adv Cash') }}
						@else
						{{ __('Card') }}
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Amount') }}</div>
					<div class="col-md-6 text-right">{{ $payment->amount }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Fee') }}</div>
					<div class="col-md-6 text-right">{{ $payment->fee }}</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-6">{{ __('Total') }}</div>
					<div class="col-md-6 text-right">
						@php ($total = $payment->amount - $payment->fee)
						{{ $total }}
					</div>
				</div>



				<form class="batcn-execute" method="POST" action="{{ route('admin.payments.execute') }}">
					@csrf
					<input name="payment_id" value="{{ $payment->id }}" type="hidden">
					<div class="my-3 row">
						<div class="col-md-6">{{ __('Batcn') }}</div>
						<div class="col-md-6 text-right">
						@if ($payment->investor)
						<input type="hidden" name="investor" value="1">
						@endif
							@if ($payment->status != 1)
							<input id="batcn" type="text" class="form-control batcn_input_error" name="batcn" value="">
							<span class="invalid-feedback batcn_text_error" role="alert">
								<strong></strong>
							</span>
							@else
							{{ $payment->batcn }}
							@endif
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-success" @if ($payment->status == 1) hidden @endif>{{ __('Execute') }}</button>
						<button class="btn btn-danger" @if ($payment->status != 1) hidden @endif>{{ __('Cancel') }}</button>
					</div>
				</form>


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

		// Таблица
		var payments = $('#finances').DataTable({
			"language": {
				"url": "{{ $locale }}"
			},
			"order": false
		});

		$('.type-operation').on('change', function() {
			payments.draw();
		});

		$('.status-operation').on('change', function() {
			payments.draw();
		});

		/* Custom filtering function which will search data in column four between two values */
		$.fn.dataTable.ext.search.push(
			function(settings, data, dataIndex) {
				var type_filter = parseFloat($('.type-operation').val());
				var status_filter = parseFloat($('.status-operation').val());

				var type = parseFloat(data[3]);
				var amount = parseFloat(data[1]);
				var status = parseFloat(data[5]);
				var table = data[6];

				if (status_filter == 4 || status_filter == status) { // если статус платежа подходит
					switch (type_filter) {
						case 0:
							return true;
							break;
						case 1:
							if (table == 'payments' && ((type == 1) || (type == 3 && amount > 0))) {
								return true;
							}
							break;
						case 2:
							if (table == 'payments' && ((type == 2) || (type == 3 && amount < 0))) {
								return true;
							}
							break;
						case 3:
							if (table == 'payments' && ((type == 4) || (type == 5) || (type == 6))) {
								return true;
							}
							break;
						case 4:
							if (table == 'payments' && ((type == 7) || (type == 8))) {
								return true;
							}
							break;
						case 5:
							if (table == 'payments' && (type >= 10 && type < 20)) {
								return true;
							}
							break;
						case 6:
							if (table == 'investor_payments' && type == 2) {
								return true;
							}
							break;
						case 7:
							if (table == 'investor_payments' && type == 1) {
								return true;
							}
							break;
					}
				}

				return false;
			}
		);


		$("body").on('submit', '.batcn-execute', function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: form.serialize(),
				success: function(data) {

					error_field('batcn', false);

					if (data.success) {
						location.reload();
					}

					if (data.error) {
						if (data.error.batcn) {
							error_field('batcn', true, data.error.batcn[0]);
						}
					}

					console.log(data);
				}
			});
		});

	});
</script>
@endsection