<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

use Spatie\MediaLibrary\Models\Media;

class LicensesController extends Controller
{
	public function index()
	{
		$accounts = Account::orderby('date_activation', 'desc')->get();
		return view('admin.licenses.index', compact(['accounts']));
	}

	public function to_appoint(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => ["required", "exists:accounts,id"],
			'number' => ["required", "numeric"],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->all()]);
		}

		$id = $request->id;
		$update = Account::whereId($id)->update(['number' => $request->number]);
		if (!$update) {
			return response()->json(['error' => __('The account number has not been saved. try again')]);
		}

		return response()->json(['success' => true]);
	}
}
