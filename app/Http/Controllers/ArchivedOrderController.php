<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArchivedOrderController extends Controller
{
    /**
     * Listado de pedidos eliminados lógicamente, con opción de restaurar o editar.
     */
    public function index(): View
    {
        $orders = Order::onlyTrashed()
            ->with('creator')
            ->latest('deleted_at')
            ->paginate(15);

        return view('orders.archived', compact('orders'));
    }

    public function restore(int $orderId): RedirectResponse
    {
        $order = Order::onlyTrashed()->findOrFail($orderId);
        $order->restore();

        return redirect()->route('orders.archived')->with('status', 'Order restored successfully.');
    }
}
