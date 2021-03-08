<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RobotSetting;
use App\Models\Robot;
use Illuminate\Support\Facades\Validator;

class RobotSettingsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Robot $robot)
	{
		$settings = $robot->settings;
		return view('admin.robots.settings.index', compact(['settings', 'robot']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Robot $robot)
	{
		return view('admin.robots.settings.create', compact(['robot']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Robot $robot)
	{
		$request->validate([
			'name' => ["required"],
			'symbol' => ["required"],
		]);

		$setting = RobotSetting::create([
			'name' => $request->get('name'),
			'symbol' => $request->get('symbol'),
			'active' => $request->get('active') ? true : false,
			'robot_id' => $robot->id
		]);

		return redirect()->route('admin.robot-settings.index', $setting->robot);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$setting = RobotSetting::findOrFail($id);
		return view('admin.robots.settings.edit', compact(['setting']));
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
			'name' => ["required"],
			'symbol' => ["required"],
		]);

		$setting = RobotSetting::findOrFail($id);

		$setting->update([
			'name' => $request->get('name'),
			'symbol' => $request->get('symbol'),
			'active' => $request->get('active') ? true : false,
		]);

		return redirect()->route('admin.robot-settings.index', $setting->robot);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$setting = RobotSetting::findOrFail($id);
		$robot = $setting->robot;
		$setting->delete();
		return redirect()->route('admin.robot-settings.index', $robot);
	}
}
