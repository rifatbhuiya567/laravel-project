<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    function sub_categories() {
        $categories = Category::all();

        return view('admin.sub_category.sub_category', [
            'categories'=>$categories,
        ]);
    }

    function add_sub_category(Request $request) {
        $request->validate([
            'category'=>'required',
            'sub_category'=>'required',
            'sub_category_icon'=>['required', 'mimes:png,jpg'],
        ]);

        if(SubCategory::where('category_id', $request->category)->where('sub_category_name', $request->sub_category)->exists()) {
            return back()->with('not_exist', 'This sub category name already taken in this category!');
        }else {
            $icon = $request->sub_category_icon;
            $extension = $icon->extension();
            $file_name = strtolower(str_replace(' ', '-', $request->sub_category)).'_'.random_int(1000, 2000).'.'.$extension;
            echo $file_name;

            Image::make($icon)->save(public_path('uploads/sub_category_icon/'.$file_name));

            SubCategory::insert([
                'category_id'=>$request->category,
                'sub_category_name'=>$request->sub_category,
                'sub_category_icon'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);

            return back()->with('sub_category_added', 'Sub Category Added Successfully!');
        }
    }

    function edit_sub_category($id) {
        $categories = Category::all();
        $subcategories = SubCategory::find($id);
        return view('admin.sub_category.edit', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function update_sub_category(Request $request, $id) {
        $request->validate([
            'category'=>'required',
            'sub_category'=>'required',
            'sub_category_icon'=>'mimes:png,jpg',
        ]);

        if($request->sub_category_icon == null) {
            SubCategory::find($id)->update([
                'category_id'=>$request->category,
                'sub_category_name'=>$request->sub_category,
                'created_at'=>Carbon::now(),
            ]);

            return back()->with('sub_updated', 'Sub Category Updated!');
        }else {
            $img = SubCategory::find($id)->sub_category_icon;
            $location = public_path('uploads/sub_category_icon/'.$img);
            unlink($location);

            $icon = $request->sub_category_icon;
            $extension = $icon->extension();
            $file_name = strtolower(str_replace(' ', '-', $request->sub_category)).'_'.random_int(1000, 2000).'.'.$extension;
            echo $file_name;

            Image::make($icon)->save(public_path('uploads/sub_category_icon/'.$file_name));

            SubCategory::find($id)->update([
                'category_id'=>$request->category,
                'sub_category_name'=>$request->sub_category,
                'sub_category_icon'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);

            return back()->with('sub_updated', 'Sub Category Updated!');
        }

    }

    function delete_sub_category($id) {
        $img = SubCategory::find($id)->sub_category_icon;
        $location = public_path('uploads/sub_category_icon/'.$img);
        unlink($location);

        SubCategory::find($id)->delete();

        return back()->with('sub_deleted', 'Sub Category Deleted!');
    }
}
