<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {     
        $category_id = $request->query('category');
        if($category_id) {
            $category = Category::find($category_id);

            return response()->json([
                'status' => true,
                'products' => $category->products
            ]);
        }
        
        $search = $request->query('search');
        if($search) {
            $product = Product::where('name', 'like', "%{$search}%")->get();

            return response()->json([
                'status' => true,
                'product' => $product
            ]);
        }

        $order = $request->query('order', 'asc');
        $limit = $request->query('limit', Product::count());

        $products = Product::orderBy('id', $order)->limit($limit)->get();
        
        return response()->json([
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validateProduct = Validator::make($request->all(), 
        [
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
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
            "category_id" => $request->category_id,
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
