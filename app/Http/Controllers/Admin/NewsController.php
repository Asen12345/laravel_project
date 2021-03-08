<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Models\Media;

class NewsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$news = Article::orderby('created_at', 'desc')->get();
		return view('admin.news.index', compact(['news']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.news.create');
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
			'text' => ["required"],
		]);

		$article = Article::create([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'description' => $request->get('description'),
			'text' => $request->get('text'),
			'public' => $request->get('public') ? true : false,
		]);

		if ($request->hasFile('image') && $request->file('image')->isValid()) {
			$article->addMediaFromRequest('image')->toMediaCollection('images');
		}

		return redirect()->route('admin.news.index');
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
		$article = Article::findOrFail($id);
		return view('admin.news.edit', compact(['article']));
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
			'text' => ["required"],
		]);

		$article = Article::findOrFail($id);

		$article->update([
			'title' => $request->get('title'),
			'lang' => $request->get('lang'),
			'description' => $request->get('description'),
			'text' => $request->get('text'),
			'public' => $request->get('public') ? true : false,
		]);

		if ($request->hasFile('image') && $request->file('image')->isValid()) {
			$old = $article->getMedia('images')->first();
			$result = $article->addMediaFromRequest('image')->toMediaCollection('images');
			if ($result && $old) {
				$media = Media::find($old->id)->delete();
				$article->deleteMedia($old->id);
			}
		}

		return redirect()->route('admin.news.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$article = Article::findOrFail($id);
		$article->delete();
		return redirect()->route('admin.news.index');
	}
}
