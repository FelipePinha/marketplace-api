<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            "user" => $user
        ]);
    }

    public function showOrders(User $user)
    {  
        return response()->json([
            'orders' => $user->productsAsOrders
        ], 200);
    }

    public function storeOrder(User $user, Product $product, Request $request)
    {  
        $user->productsAsOrders()->attach($product->id, ["price" => $request->price, "quantity" => $request->quantity]);

        return response()->json([
            'message' => 'Produto adicionado ao carrinho!'
        ], 200);
    }
}
