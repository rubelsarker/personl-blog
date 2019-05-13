<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));

    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories',
            'image'=>'required|mimes:jpeg,png,jpg,bmp'
        ]);
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if(isset($image)){
            // make unique name for image
            $currentDate = carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category directory
            if(!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            //resize image
            $category = Image::make($image)->resize(1600,479)->save($imagename);
            Storage::disk('public')->put('category/'.$imagename,$category);

            //check category slider directory
            if(!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            // resize image for slider
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        }else{
            $imagename = "default.png";
        }
        $category = new Category();
        $category->name = $request->name;
        $category->slug =$slug;
        $category->image =$imagename;
        $category->save();
        Toastr::success('Category Successfully Saved!','Success');
        return redirect()->route('admin.category.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'image'=>'mimes:jpeg,png,jpg,bmp'
        ]);
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $category = Category::find($id);
        if(isset($image)){
            // make unique name for image
            $currentDate = carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category directory
            if(!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            //delete old image
            if(Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }

            //resize image
            $categoryimage = Image::make($image)->resize(1600,479)->save($imagename);
            Storage::disk('public')->put('category/'.$imagename,$categoryimage);

            //check category slider directory
            if(!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //delete old slider image
            if(Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
            // resize image for slider
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        }else{
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug =$slug;
        $category->image =$imagename;
        $category->save();
        Toastr::success('Category Successfully Updated!','Success');
        return redirect()->route('admin.category.index');
    }


    public function destroy($id)
    {
       $category =  Category::find($id);
        //delete old image
        if(Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        //delete old slider image
        if(Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();

        Toastr::success('Category Successfully Delete :)','Success');
        return redirect()->back();
    }
}
