<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use function __;
use function redirect;
use function view;

class OrderController extends Controller
{

    public function index(Client $client, Request $request)
    {

    }

    public function create(Client $client)
    {

        $categories = Category::with(['products' => function($query){
            return $query->where('stock' , '>' , 0);
        }])->get();

        return view('dashboard.clients.orders.create' , compact('client' , 'categories'));
    }


    public function store(Client $client ,OrderRequest $request)
    {

            $valid = $this->is_valid_order();

            if($valid == -1)
                return redirect()->back()->withErrors(__('Quantity_Is_Invalid'));


            $order = $client->orders()->create(['price'=>$valid]);
            $order->products()->attach($request->products);
            session()->flash('success' , __('site.deleted_successfully'));
            return redirect()->route('dashboard.orders.index');



    }


    public function show(Order $order)
    {
        //
    }


    public function edit(Client $client ,Order $order)
    {
        //
    }

    public function update(Request $request,Client $client, Order $order)
    {
        //
    }

    public function destroy(Client $client, Order $order)
    {
        //
    }


    /******************************************************************************/

    public function is_valid_order()
    {
        $order_products = [];
        $products = request()->products;
        $total_price = 0;
        foreach ($products as $id => $details) {
            $product = Product::findOrFail($id);
            $order_products[] = $product;

            if($product->stock < $details['quantity'])
                return -1;
        }

        foreach ($order_products as $order_product) {
            $total_price+=$order_product->sell_price;
            $order_product->update([
                'stock' => $order_product->stock - $products[$order_product->id]['quantity']
            ]);
        }
        return $total_price;
    }

}
