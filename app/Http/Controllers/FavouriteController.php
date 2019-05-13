<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function add($post){
        $user = Auth::user();
        $isFavourite = $user->favourite_posts()->where('post_id',$post)->count();
        if($isFavourite ==0){
            $user->favourite_posts()->attach($post);
            Toastr::success('Post successfully add to your favourite list :)','Success');
            return redirect()->back();
        }else{
            $user->favourite_posts()->detach($post);
            Toastr::success('Post successfully remove to your favourite list :)','Success');
            return redirect()->back();
        }
    }
}
