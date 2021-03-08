<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RobotSetting;
use App\Models\RobotSettingParametr;
// use App\Models\Robot;

use Illuminate\Support\Facades\Validator;

class RobotSettingParametrsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(RobotSetting $setting)
	{
		$parametrs = $setting->parametrs;
		return view('admin.robots.settings.parametrs.index', compact(['parametrs', 'setting']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(RobotSetting $setting)
	{
		return view('admin.robots.settings.parametrs.create', compact(['setting']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, RobotSettingParametr $setting)
	{
		$request->validate([
			'index' => ["required"],
			'value' => ["required"],
		]);

		$parametr = RobotSettingParametr::create([
			'index' => $request->get('index'),
			'value' => $request->get('value'),
			'id_set' => $setting->id
		]);

		return redirect()->route('admin.robot-setting-parametrs.index', $setting);
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
		$parametr = RobotSettingParametr::findOrFail($id);
		return view('admin.robots.settings.parametrs.edit', compact(['parametr']));
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
			'index' => ["required"],
			'value' => ["required"],
		]);

		$parametr = RobotSettingParametr::findOrFail($id);

		$parametr->update([
			'index' => $request->get('index'),
			'value' => $request->get('value'),
		]);

		return redirect()->route('admin.robot-setting-parametrs.index', $parametr->setting);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$parametr = RobotSettingParametr::findOrFail($id);
		$setting = $parametr->setting;
		$parametr->delete();
		return redirect()->route('admin.robot-setting-parametrs.index', $setting);
	}
}
