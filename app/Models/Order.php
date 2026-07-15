<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Ciclo de vida del pedido (según especificación del cliente).
    public const STATUS_ORDERED    = 'ordered';
    public const STATUS_IN_PROCESS = 'in_process';
    public const STATUS_IN_ROUTE   = 'in_route';
    public const STATUS_DELIVERED  = 'delivered';

    public const STATUSES = [
        self::STATUS_ORDERED    => 'Ordered',
        self::STATUS_IN_PROCESS => 'In process',
        self::STATUS_IN_ROUTE   => 'In route',
        self::STATUS_DELIVERED  => 'Delivered',
    ];

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_number',
        'fiscal_data',
        'order_datetime',
        'delivery_address',
        'notes',
        'status',
        'status_changed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order_datetime'    => 'datetime',
        'status_changed_at' => 'datetime',
    ];

    /**
     * Vendedor que capturó el pedido.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Último usuario que actualizó el pedido.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Un pedido puede tener varias evidencias fotográficas
     * (foto de "en ruta" y foto de "entregado").
     */
    public function evidences(): HasMany
    {
        return $this->hasMany(OrderEvidence::class);
    }

    public function routeEvidence()
    {
        return $this->evidences()->where('type', OrderEvidence::TYPE_ROUTE)->latest()->first();
    }

    public function deliveredEvidence()
    {
        return $this->evidences()->where('type', OrderEvidence::TYPE_DELIVERED)->latest()->first();
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
