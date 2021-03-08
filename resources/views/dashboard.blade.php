@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Dashboard') }}</h1>
</div>


<div class="row mb-3">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-4 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Total salary') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ number_format($total_salary, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">$ {{ number_format($monthly_salary, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_salary > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_salary > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_salary, 2, '.', ' ') }} %</span>
							<span>{{ __('Since last month') }}</span>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-hand-holding-usd fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Annual) Card Example -->
	<div class="col-xl-4 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">

				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Robot sales') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_robot_sales, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">{{ number_format($monthly_robot_sales, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_robot_sales > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_robot_sales > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_robot_sales, 2, '.', ' ') }} %</span>
							<span>{{ __('Since last month') }}</span>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-robot fa-2x text-primary"></i>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- New User Card Example -->
	<div class="col-xl-4 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">

				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Total active partners') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_active_users, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">{{ number_format($monthly_active_users, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_active_users > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_active_users > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_active_users, 2, '.', ' ') }} %</span>
							<span>{{ __('Since last month') }}</span>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user-graduate fa-2x text-warning"></i>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Pending Requests Card Example -->
	<!-- <div class="col-xl-3 col-md-6 mb-4"> -->
	<!-- <div class="card h-100"> -->
	<!-- {{--<div class="card-body">

			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Total active users') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_active_users, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">{{ number_format($monthly_active_users, 0, '.', ' ') }}</span></small></div>
					<div class="mt-2 mb-0 text-muted text-xs">
						<span class="@if ($procent_active_users > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_active_users > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_active_users, 2, '.', ' ') }} %</span>
						<span>{{ __('Since last month') }}</span>
					</div>
				</div>
				<div class="col-auto">
					
				</div>
			</div>

		</div>--}} -->
	<!-- </div> -->
	<!-- </div> -->

	<!-- Area Chart -->
	<div class="col-xl-8 col-lg-7">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Income') }}</h6>
				<div class="dropdown no-arrow">
					<!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div> -->
				</div>
			</div>
			<div class="card-body">
				<div class="chart-area">
					<canvas id="DepositWithdrawAreaChart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<!-- Pie Chart -->
	<!-- <div class="col-xl-4 col-lg-5">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Month <i class="fas fa-chevron-down"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Select Periode</div>
						<a class="dropdown-item" href="#">Today</a>
						<a class="dropdown-item" href="#">Week</a>
						<a class="dropdown-item active" href="#">Month</a>
						<a class="dropdown-item" href="#">This Year</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="mb-3">
					<div class="small text-gray-500">Oblong T-Shirt
						<div class="small float-right"><b>600 of 800 Items</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">Gundam 90'Editions
						<div class="small float-right"><b>500 of 800 Items</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">Rounded Hat
						<div class="small float-right"><b>455 of 800 Items</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div class="progress-bar bg-danger" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">Indomie Goreng
						<div class="small float-right"><b>400 of 800 Items</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">Remote Control Car Racing
						<div class="small float-right"><b>200 of 800 Items</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
			<div class="card-footer text-center">
				<a class="m-0 small text-primary card-link" href="#">View More <i class="fas fa-chevron-right"></i></a>
			</div>
			</div>
		</div>-->
	<!-- Message From Customer-->
	<div class="col-xl-4 col-lg-5 ">
		<div class="card">
			<div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-light">{{ __('Last news') }}</h6>
			</div>
			<div>

				@forelse ($articles as $article)

				<div class="customer-message align-items-center">
					<a class="font-weight-bold" target="_blank" href="{{ route('new', $article->id) }}">
						<div class="text-truncate message-title">{{ $article->title }}</div>
						<div class="small text-gray-500 message-time font-weight-bold">{{ date('d.m.Y H:i', strtotime($article->created_at)) }}</div>
					</a>
				</div>

				@empty
				@endforelse


				<div class="card-footer text-center">
					<a class="m-0 small text-primary card-link" href="{{ route('news') }}">{{ __('View more') }} <i class="fas fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
	</div>

	<!-- Invoice Example -->
	<div class="col-xl-6 col-lg-6 mb-4">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Last deposits') }}</h6>
				<!-- <a class="m-0 float-right btn btn-danger btn-sm" href="#">View More <i class="fas fa-chevron-right"></i></a> -->
			</div>
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Confirm date') }}</th>
							<th>{{ __('Description') }}</th>
							<th>{{ __('Amount') }}</th>
						</tr>
					</thead>
					<tbody>

						@forelse ($payments_last as $payment)
						<tr>
							<td>
								@if ($payment->confirm_date)
								{{ date('d.m.Y H:i', strtotime($payment->confirm_date)) }}
								{{--<a href="" data-toggle="modal" data-target="#window-detail{{ $payment->id }}" id="#modalCenter"></a>--}}
								@else
								–
								@endif</td>

							<td>
								{{ $payment->status_title() }}
							</td>

							<td>
								@if ($payment->amount < 0) <span style="color: red;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
									@else
									<span style="color: #00b300;">{{ number_format($payment->amount, 0, " ", " ") }} $</span>
									@endif
							</td>

						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
	<div class="col-xl-6 col-lg-6 mb-4">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Last users') }}</h6>
				<!-- <a class="m-0 float-right btn btn-danger btn-sm" href="#">View More <i class="fas fa-chevron-right"></i></a> -->
			</div>
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th>{{ __('Registration date') }}</th>
							<th>{{ __('Full name') }}</th>
							<th>{{ __('E-mail') }}</th>
							<th>{{ __('Phone') }}</th>
						</tr>
					</thead>
					<tbody>

						@forelse ($users_last as $user)
						<tr>
							<td>
								@if ($user->created_at)
								{{ date('d.m.Y H:i', strtotime($user->created_at)) }}
								@else
								–
								@endif
							</td>
							<td>
								{{ $user->first_name }} {{ $user->last_name }}
							</td>
							<td>
								<a href="#" data-toggle="modal" data-target="#window-user{{ $user->id }}" id="#modalCenter">{{ $user->email }}</a>
							</td>
							<td>
								{{ $user->phone }}
							</td>



						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div>
