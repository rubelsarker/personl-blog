<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Notifications\NewAuthorPost;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function index()
    {
        $posts = Auth::User()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create',compact('categories','tags'));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'title' =>'required',
            'image' =>'required',
            'categories' =>'required',
            'tags' =>'required',
            'body' =>'required',
        ]);
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image)){
            // make unique name for image
            $currentDate = carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category directory
            if(!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }
            //resize image
            $postImage = Image::make($image)->resize(1600,1066)->save($imagename);
            Storage::disk('public')->put('post/'.$imagename,$postImage);

        }else{
            $imagename = "default.png";
        }
        $post = new Post();
        $post->user_id=Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imagename;
        $post->body = $request->body;
        if(isset($request->status)){
            $post->status = true;

        }else{
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $users = User::where('role_id','1')->get();
        Notification::send($users,new NewAuthorPost($post));
        Toastr::success('Post Successfully Saved!','Success');
        return redirect()->route('author.post.index');
    }

    public function show(Post $post)
    {
        if($post->user_id != Auth::id() ){
            Toastr::error('You are nor authorized to access this post :)','Error');
            return redirect()->back();
        }
        return view('author.post.show',compact('post'));
    }


    public function edit(Post $post)
    {
        if($post->user_id != Auth::id() ){
            Toastr::error('You are nor authorized to access this post :)','Error');
            return redirect()->back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit',compact('categories','tags','post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title' =>'required',
            'image' =>'image',
            'categories' =>'required',
            'tags' =>'required',
            'body' =>'required',
        ]);
        if($post->user_id != Auth::id() ){
            Toastr::error('You are nor authorized to access this post :)','Error');
            return redirect()->back();
        }
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image)){
            // make unique name for image
            $currentDate = carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category directory
            if(!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }
            //delete old image
            if(Storage::disk('public')->exists('post/'.$post->image)){
                Storage::disk('public')->delete('post/'.$post->image);
            }
            //resize image
            $postImage = Image::make($image)->resize(1600,1066)->save($imagename);
            Storage::disk('public')->put('post/'.$imagename,$postImage);

        }else{
            $imagename = $post->image;
        }
        $post->user_id=Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imagename;
        $post->body = $request->body;
        if(isset($request->status)){
            $post->status = true;

        }else{
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);
        Toastr::success('Post Successfully Updated!','Success');
        return redirect()->route('author.post.index');
    }

    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id() ){
            Toastr::error('You are nor authorized to access this post :)','Error');
            return redirect()->back();
        }
        //delete old image
        if(Storage::disk('public')->exists('post/'.$post->image)){
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post Successfully Delete :)','Success');
        return redirect()->back();
    }
}
