<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderEvidence extends Model
{
    use HasFactory;

    public const TYPE_ROUTE     = 'route';
    public const TYPE_DELIVERED = 'delivered';

    protected $fillable = [
        'order_id',
        'type',
        'photo_path',
        'uploaded_by',
    ];

    /**
     * La evidencia pertenece a un pedido.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * La evidencia fue subida por un usuario (departamento Route).
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
