<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){


        $sales_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(price) as sum'),
        )->groupBy('month')->get();

        return view('dashboard.index',
            [
                'users_count'       => User::whereRoleIs('admin')->count(),
                'categories_count'  => Category::count(),
                'orders_count'      => Order::count(),
                'clients_count'     => Client::count(),
                'sales_data'        =>$sales_data,
            ]
        );
    }
}
