<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

use App\Models\Robot;

class RobotsController extends Controller
{
	public function index()
	{
		$robots = Robot::where('public', 1)->where('lang', app()->getLocale())->orderBy('created_at', 'DESC')->get();
		return view('robots', compact(['robots']));
	}
}
