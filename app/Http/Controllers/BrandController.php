<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand() {
        $brands = Brand::all();

        return view('admin.brand.brand', [
            'brands'=>$brands,
        ]);
    }

    function add_brand(Request $request) {
        $request->validate([
            'brand_name'=>'required',
            'brand_image'=>['required', 'mimes:png,jpg'],
        ]);

        $image = $request->brand_image;
        $extension = $image->extension();
        $file_name = strtolower(str_replace(' ', '-', $request->brand_name)).'_'.random_int(100, 1000).'.'.$extension;

        Image::make($image)->save(public_path('uploads/brand_images/').$file_name);

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_image'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('add_brand', 'Brand Added Successfully!');
    }

    function delete_brand($id) {
        $img = Brand::find($id)->brand_image;
        $location = public_path('uploads/brand_images/'.$img);
        unlink($location);

        Brand::find($id)->delete();

        return back()->with('brand_deleted', 'Brand delete successfully!');
    }
}
