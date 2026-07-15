<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    // Nombres estándar usados por los seeders y por la lógica de la aplicación.
    public const ADMIN      = 'Admin';
    public const SALES      = 'Sales';
    public const PURCHASING = 'Purchasing';
    public const WAREHOUSE  = 'Warehouse';
    public const ROUTE      = 'Route';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Un departamento tiene muchos usuarios (relación 1:N).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
