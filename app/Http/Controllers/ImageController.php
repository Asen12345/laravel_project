<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Promo;
use Illuminate\Support\Facades\Hash;

use Spatie\MediaLibrary\Models\Media;

class ImageController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
    }
    
	public function getImage($id)
	{
        $user =	User::findOrFail($id);
        if($user->getMedia('avatars')->first()){
        $user = $user->getMedia('avatars')->first()->getUrl('thumb');
        $user = substr_replace($user, '', 0, 4);
        $user = 'https' . $user;
      //  $src = '/storage/'. $user['id'] .'/conversions/' . $user['file_name'] . '';
      //  $src = str_replace("\\/", "/", $src);
        }
        else{
            $user = asset('theme/img/boy.png');
        }
		return $user;
    }
}