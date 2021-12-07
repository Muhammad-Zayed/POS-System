<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        $orders = Order::Search()->latest()->paginate(10);
        return view('dashboard.orders.index' , compact('orders'));

    }

    public function products(Order $order)
    {
        $products = $order->products;

        return view('dashboard.orders._products',compact('products','order'));
    }
}
