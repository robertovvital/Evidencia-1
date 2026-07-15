<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderEvidence;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $salesUser = User::whereHas('department', fn ($q) => $q->where('name', 'Sales'))->first();
        $routeUser = User::whereHas('department', fn ($q) => $q->where('name', 'Route'))->first();

        // Un pedido de cada estatus, para poder probar la búsqueda pública sin registrarse.
        $samples = [
            ['invoice_number' => 'INV-0001', 'status' => Order::STATUS_ORDERED],
            ['invoice_number' => 'INV-0002', 'status' => Order::STATUS_IN_PROCESS],
            ['invoice_number' => 'INV-0003', 'status' => Order::STATUS_IN_ROUTE],
            ['invoice_number' => 'INV-0004', 'status' => Order::STATUS_DELIVERED],
        ];

        foreach ($samples as $sample) {
            $order = Order::factory()->create([
                'invoice_number'    => $sample['invoice_number'],
                'status'            => $sample['status'],
                'created_by'        => $salesUser?->id,
                'status_changed_at' => now(),
            ]);

            if (in_array($sample['status'], [Order::STATUS_IN_ROUTE, Order::STATUS_DELIVERED])) {
                OrderEvidence::create([
                    'order_id'    => $order->id,
                    'type'        => OrderEvidence::TYPE_ROUTE,
                    'photo_path'  => 'evidences/sample-route.jpg',
                    'uploaded_by' => $routeUser?->id,
                ]);
            }

            if ($sample['status'] === Order::STATUS_DELIVERED) {
                OrderEvidence::create([
                    'order_id'    => $order->id,
                    'type'        => OrderEvidence::TYPE_DELIVERED,
                    'photo_path'  => 'evidences/sample-delivered.jpg',
                    'uploaded_by' => $routeUser?->id,
                ]);
            }
        }

        // Pedidos adicionales aleatorios para poder probar listados, filtros y paginación.
        Order::factory()->count(15)->create([
            'created_by' => $salesUser?->id,
        ]);

        // Un par de pedidos archivados (borrado lógico) para probar la pantalla de archivados.
        Order::factory()->count(2)->create(['created_by' => $salesUser?->id])
            ->each(fn (Order $order) => $order->delete());
    }
}
