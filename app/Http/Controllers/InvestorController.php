<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Setting;
use App\Models\InvestorPayment;
use App\Models\User;

use App\Models\Payment;
use App\Models\Account;
use App\Models\Binar;
use Carbon\Carbon;

class InvestorController extends Controller
{
	public function withdraw_modal()
	{
		$investor_fee = Setting::where('key', 'investor_fee')->pluck('value')->first();
		$card_investor_fee = Setting::where('key', 'card_investor_fee')->pluck('value')->first();
		return view('investor.modals.withdraw', ['investor_fee'=>$investor_fee, 'card_investor_fee'=>$card_investor_fee]);
	}

	public function procent($a, $b)
	{
		if ($a == 0) {
			return $b == 0 ? 0 : 100;
		} else {
			return $b == 0 ? 100 : ($b / $a - 1) * 100;
		}
	}
	

	public function mask($str, $first, $last) {
		$len = strlen($str);
		$toShow = $first + $last;
		return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat("*", $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
	}
	
	public function mask_email($email) {
		$mail_parts = explode("@", $email);
		$domain_parts = explode('.', $mail_parts[1]);
	
		$mail_parts[0] = $this->mask($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
		$mail_parts[1] = implode('.', $domain_parts);
	
		return implode("@", $mail_parts);
	}


	public function dashboard()
	{
			// Оборот
			$total_turnover = (-1) * Payment::where('status', 1)->whereIn('type', [4, 5, 6])->sum('amount');
			$monthly_turnover = (-1) * Payment::where('status', 1)->whereIn('type', [4, 5, 6])->where('confirm_date', '>=', date('Y-m-01'))->sum('amount');
			$monthly_turnover_previous = (-1) * Payment::where('status', 1)->whereIn('type', [4, 5, 6])->where('confirm_date', '>=', date("Y-m-01", strtotime("-1 month")))->where('confirm_date', '<=', date("Y-m-t", strtotime("-1 month")))->sum('amount');
			$procent_turnover = $this->procent($monthly_turnover_previous, $monthly_turnover);
	
			// Пополнение - вывод
			$total_income = Payment::where('status', 1)->where('type', 1)->sum('amount') - Payment::where('status', 1)->where('type', 2)->sum('amount');
			$monthly_income = Payment::where('status', 1)->where('type', 1)->where('confirm_date', '>=', date('Y-m-01'))->sum('amount') - Payment::where('status', 1)->where('type', 2)->where('confirm_date', '>=', date('Y-m-01'))->sum('amount');
			$monthly_income_previous = Payment::where('status', 1)->where('type', 1)->where('confirm_date', '>=', date("Y-m-01", strtotime("-1 month")))->where('confirm_date', '<=', date("Y-m-t", strtotime("-1 month")))->sum('amount') - Payment::where('status', 1)->where('type', 2)->where('confirm_date', '>=', date("Y-m-01", strtotime("-1 month")))->where('confirm_date', '<=', date("Y-m-t", strtotime("-1 month")))->sum('amount');
			$procent_income = $this->procent($monthly_income_previous, $monthly_income);
	
			// Активированные роботы
			// where('date_online', '>=', date("Y-m-d H:i:s", time() - 86400))
			$total_activated_robots = Account::where('activated', 1)->count();
			$monthly_activated_robots = Account::where('activated', 1)->where('date_activation', '>=', date('Y-m-01'))->count();
			$monthly_activated_robots_previous = Account::where('activated', 1)->where('date_activation', '>=', date("Y-m-01", strtotime("-1 month")))->where('date_activation', '<=', date("Y-m-t", strtotime("-1 month")))->count();
			$procent_activated_robots = $this->procent($monthly_activated_robots_previous, $monthly_activated_robots);
	
			// Активные пользователи
			$total_active_users = Binar::count(); // where('activated', 1)->
			$monthly_active_users = Binar::where('created_at', '>=', date('Y-m-01'))->count();
			$monthly_active_users_previous = Binar::where('created_at', '>=', date("Y-m-01", strtotime("-1 month")))->where('created_at', '<=', date("Y-m-t", strtotime("-1 month")))->count();
			$procent_active_users = $this->procent($monthly_active_users_previous, $monthly_active_users);
	
	
			// График Доходности компании по неделям (Пополнение - вывод)
			$payments_graph = Payment::where('status', 1)->whereIn('type', [4, 5, 6])->orderBy('confirm_date') // это поле в БД для сортировки
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
	
							$amount = (-1) * $payment->amount;
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
	
	
			$payments_last = Payment::where('status', 1)->where('type', 1)->orderBy('confirm_date', 'DESC')->limit(10)->get();
			foreach ($payments_last as $key => $value) {
				$value->user->email =	$this->mask_email($value->user->email);
			}
	
			$users_last = User::orderBy('created_at', 'DESC')->limit(10)->get();
	
			foreach ($users_last as $key => $value) {
				$value->email =	$this->mask_email($value->email);
			}
	
			$summary = $this->summary();
	
			return view('investor.dashboard', compact(['total_turnover', 'monthly_turnover', 'procent_turnover', 'total_income', 'monthly_income', 'procent_income', 'total_activated_robots', 'monthly_activated_robots', 'procent_activated_robots', 'total_active_users', 'monthly_active_users', 'procent_active_users', 'graph', 'payments_last', 'users_last', 'summary']));
	}

	public function summary($period = 'all', $format = 'array')
	{
		$summary = [];

		// Пополнение вывод
		switch ($period) {
			case 'all':
				$total_deposit = Payment::where('status', 1)->where('type', 1)->sum('amount');
				$total_withdraw = Payment::where('status', 1)->where('type', 2)->sum('amount');
				$total_income = $total_deposit + $total_withdraw;
				break;
			case 'month':
				$total_deposit = Payment::where('status', 1)->where('type', 1)->where('confirm_date', '>=', date('Y-m-01'))->sum('amount');
				$total_withdraw = Payment::where('status', 1)->where('type', 2)->where('confirm_date', '>=', date('Y-m-01'))->sum('amount');
				$total_income = $total_deposit + $total_withdraw;
				break;
		}
		$procent_withdraw_deposit = round($this->procent($total_income, $total_withdraw), 2); // 100 + 

		// Ключей / Активных ключей
		switch ($period) {
			case 'all':
				$total_keys = Account::count();
				$total_active_keys = Account::where('activated', 1)->count();
				break;
			case 'month':
				$total_keys = Account::where('date', '>=', date('Y-m-01'))->count();
				$total_active_keys = Account::where('activated', 1)->where('date_activation', '>=', date('Y-m-01'))->count();
				break;
		}
		$procent_active_keys = round($this->procent($total_keys, $total_active_keys), 2); // 100 + 
		// echo $procent_active_keys;
		// exit();

		// Пользователей / Активных пользователей
		switch ($period) {
			case 'all':
				$total_users = User::count();
				$total_active_users = Binar::count(); // where('activated', 1)->
				break;
			case 'month':
				$total_users = User::where('created_at', '>=', date('Y-m-01'))->count();
				$total_active_users = Binar::where('created_at', '>=', date('Y-m-01'))->count();
				break;
		}
		$procent_active_users = round($this->procent($total_users, $total_active_users), 2); // 100 + 

		// Бинар / Активированных бинаров
		$total_binars = Binar::count();
		$total_active_binars = Binar::where('activated', 1)->count();
		$procent_active_binars = round($this->procent($total_binars, $total_active_binars), 2); // 100 + 

		// Всего баллов / Баллов выплачено
		$total_points = 0;
		$total_points_paid = 0;
		$total_points_lost = 0;
		$payments_ = Payment::where('type', 10)->get();
		if (!empty($payments_))
			foreach ($payments_ as $payment_) {
				$total_points += $payment_->amount;
				$total_points_paid += $payment_->amount;
				if ($payment_->user) {
					$total_points_lost += $payment_->user->lost_money;
					if ($payment_->user->binar) {
						$total_points += $payment_->user->binar->left_pv + $payment_->user->binar->right_pv;
						$total_points_lost += $payment_->user->binar->left_lost + $payment_->user->binar->right_lost;
					}
				}
			}
		$procent_points_paid = round($this->procent($total_points, $total_points_paid), 2); // 100 + 
		$procent_points_lost = round($this->procent($total_points, $total_points_lost), 2); // 100 + 



		////
		$summary = [
			'success' => true,
			'total_income' => $total_income,
			'total_withdraw' => $total_withdraw,
			'procent_withdraw_deposit' => $procent_withdraw_deposit,
			'period' => $period,
			'total_keys' => $total_keys,
			'total_active_keys' => $total_active_keys,
			'procent_active_keys' => $procent_active_keys,
			'total_users' => $total_users,
			'total_active_users' => $total_active_users,
			'procent_active_users' => $procent_active_users,
			'total_binars' => $total_binars,
			'total_active_binars' => $total_active_binars,
			'procent_active_binars' => $procent_active_binars,
			'total_points' => $total_points,
			'total_points_paid' => $total_points_paid,
			'procent_points_paid' => $procent_points_paid,
			'total_points_lost' => $total_points_lost,
			'procent_points_lost' => $procent_points_lost
		];

		if ($format == 'ajax') {
			return json_encode($summary);
		}
		return $summary;

		// Первая строка Пополнение /Вывод
		// Основывается на сумме payments->amount WHERE type=1 AND status=1 и сумме payments->amount WHERE type=2 AND status=1 (отрезок времени по created_at)

	}
	
	public function index()
	{
		$payments = auth()->user()->investor_payments;
		return view('investor.finances', compact(['payments']));
	}

	public function withdraw(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'amount' => ['required', 'integer'],
			'wallet' => ['required'],
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		$userId = auth()->user()->id;
		$req = InvestorPayment::where('user_id', $userId)
			->where('type', 2)
			->where('status', 0)
			->count();

		if ($req) {
			return response()->json(['errors' => [
				'other' => [
					__("Wait, please! You already have pending withdrawal requests")
				]
			]]);
		}

		if (auth()->user()->balance() < $request->get('amount')) {
			return response()->json(['errors' => [
				'other' => [
					__("Insufficient funds on the user's balance")
				]
			]]);
		}

		if (empty(auth()->user()->phone)) {
			return response()->json(['errors' => [
				'other' => [
					__("Confirm your phone number please")
				]
			]]);
		}

		$code = auth()->user()->generate_code();

		if ($code) {
			$request->session()->put('code', $code);
			$request->session()->put('amount', $request->get('amount'));
			$request->session()->put('wallet', $request->get('wallet'));
			$request->session()->put('payment_system', $request->get('payment_system'));
			
			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("You can request a second code in a minute")
				]
			]]);
		}
	}


	public function withdraw_go(Request $request)
	{

		$user = auth()->user();
		$userId = $user->id;

		$code = $user->phone_code;
		$validator = Validator::make($request->all(), [
			'code' => ["required", "code_correct", "code_live", "code_count"], //  new PhoneCodeCount , new PhoneCodeCorrect, new PhoneCodeLive  
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()]);
		}

		User::whereId($userId)->update([
			'phone_code_error' => NULL,
			'phone_code' => NULL,
			'phone_code_at' => NULL,
		]);

		

		if($request->session()->get('payment_system') == 1){
			$finance_fee = Setting::where('key', 'card_investor_fee')->pluck('value')->first();
			$fee = $request->session()->get('amount') * $finance_fee / 100;
		}
		else{
			$investor_fee = Setting::where('key', 'investor_fee')->pluck('value')->first();
			$fee = $request->session()->get('amount') * $investor_fee / 100;
		}	
		 
		$payment = InvestorPayment::create([
			'user_id' => $userId,
			'created_at' => date('Y-m-d H:i:s'),
			'type' => 2,
			'status' => 0, 
			'amount' => $request->session()->get('amount'),
			'fee' => $fee,
			'payment_system' => $request->session()->get('payment_system'),
			'payer' => $request->session()->get('wallet'),
			'payee' => '',
			'batcn' => '',
			'confirm_date' => NULL
		]);

		User::whereId($userId)->update(['purse' => $request->session()->get('wallet')]);

		if ($payment) {
			return response()->json(['success' => true]);
		} else {
			return response()->json(['errors' => [
				'other' => [
					__("Sorry, an unknown error has occurred. Repeat the operation")
				]
			]]);
		}
	}
}
