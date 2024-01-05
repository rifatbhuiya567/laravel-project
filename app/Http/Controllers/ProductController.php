<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\SubCategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function product() {
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
        $tags = Tag::all();

        return view('admin.product.product', [
            'categories'=>$categories,
            'sub_categories'=>$sub_categories,
            'brands'=>$brands,
            'tags'=>$tags,
        ]);
    }

    function subcategory(Request $request) {
        $str = '<option value="">Select sub category</option>';
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();

        foreach($subcategories as $subcategory) {
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->sub_category_name.'</option>';
        }
        echo $str;
    }

    function add_product(Request $request) {
        $request->validate([
            'category'=>'required',
            'sub_category'=>'required',
            'brand'=>'required',
            'product_name'=>'required',
            'product_price'=>'required',
            'product_image'=>[
                'required',
                'image'
            ],
            'short_description'=>'required',
        ]);

        if($request->gallery_images) {
            $remove = ["*", "@", "~", "!", "#", "$", "%", "^", "&", "(", ")", "+", "{", "}", "[", "]", '"', "'", "|", "/", ":", ";", "<", ">", "?", '`', '-', ' ', '='];
            $replace = str_replace($remove, '_', $request->product_name);
            $product_image = $request->product_image;
            $extension = $product_image->extension();
            $file_name = strtolower($replace).'_'.random_int(1000, 5000).'.'.$extension;
            
            Image::make($product_image)->save(public_path('uploads/product/preview/').$file_name);

            $product_insert = Product::insertGetId([
                'category_id'=>$request->category,
                'sub_category_id'=>$request->sub_category,
                'brand_id'=>$request->brand,
                'product_name'=>trim($request->product_name),
                'actual_price'=>$request->product_price,
                'discount_price'=>$request->discount_price,
                'after_discount_price'=>$request->product_price - ($request->product_price*$request->discount_price/100),
                'product_image'=>$file_name,
                'tags'=>implode(',', $request->tags),
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'additional_description'=>$request->additional,
                'created_at'=>Carbon::now(),
            ]);

            $galleries = $request->gallery_images;

            foreach($galleries as $gallery) {
                $image_extension = $gallery->extension();
                $images_name = strtolower($replace).'_'.random_int(1000, 5000).'.'.$image_extension;
                
                Image::make($gallery)->save(public_path('uploads/product/gallery/').$images_name);

                ProductGallery::insert([
                    'product_id' =>$product_insert,
                    'image' =>$images_name,
                    'created_at'=>Carbon::now(),
                ]);
            }
        }else {
            $remove = ["*", "@", "~", "!", "#", "$", "%", "^", "&", "(", ")", "+", "{", "}", "[", "]", '"', "'", "|", "/", ":", ";", "<", ">", "?", '`', '-', ' ', '='];
            $replace = str_replace($remove, '_', $request->product_name);
            $product_image = $request->product_image;
            $extension = $product_image->extension();
            $file_name = strtolower($replace).'_'.random_int(1000, 5000).'.'.$extension;
            
            Image::make($product_image)->save(public_path('uploads/product/preview/').$file_name);

            $product_insert = Product::insertGetId([
                'category_id'=>$request->category,
                'sub_category_id'=>$request->sub_category,
                'brand_id'=>$request->brand,
                'product_name'=>trim($request->product_name),
                'actual_price'=>$request->product_price,
                'discount_price'=>$request->discount_price,
                'after_discount_price'=>$request->product_price - ($request->product_price*$request->discount_price/100),
                'product_image'=>$file_name,
                'tags'=>implode(',', $request->tags),
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'additional_description'=>$request->additional,
                'created_at'=>Carbon::now(),
            ]);
        }

        return back()->with('product_add', 'Product Added Successfully!');
    }

    function preview_product() {
        $products = Product::all();
        return view('admin.product.preview', compact('products'));
    }

    function product_status(Request $request) {
        Product::find($request->id)->update([
            'status'=>$request->val,
        ]);

        return back()->with('status_update', 'Status updated!');
    }

    function delete_product($id) {
        $pvw = Product::find($id)->product_image;
        $loc = public_path('uploads/product/preview/'.$pvw);
        unlink($loc);
        
        Product::find($id)->delete();

        foreach(ProductGallery::where('product_id', $id)->get() as $gallery) {
            $img = $gallery->image;
            $location = public_path('uploads/product/gallery/'.$img);
            unlink($location);
        }

        ProductGallery::where('product_id', $id)->delete();

        return back()->with('product_delete', 'Product Delete Successfully!');
    }

    function view_full_product($id)
    {
        $detail_preview = Product::where('id', $id)->get();
        $preview_gall = ProductGallery::where('product_id', $id)->get();
        return view('admin.product.full_view', [
            'detail_preview'=>$detail_preview,
            'preview_gall'=>$preview_gall,
        ]);
        
    }
}
