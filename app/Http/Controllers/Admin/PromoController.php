<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Models\Media;

class PromoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$promo = Promo::orderby('id', 'desc')->get();
		return view('admin.promo.index', compact(['promo']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.promo.create');
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
		]);

		$promo = Promo::create([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'public' => $request->get('public') ? true : false,
		]);

		if ($request->hasFile('zip') && $request->file('zip')->isValid()) {
			$promo->addMediaFromRequest('zip')->toMediaCollection('zips');
		}

		return redirect()->route('admin.promo.index');
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
		$promo = Promo::findOrFail($id);
		return view('admin.promo.edit', compact(['promo']));
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
		]);

		$promo = Promo::findOrFail($id);

		$promo->update([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'public' => $request->get('public') ? true : false,
		]);

		if ($request->hasFile('zip') && $request->file('zip')->isValid()) {
			$old = $promo->getMedia('zips')->first();
			$result = $promo->addMediaFromRequest('zip')->toMediaCollection('zips');
			if ($result && $old) {
				$media = Media::find($old->id)->delete();
				$promo->deleteMedia($old->id);
			}
		}

		return redirect()->route('admin.promo.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$promo = Promo::findOrFail($id);
		$promo->delete();
		return redirect()->route('admin.promo.index');
	}
}
