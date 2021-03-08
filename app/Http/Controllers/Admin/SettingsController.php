<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$settings = Setting::all();
		// print_r($settings);
		// exit();
		return view('admin.settings.index', compact(['settings']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.settings.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'key' => ["required"],
			'value' => ["required"],
		]);

		$setting = Setting::create([
			'key' => $request->get('key'),
			'value' => $request->get('value')
		]);

		return redirect()->route('admin.settings.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	// public function show($id)
	// {
	// 	//
	// }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$setting = Setting::findOrFail($id);
		return view('admin.settings.edit', compact(['setting']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'key' => ["required"],
			'value' => ["required"],
		]);

		$setting = Setting::findOrFail($id);

		$setting->update([
			'key' => $request->get('key'),
			'value' => $request->get('value'),
		]);

		return redirect()->route('admin.settings.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$setting = Setting::findOrFail($id);
		$setting->delete();
		return redirect()->route('admin.settings.index');
	}
}
