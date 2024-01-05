<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function categories() {
        $categories = Category::all();

        return view('admin.category.category', compact('categories'));
    }

    function add_category(Request $req) {
        $req->validate([
            'category_name'=>'required | unique:categories',
            'category_icon'=>'required',
            'category_icon'=>'image',
        ]);

        $icon = $req->category_icon;
        $extension = $icon->extension();
        $file_name = strtolower(str_replace(' ', '-', $req->category_name)).'_'.random_int(10000, 20000).'.'.$extension;
        Image::make($icon)->save(public_path('uploads/category_icon/').$file_name);

        Category::insert([
            'category_name'=>$req->category_name,
            'category_icon'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('category_added', 'Category Added Successfully!');
    }

    function trash_category() {
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', compact('categories'));
    }

    function edit_category($id) {
        $detail = Category::find($id);

        return view('admin.category.edit', compact('detail'));
    }

    function update_category(Request $req, $id) {
        $req->validate([
            'category_name'=>'required',
            'category_icon'=>'image',
        ]);

        if($req->category_icon == null) {
            Category::find($id)->update([
                'category_name'=>$req->category_name,
            ]);

            return back()->with('category_updated', 'Category update successfully!');
        }else {
            $img = (Category::find($id))->category_icon;
            $location = public_path('uploads/category_icon/'.$img);
            unlink($location);

            $icon = $req->category_icon;
            $extension = $icon->extension();
            $file_name = strtolower(str_replace(' ', '-', $req->category_name)).'_'.random_int(10000, 20000).'.'.$extension;
            Image::make($icon)->save(public_path('uploads/category_icon/').$file_name);

            Category::find($id)->update([
                'category_name'=>$req->category_name,
                'category_icon'=>$file_name,
            ]);

            return back()->with('category_updated', 'Category update successfully!');
        }
    }

    function soft_delete_category($id) {
        Category::find($id)->delete();
        return back()->with('soft_delete', 'Category move to trash!');
    }

    function restore_category($id) {
        Category::onlyTrashed()->find($id)->restore();
        return back()->with('restore', 'Category restored!');
    }

    function trash_delete($id) {
        $file_name = (Category::onlyTrashed()->find($id))->category_icon;
        $location = public_path('uploads/category_icon/'.$file_name);
        unlink($location);

        Category::onlyTrashed()->find($id)->forceDelete();

        SubCategory::where('category_id', $id)->update([
            'category_id'=>1,
        ]);
        return back()->with('trash_delete', 'Category deleted permanently!');
    }

    function checked_trash(Request $req) {
        switch($req->input('btns')) {
            case 'restore':
                foreach($req->category_id as $id) {
                    Category::onlyTrashed()->find($id)->restore();
                }
                
                return back()->with('restore', 'Category restored!');
                
                break;
            
            case 'delete':
                foreach($req->category_id as $id) {
                    $file_name = (Category::onlyTrashed()->find($id))->category_icon;
                    $location = public_path('uploads/category_icon/'.$file_name);
                    unlink($location);
    
                    Category::onlyTrashed()->find($id)->forceDelete();
                }

                return back()->with('trash_delete', 'Category deleted permanently!');

                break;
        }
    }
}
