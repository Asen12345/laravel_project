<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

class NewsController extends Controller
{
	public function index()
	{
		$articles = Article::where('public', 1)->where('lang', app()->getLocale())->orderBy('created_at', 'DESC')->get();
		return view('news', compact(['articles']));
	}


	public function show(Request $request, Article $article)
	{
		return view('new', compact(['article']));
	}
}
