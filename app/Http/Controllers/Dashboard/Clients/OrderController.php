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

    public function create(Client $client)
    {

        $categories = Category::with('products')->paginate(5,['*'],'categories');

        $orders = $client->orders()->with('products')->paginate(2,['*'],'orders');

        return view('dashboard.clients.orders.create' , compact('client' , 'categories','orders'));
    }


    public function store(Client $client ,OrderRequest $request)
    {

            $valid = $this->is_valid_order();

            if($valid == -1)
                return redirect()->back()->withErrors(__('site.Quantity_Is_Invalid'));


            $order = $client->orders()->create(['price'=>$valid]);
            $order->products()->attach($request->products);
            session()->flash('success' , __('site.added_successfully'));
            return redirect()->route('dashboard.orders.index');



    }


    public function edit(Client $client ,Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(2,['*'],'orders');


        return view('dashboard.clients.orders.edit',compact('client','order' , 'categories' , 'orders'));
    }

    public function update(OrderRequest $request,Client $client, Order $order)
    {

        $valid = $this->is_valid_order();

        if($valid == -1)
            return redirect()->back()->withErrors(__('site.Quantity_Is_Invalid'));

        $this->detach_order($order);
        $order->update(['price'=>$valid]);
        $order->products()->sync($request->products);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }


    /******************************************************************************/

    private function is_valid_order()
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

    private function detach_order(Order $order)
    {
        foreach ($order->products as $product) {
            if(!in_array($product->id , request()->products))
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
    }

}
