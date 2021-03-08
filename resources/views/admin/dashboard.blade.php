@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Dashboard') }}</h1>
</div>


<!-- 
Products Sold будет основана на цифрах из базы, скажу каких позже.

Первая строка Пополнение /Вывод
Основывается на сумме payments->amount WHERE type=1 AND status=1 и сумме payments->amount WHERE type=2 AND status=1 (отрезок времени по created_at)

Вторая строка Ключей / Активных ключей
Основывается на количеству строк accounts WHERE date = нужный отреок времени и accounts date_activation = нужный отрезок времени

Третья строка Пользователей / Активный пользователь
Четвертая строка Основывается на кол-во строк в users / binar

Второй блок Данные по бинару (без указания временного отредзка)

Первая строка Бинар / Активированных бинаров
Основывается на кол-во строк binar всего / binar WHERE activation=1

Вторая строка Всего баллов / Баллов выплачено
Всего баллов рассчитывается как сумма payments->amount WHERE type=10 и сумма binar->left_pv+binar->right_pv
Баллов выплачено payments->amount

Третья строка Всего баллов / Баллов потеряно
Всего баллов см. выше
Баллов потеряно сумма binar->left_lost+binar->right_lost+users->lost_money -->


<div class="row mb-3">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">
				<div class="row align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Total turnover') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ number_format($total_turnover, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">$ {{ number_format($monthly_turnover, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_turnover > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_turnover > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_turnover, 2, '.', ' ') }} %</span>
							<span>{{ __('Since last month') }}</span>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-money-check-alt fa-2x text-primary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Annual) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">

				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Deposit - withdraw') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ number_format($total_income, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">$ {{ number_format($monthly_income, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_income > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_income > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_income, 2, '.', ' ') }} %</span>
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
	<!-- New User Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">

				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('Total robots activated') }} <small><span class="text-gray-600 ml-2">{{ __('Monthly') }}</span></small></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total_activated_robots, 0, '.', ' ') }} <small><span class="text-gray-600 ml-2">{{ number_format($monthly_activated_robots, 0, '.', ' ') }}</span></small></div>
						<div class="mt-2 mb-0 text-muted text-xs">
							<span class="@if ($procent_activated_robots > 0) text-success @else text-danger @endif mr-2"><i class="fa @if ($procent_activated_robots > 0) fa-arrow-up @else fa-arrow-down @endif"></i> {{ number_format($procent_activated_robots, 2, '.', ' ') }} %</span>
							<span>{{ __('Since last month') }}</span>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-robot fa-2x text-info"></i>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card h-100">
			<div class="card-body">

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
						<i class="fas fa-user-graduate fa-2x text-warning"></i>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Area Chart -->
	<div class="col-xl-8 col-lg-7">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Company profitability') }}</h6>
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
	<div class="col-xl-4 col-lg-5">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('General project data') }}</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div id="summary_loader" class="spinner-border spinner-border-sm float-left text-light mr-2 mt-1" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<span class="title_period">{{ __('Period') }}</span> <i class="fas fa-chevron-down"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">{{ __('Select period') }}</div>
						<a class="dropdown-item change_period_summary active2" period="all">{{ __('Period') }}</a>
						<a class="dropdown-item change_period_summary" period="month">{{ __('Month') }}</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="mb-3">
					<div class="small text-gray-500">{{ __('Total deposit') }} / {{ __('Total withdraw') }}
						<div class="small float-right"><b><span id="summary_total_withdraw">{{ number_format($summary['total_withdraw'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_income">{{ number_format($summary['total_income'], 0, '.', ' ') }}</span> $</b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_withdraw_deposit" class="progress-bar bg-warning" role="progressbar" style="width: {{ $summary['procent_withdraw_deposit'] }}%"></div>
					</div>
				</div>
				<div class=" mb-3">
					<div class="small text-gray-500">{{ __('Total keys') }} / {{ __('Total active keys') }}
						<div class="small float-right"><b><span id="summary_total_active_keys">{{ number_format($summary['total_active_keys'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_keys">{{ number_format($summary['total_keys'], 0, '.', ' ') }}</span></b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_active_keys" class="progress-bar bg-success" role="progressbar" style="width: {{ $summary['procent_active_keys'] }}%"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">{{ __('Total users') }} / {{ __('Total active users') }}
						<div class="small float-right"><b><span id="summary_total_active_users">{{ number_format($summary['total_active_users'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_users">{{ number_format($summary['total_users'], 0, '.', ' ') }}</span></b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_active_users" class="progress-bar bg-danger" role="progressbar" style="width: {{ $summary['procent_active_users'] }}%"></div>
					</div>
				</div>
			</div>

		</div>


		<!-- Pie Chart -->
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">{{ __('Binar data') }}</h6>
			</div>
			<div class="card-body">
				<div class="mb-3">
					<div class="small text-gray-500">{{ __('Total binars') }} / {{ __('Total active binars') }}
						<div class="small float-right"><b><span id="summary_total_active_binars">{{ number_format($summary['total_active_binars'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_binars">{{ number_format($summary['total_binars'], 0, '.', ' ') }}</span></b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_active_binars" class="progress-bar bg-primary" role="progressbar" style="width: {{ $summary['procent_active_binars'] }}%"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">{{ __('Total points') }} / {{ __('Total points paid') }}
						<div class="small float-right"><b><span id="summary_total_points_paid">{{ number_format($summary['total_points_paid'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_points">{{ number_format($summary['total_points'], 0, '.', ' ') }}</span></b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_points_paid" class="progress-bar bg-info" role="progressbar" style="width: {{ $summary['procent_points_paid'] }}%"></div>
					</div>
				</div>
				<div class="mb-3">
					<div class="small text-gray-500">{{ __('Total points') }} / {{ __('Total points lost') }}
						<div class="small float-right"><b><span id="summary_total_points_lost">{{ number_format($summary['total_points_lost'], 0, '.', ' ') }}</span> {{ __('of') }} <span id="summary_total_points">{{ number_format($summary['total_points'], 0, '.', ' ') }}</span></b></div>
					</div>
					<div class="progress" style="height: 12px;">
						<div id="summary_procent_points_lost" class="progress-bar bg-danger" role="progressbar" style="width: {{ $summary['procent_points_lost'] }}%"></div>
					</div>
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
							<th>{{ __('Fullname') }}</th>
							<th>{{ __('E-mail') }}</th>
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
								@if ($payment->user)
								{{ $payment->user->first_name }} {{ $payment->user->last_name }}
								@endif
							</td>
							<td>
								@if ($payment->user)
								{{ $payment->user->email }}
								@endif
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
								{{--<a href="{{ route('admin.users.info', $user->id) }}"></a>--}}
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

		$('#summary_loader').hide();

		$('.change_period_summary').on('click', function() {
			$('#summary_loader').show();

			var element_period = $(this);
			var period = element_period.attr('period');
			var period_title = element_period.text();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				type: 'post',
				url: "{{ route('admin.dashboard.summary') }}",
				data: {
					'period': period,
				},
				success: function(data) {
					data = JSON.parse(data);
					console.log(data);
					if (data && data.success) {

						$('.title_period').text(period_title);
						$('#summary_total_income').html(divideNumberByPieces(data.total_income));
						$('#summary_total_withdraw').html(divideNumberByPieces(data['total_withdraw']));
						$('#summary_procent_withdraw_deposit').css('width', data['procent_withdraw_deposit'] + '%');

						$('#summary_total_keys').html(divideNumberByPieces(data.total_keys));
						$('#summary_total_active_keys').html(divideNumberByPieces(data['total_active_keys']));
						$('#summary_procent_active_keys').css('width', data['procent_active_keys'] + '%');

						$('#summary_total_users').html(divideNumberByPieces(data.total_users));
						$('#summary_total_active_users').html(divideNumberByPieces(data['total_active_users']));
						$('#summary_procent_active_users').css('width', data['procent_active_users'] + '%');
					}

					$('#summary_loader').hide();
				}
			});

		});

		function divideNumberByPieces(x, delimiter) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, delimiter || " ");
		}

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