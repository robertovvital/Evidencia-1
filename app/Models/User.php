<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active'            => 'boolean',
        'password'          => 'hashed',
    ];

    /**
     * Un usuario pertenece a un departamento (rol).
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Pedidos que este usuario (vendedor) dio de alta.
     */
    public function createdOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    /**
     * Pedidos que este usuario actualizó por última vez.
     */
    public function updatedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'updated_by');
    }

    /**
     * Evidencias fotográficas subidas por este usuario.
     */
    public function evidences(): HasMany
    {
        return $this->hasMany(OrderEvidence::class, 'uploaded_by');
    }

    public function isAdmin(): bool
    {
        return $this->department && $this->department->name === Department::ADMIN;
    }

    public function isRoute(): bool
    {
        return $this->department && $this->department->name === Department::ROUTE;
    }

    public function isWarehouse(): bool
    {
        return $this->department && $this->department->name === Department::WAREHOUSE;
    }
}
