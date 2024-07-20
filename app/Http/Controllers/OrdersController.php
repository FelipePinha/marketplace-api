<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            "orders" => $user->productsAsOrders
        ], 200);
    }

    public function store(Request $request)
    {
        $valiadateOrder = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        if($valiadateOrder->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Não foi possível adicionar o produto no carrinho. Tente novamente'
            ], 400);
        }

        $order = Order::create($request->all());

        return response()->json([
            'status' => true,
            'order' => $order
        ], 201);
    }

}
