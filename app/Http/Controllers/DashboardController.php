<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Binar;
use App\Models\User;
use App\Models\Article;
use Carbon\Carbon;

class DashboardController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */

	public function procent($a, $b)
	{
		if ($a == 0) {
			return $b == 0 ? 0 : 100;
		} else {
			return $b == 0 ? 100 : ($b / $a - 1) * 100;
		}
	}

	public function index()
	{
		$userId = auth()->user()->id;

		// Заработок
		$total_salary = Payment::where('status', 1)->where('user_id', $userId)->whereIn('type', [7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->sum('amount');
		$monthly_salary = Payment::where('status', 1)->where('user_id', $userId)->whereIn('type', [7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->where('confirm_date', '>=', date('Y-m-01'))->sum('amount');
		$monthly_salary_previous = Payment::where('status', 1)->where('user_id', $userId)->whereIn('type', [7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->where('confirm_date', '>=', date("Y-m-01", strtotime("-1 month")))->where('confirm_date', '<=', date("Y-m-t", strtotime("-1 month")))->sum('amount');
		$procent_salary = $this->procent($monthly_salary_previous, $monthly_salary);

		// Продажи роботов
		$total_robot_sales = Account::where('activated', 1)->where('user_id', '!=', 'manager_id')->count();
		$monthly_robot_sales = Account::where('activated', 1)->where('user_id', '!=', 'manager_id')->where('date_activation', '>=', date('Y-m-01'))->count();
		$monthly_robot_sales_previous = Account::where('activated', 1)->where('user_id', '!=', 'manager_id')->where('date_activation', '>=', date("Y-m-01", strtotime("-1 month")))->where('date_activation', '<=', date("Y-m-t", strtotime("-1 month")))->count();
		$procent_robot_sales = $this->procent($monthly_robot_sales_previous, $monthly_robot_sales);

		// Активные партнеры
		$total_active_users = Binar::join('users', 'users.id', '=', 'binar.user_id')->where('users.referrer_id', $userId)->count();
		$monthly_active_users = Binar::join('users', 'users.id', '=', 'binar.user_id')->where('users.referrer_id', $userId)->where('binar.created_at', '>=', date('Y-m-01'))->count();
		$monthly_active_users_previous = Binar::join('users', 'users.id', '=', 'binar.user_id')->where('users.referrer_id', $userId)->where('binar.created_at', '>=', date("Y-m-01", strtotime("-1 month")))->where('binar.created_at', '<=', date("Y-m-t", strtotime("-1 month")))->count();
		$procent_active_users = $this->procent($monthly_active_users_previous, $monthly_active_users);


		// График Доходности компании по неделям (Пополнение - вывод)
		$payments_graph = Payment::where('status', 1)->where('user_id', $userId)->whereIn('type', [7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->orderBy('confirm_date') // это поле в БД для сортировки
			->get()
			->groupBy(function ($events) {
				$week_number = Carbon::parse($events->confirm_date)->format('W');
				$year = Carbon::parse($events->confirm_date)->format('Y');

				$date = date('d.m.Y', ($week_number - 1) * 7 * 86400 + strtotime('1/1/' . $year) - date('w', strtotime('1/1/' . $year)) * 86400 + 86400);
				return $date;
			});


		$tmp = [];
		if (!empty($payments_graph))
			foreach ($payments_graph as $week => $payments) {
				if (!empty($payments))
					foreach ($payments as $payment) {
						if (!array_key_exists($week, $tmp)) {
							$tmp[$week] = 0;
						}

						$amount = $payment->amount;
						$tmp[$week] += $amount;
					}
			}

		$tmp2 = [];
		if (!empty($tmp)) {
			$start_week = key($tmp);
			$end_week = date('d.m.Y', time() - (date('N', time()) - 1) * 86400);

			$week = $start_week;
			while (strtotime($week) <= strtotime($end_week)) {
				if (array_key_exists($week, $tmp)) {
					$tmp2[$week] = $tmp[$week];
				} else {
					$tmp2[$week] = 0;
				}
				$week = date('d.m.Y', strtotime($week) + 7 * 24 * 60 * 60);
			}
		}

		$graph = ['labels' => [], 'values' => []];
		if (!empty($tmp2))
			foreach ($tmp2 as $label => $value) {
				$graph['labels'][] = $label;
				$graph['values'][] = $value;
			}


		$payments_last = Payment::where('status', 1)->where('user_id', $userId)->whereIn('type', [7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->orderBy('confirm_date', 'DESC')->limit(10)->get();
		$users_last = User::where('referrer_id', $userId)->orderBy('created_at', 'DESC')->limit(10)->get();


		$articles = Article::where('public', 1)->where('lang', app()->getLocale())->orderBy('created_at', 'DESC')->limit(5)->get();

		return view('dashboard', compact(['total_salary', 'monthly_salary', 'procent_salary', 'total_robot_sales', 'monthly_robot_sales', 'procent_robot_sales', 'total_active_users', 'monthly_active_users', 'procent_active_users', 'graph', 'payments_last', 'users_last', 'articles']));
	}
}
