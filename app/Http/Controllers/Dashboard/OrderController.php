<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Client $client, Request $request)
    {

    }

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.orders.create' , compact('client' , 'categories'));
    }


    public function store(Client $client ,Request $request)
    {
        dd($request->all());
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
}
