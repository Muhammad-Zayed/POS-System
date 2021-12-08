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


    public function destroy(Order $order)
    {

        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();

        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }
    public function products(Order $order)
    {
        $products = $order->products;

        return view('dashboard.orders._products',compact('products','order'));
    }
}
