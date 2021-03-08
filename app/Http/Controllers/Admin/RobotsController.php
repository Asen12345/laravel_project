<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Robot;
use App\Models\RobotSetting;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Models\Media;

class RobotsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$robots = Robot::orderby('created_at', 'desc')->get();
		return view('admin.robots.index', compact(['robots']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.robots.create');
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
			'title' => ["required"],
			'lang' => ["required"],
			'description' => ["required"],
			'version' => ["required"]
		]);

		$robot = Robot::create([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'description' => $request->get('description'),
			'public' => $request->get('public') ? true : false,
			'version' => $request->get('version')
		]);

		if ($request->hasFile('image') && $request->file('image')->isValid()) {
			$robot->addMediaFromRequest('image')->toMediaCollection('images');
		}

		if ($request->hasFile('zip') && $request->file('zip')->isValid()) {
			$robot->addMediaFromRequest('zip')->toMediaCollection('zips');
		}

		return redirect()->route('admin.robots.index');
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
		$robot = Robot::findOrFail($id);
		return view('admin.robots.edit', compact(['robot']));
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
			'title' => ["required"],
			'lang' => ["required"],
			'description' => ["required"],
			'version' => ["required"]
		]);

		$robot = Robot::findOrFail($id);

		$robot->update([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'description' => $request->get('description'),
			'public' => $request->get('public') ? true : false,
			'version' => $request->get('version')
		]);

		if ($request->hasFile('zip') && $request->file('zip')->isValid()) {
			$old = $robot->getMedia('zips')->first();
			$result = $robot->addMediaFromRequest('zip')->toMediaCollection('zips');
			if ($result && $old) {
				$media = Media::find($old->id)->delete();
				$robot->deleteMedia($old->id);
			}
		}

		if ($request->hasFile('image') && $request->file('image')->isValid()) {
			$old = $robot->getMedia('images')->first();
			$result = $robot->addMediaFromRequest('image')->toMediaCollection('images');
			if ($result && $old) {
				$media = Media::find($old->id)->delete();
				$robot->deleteMedia($old->id);
			}
		}

		return redirect()->route('admin.robots.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$robot = Robot::findOrFail($id);
		$robot->delete();
		return redirect()->route('admin.robots.index');
	}
}
