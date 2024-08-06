<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    /**
     * Method that returns a list of products
     */
    public function index(Request $request)
    {             
        // Check if has an search query, then filter products based on the search.
        $search = $request->query('search');
        if($search) {
            $products = Product::where('name', 'like', "%{$search}%")->get();

            return response()->json([
                'status' => true,
                'product' => $products
            ]);
        }

        $products = Product::get();
        
        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    /**
     * Method that creates a new product and store on db
     */
    public function store(ProductRequest $request)
    {
       
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

    /**
     * Method that updates product data
     */
    public function update(ProductRequest $request, Product $product)
    {
        $filename = '';
        if($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
        } else {
            $filename = null;
        }

        Product::where($product->id, $request->product_id)->update([
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
            'message' => 'produto editado com sucesso'
        ]);
    }

    public function getRecentProducts()
    {
        try {
            $products = Product::orderBy('id', 'DESC')->limit(10)->get();

            return response()->json([
                'status' => true,
                'products' => $products
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'recurso não encontrado.'
            ], 404);
        }
    }

    /**
     * Method that delete a product.
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();
        $hasProduct = $user->products->find($product->id);

        // Check if the product was created by the user
        if(! $hasProduct) {
            return response()->json([
                'status' => false,
                'message' => 'você não tem permissão para deletar este produto.'
            ], 401);
        }

        $product->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'item deletado com sucesso'
        ]);
    }
}
