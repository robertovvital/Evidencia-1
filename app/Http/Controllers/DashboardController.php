<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'ordersCount'   => Order::count(),
            'archivedCount' => Order::onlyTrashed()->count(),
            'usersCount'    => User::count(),
        ]);
    }
}
