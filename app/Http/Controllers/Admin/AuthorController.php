<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index(){
         $authors = User::authors()
             ->withCount('posts')
             ->withCount('comments')
             ->withCount('favourite_posts')
             ->get();
         return view('admin.authors',compact('authors'));
    }
    public function destroy($id){
        User::finrOrFail($id)->delete();
        Toastr::success('Author Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
