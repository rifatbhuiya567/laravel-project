<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductVariation extends Controller
{
    function product_variation()
    {
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tag::all();

        return view('admin.variation.variation',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'tags'=>$tags,
        ]);
    }

    function add_color(Request $request)
    {
        $request->validate([
            'color_name'=>'required',
        ]);

        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);

        return back();
    }

    function add_size(Request $request)
    {
        $request->validate([
            'size'=>'required',
        ]);

        Size::insert([
            'size'=>$request->size,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('size_added', "Size added in list!");
    }

    function add_tags(Request $request)
    {
        $request->validate([
            'tag'=>'required',
        ]);

        Tag::insert([
            'tag'=>$request->tag,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('tag_added', "Tag added in list!");
    }
}
