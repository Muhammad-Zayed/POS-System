<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:clients_read')->only('index');
        $this->middleware('permission:clients_create')->only(['create','store']);
        $this->middleware('permission:clients_update')->only(['edit','update']);
        $this->middleware('permission:clients_delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $clients = Client::Search()->latest()->paginate(10);
        return view('dashboard.clients.index' , compact('clients'));
    }


    public function create()
    {
        return view('dashboard.clients.create');
    }


    public function store(ClientRequest $request)
    {
        $clientData = $request->validated();

        Client::create($clientData);


        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function edit(Client $client)
    {
        return view('dashboard.clients.edit' , compact('client'));
    }


    public function update(ClientRequest $request, Client $client)
    {
        $clientData = $request->validated();
        $client->update($clientData);
        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }

    public function destroy(Client $client)
    {

        foreach ($client->orders as $order ) {
            foreach ($order->products as $product) {
                $product->update([
                    'stock' => $product->stock + $product->pivot->quantity
                ]);
            }
            
        }
        $client->delete();
        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}
