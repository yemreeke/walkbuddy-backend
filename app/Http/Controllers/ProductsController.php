<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function list()
    {
        $products = Products::all();
        return response()->success($products);
    }
}
