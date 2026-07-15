<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderEvidence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Listado general de pedidos (no archivados), del más reciente al más antiguo,
     * con búsqueda opcional por factura, número de cliente, fecha o estatus.
     */
    public function index(Request $request): View
    {
        $orders = Order::with(['creator', 'evidences'])
            ->when($request->filled('invoice_number'), fn ($q) => $q->where('invoice_number', 'like', '%' . $request->input('invoice_number') . '%'))
            ->when($request->filled('customer_number'), fn ($q) => $q->where('customer_number', 'like', '%' . $request->input('customer_number') . '%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('order_datetime', $request->input('date')))
            ->latest('order_datetime')
            ->paginate(15)
            ->withQueryString();

        return view('orders.index', [
            'orders'   => $orders,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('orders.create', ['statuses' => Order::STATUSES]);
    }

    /**
     * Alta de pedido. El vendedor captura todos los datos requeridos por el cliente.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateOrder($request);

        Order::create($data + [
            'status'            => Order::STATUS_ORDERED,
            'status_changed_at' => now(),
            'created_by'        => Auth::id(),
        ]);

        return redirect()->route('orders.index')->with('status', 'Order created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['creator', 'updater', 'evidences.uploader']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return view('orders.edit', ['order' => $order, 'statuses' => Order::STATUSES]);
    }

    /**
     * Actualización de datos generales del pedido.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $this->validateOrder($request, $order->id);

        $order->update($data + ['updated_by' => Auth::id()]);

        return redirect()->route('orders.index')->with('status', 'Order updated successfully.');
    }

    /**
     * Cambio de estatus del pedido. Si el nuevo estatus es "in_route" o
     * "delivered", permite (y para "route" exige rol Route) adjuntar foto.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:ordered,in_process,in_route,delivered'],
            'photo'  => ['nullable', 'image', 'max:4096'],
        ]);

        if (in_array($data['status'], [Order::STATUS_IN_ROUTE, Order::STATUS_DELIVERED]) && $request->hasFile('photo')) {
            // Solo el departamento Route puede subir evidencia fotográfica.
            abort_unless(Auth::user()->isRoute() || Auth::user()->isAdmin(), 403, 'Only Route department can upload evidence photos.');

            $path = $request->file('photo')->store('evidences', 'public');

            OrderEvidence::create([
                'order_id'    => $order->id,
                'type'        => $data['status'] === Order::STATUS_IN_ROUTE ? OrderEvidence::TYPE_ROUTE : OrderEvidence::TYPE_DELIVERED,
                'photo_path'  => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $order->update([
            'status'            => $data['status'],
            'status_changed_at' => now(),
            'updated_by'        => Auth::id(),
        ]);

        return redirect()->route('orders.show', $order)->with('status', 'Order status updated.');
    }

    /**
     * Baja lógica: no se elimina de la base de datos, solo se marca
     * (deleted_at) para que no aparezca junto con los demás pedidos.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')->with('status', 'Order archived.');
    }

    private function validateOrder(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'invoice_number'   => ['required', 'string', 'max:30', 'unique:orders,invoice_number' . ($ignoreId ? ',' . $ignoreId : '')],
            'customer_name'    => ['required', 'string', 'max:255'],
            'customer_number'  => ['required', 'string', 'max:30'],
            'fiscal_data'      => ['required', 'string'],
            'order_datetime'   => ['required', 'date'],
            'delivery_address' => ['required', 'string', 'max:255'],
            'notes'            => ['nullable', 'string'],
        ]);
    }
}
