<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validateProduct = Validator::make($request->all(), 
        [
            'user_id' => ['required', 'exists:users,id'],
            'name' => 'required',
            'image' => ['required', 'max:1024'],
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        if($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Não foi possível criar o produto.'
            ], 400);
        }

        $filename = '';
        if($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
        } else {
            $filename = null;
        }

        $product = Product::create([
            "user_id" => $request->user_id,
            "name" => $request->name,
            "image" => $filename,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity
        ]);

        return response()->json([
            'status' => true,
            'product' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            "status" => true,
            "product" => $product
        ]);
    }
}
