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
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            "user" => $user
        ]);
    }

    public function showOrders(User $user)
    {  
        return response()->json([
            'status' => true,
            'orders' => $user->productsAsOrders
        ], 200);
    }

    public function storeOrder(Request $request)
    {
        $product = Product::find($request->product_id);
        $user = User::find($request->user_id);

        $quantityToDecrease = $product->quantity - $request->quantity;
        
        if($quantityToDecrease < 0) {
            return response()->json([
                'status' => false,
                'message' => 'houve um erro ao adicionar no carrinho. Tente novamente!'
            ], 400);
        }

        $product->update(['quantity' => $quantityToDecrease]);

        $user->productsAsOrders()->attach($product->id, ["price" => $request->price, "quantity" => $request->quantity]);

        return response()->json([
            'status' => true,
            'message' => 'Produto adicionado ao carrinho!',
            'orders' => $user->productsAsOrders()
        ], 200);
    }
}
