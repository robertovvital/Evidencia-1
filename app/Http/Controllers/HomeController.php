<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Pantalla pública. Sin registro. Permite consultar el estatus de un
     * pedido a partir del número de factura.
     */
    public function index(Request $request): View
    {
        $order = null;
        $searched = false;

        $request->validate([
            'invoice_number' => ['nullable', 'string', 'max:30'],
        ]);

        if ($request->filled('invoice_number')) {
            $searched = true;

            $order = Order::with(['evidences'])
                ->where('invoice_number', $request->input('invoice_number'))
                ->first();
        }

        return view('home', [
            'order'    => $order,
            'searched' => $searched,
        ]);
    }
}
