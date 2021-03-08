<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Binar;
use App\Models\BinarDirection;

class TeamController extends Controller
{

	public function update_status(Request $request)
	{		
		$balance = auth()->user()->balance();
		if($request->post('sum') > $balance){
		$alert = __('Error! There is not enough money on the balance to activate the package');	
		return redirect()->back()->with('status', 'error')->with('alert', $alert);
		}
		$user = auth()->user();
		$userId = $user->id;
		$hash = md5($userId . $request->post('update') . "uh4532b346bcmdnfs");

		$activate = file_get_contents("https://api.magnumsk.com/upgrade/?user_id=" . $userId . "&type=" . $request->post('update') . "&hash=" . $hash);
		$activate = json_decode($activate, true);
		
		$alert = __('Thanks! Activation was successful');

		return redirect()->back()->with('status', 'success')->with('alert', $alert);
	}

	public function activate(Request $request, $type)
	{
		if (!in_array($type, [1, 2, 3])) {
			abort(404);
		}

		$userId = auth()->user()->id;
		$hash = md5($userId . $type . "uh4532b346bcmdnfs");
		// echo "https://api.magnumsk.com/binar-activation/?user_id=" . $userId . "&type=" . $type . "&hash=" . $hash;
		// exit();
		$activate = file_get_contents("https://api.magnumsk.com/binar-activation/?user_id=" . $userId . "&type=" . $type . "&hash=" . $hash);
		$activate = json_decode($activate, true);

		$alert = '';

		switch ($activate['status']) {
			case 'success':
				$alert = __('Thanks! Activation was successful');
				break;
			case 'error':
				if (array_key_exists('error', $activate)) {
					switch ($activate['error']) {
						case 'user-not-found':
							$alert = __('Error! User is not found');
							break;
						case 'already-activated':
							$alert = __('Error! Affiliate program is already activated');
							break;
						case 'user-not-activated':
							$alert = __('Error! User not activated');
							break;
						case 'referrer-not-activated':
							$alert = __('Error! Your curator is not activated');
							break;
						case 'balance-error':
							$alert = __('Error! There is not enough money on the balance to activate the package');
							break;
						case 'type-not-correct':
							$alert = __('Error! Package specified incorrectly');
							break;
						default:
							$alert = $activate['error'];
							break;
					}
				} else {
					$alert = $activate['status'];
				}
				break;
		}

		return redirect()->back()->with('status', $activate['status'])->with('alert', $alert);
	}

	private function check_user($check_user_id)
	{
		$current_user_id = auth()->user()->id;

		$binar = Binar::where('user_id', $check_user_id)->first();
		$i = 0;
		if ($binar) {
			while ($i < 14) {
				if ($binar) {
					if ($binar->user_id == $current_user_id) return true;
					$check_user_id = $binar->above;
					$binar = Binar::where('user_id', $check_user_id)->first();
				}
				$i++;
			}
		}
		return false;

		// $query = "SELECT id_user,above FROM binar WHERE id=$check_user_id";
		// $check_user_id = $myrow['above'];
		// while($i<14) {
		//   if($myrow['id_user'] == $user->id) return true;
		//   $check_user_id = $myrow['above'];
		//   $query = "SELECT id_user,above FROM binar WHERE id=$check_user_id";
		// }
		// return false;
	}

	public function scheme(Request $request)
	{
		$userId = $request->get('user');

		if ($userId and !$this->check_user($userId)) {
			// return redirect(route('team'));
		}

		if ($userId) {
			$user = User::findOrFail($userId);
		} else {
			$user = auth()->user();
		}

		return view('team', compact(['user']));
	}

	public function set_redirect(Request $request)
	{
		$userId = auth()->user()->id;
		$binarId = $request->get('binar_id');

		$binar = Binar::find($binarId);
		if ($binar and $this->check_user($binar->user_id)) {

			$dir = BinarDirection::where('user_id', $userId)
				->where('ceil', $binarId)
				->first();

			if (!$dir) {
				$dir = BinarDirection::create([
					'user_id' => $userId,
					'ceil' => $binarId,
					'executed' => 0,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		return back();
	}

	public function remove_redirect(Request $request)
	{
		$userId = auth()->user()->id;
		$binarId = $request->get('binar_id');

		$binar = Binar::find($binarId);
		if ($binar and $this->check_user($binar->user_id)) {
			$dir = BinarDirection::where('user_id', $userId)
				->where('ceil', $binarId)
				->first();

			if ($dir) {
				$dir->delete();
			}
		}

		return back();
	}
}