<!--Row-->


@forelse ($users_last as $partner)
<!-- Modal Center -->
<div class="modal fade" id="window-user{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

@endsection





@section('scripts')
<script>
	$(document).ready(function() {

		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})

		var labels = <?php echo json_encode($graph["labels"]); ?>;
		var values = <?php echo json_encode($graph["values"]); ?>;

		// Area Chart Example
		var ctx = document.getElementById("DepositWithdrawAreaChart");
		var myLineChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: labels,
				// labels: ["ads", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "ads", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
					label: "{{ __('Deposit - withdraw') }}",
					lineTension: 0.3,
					backgroundColor: "rgba(78, 115, 223, 0.5)",
					borderColor: "rgba(78, 115, 223, 1)",
					pointRadius: 3,
					pointBackgroundColor: "rgba(78, 115, 223, 1)",
					pointBorderColor: "rgba(78, 115, 223, 1)",
					pointHoverRadius: 3,
					pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
					pointHoverBorderColor: "rgba(78, 115, 223, 1)",
					pointHitRadius: 10,
					pointBorderWidth: 2,
					data: values
					// data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000, 0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
				}],
			},
			options: {
				maintainAspectRatio: false,
				layout: {
					padding: {
						left: 10,
						right: 25,
						top: 25,
						bottom: 0
					}
				},
				scales: {
					xAxes: [{
						time: {
							unit: 'date'
						},
						gridLines: {
							display: false,
							drawBorder: false
						},
						ticks: {
							maxTicksLimit: 7
						}
					}],
					yAxes: [{
						ticks: {
							maxTicksLimit: 5,
							padding: 10,
							// Include a dollar sign in the ticks
							callback: function(value, index, values) {
								return '$' + number_format(value);
							}
						},
						gridLines: {
							color: "rgb(234, 236, 244)",
							zeroLineColor: "rgb(234, 236, 244)",
							drawBorder: false,
							borderDash: [2],
							zeroLineBorderDash: [2]
						}
					}],
				},
				legend: {
					display: false
				},
				tooltips: {
					backgroundColor: "rgb(255,255,255)",
					bodyFontColor: "#858796",
					titleMarginBottom: 10,
					titleFontColor: '#6e707e',
					titleFontSize: 14,
					borderColor: '#dddfeb',
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					displayColors: false,
					intersect: false,
					mode: 'index',
					caretPadding: 10,
					callbacks: {
						label: function(tooltipItem, chart) {
							var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
							return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
						}
					}
				}
			}
		});

	});
</script>
@endsection