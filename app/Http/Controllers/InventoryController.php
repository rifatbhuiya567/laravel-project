<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function add_inventory()
    {
        return view('admin.product.inventory');
    }
}
