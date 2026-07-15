<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDepartment
{
    /**
     * Uso en rutas: ->middleware('department:Admin')
     * Permite varios departamentos separados por coma: 'department:Admin,Sales'
     */
    public function handle(Request $request, Closure $next, string $departments): Response
    {
        $allowed = array_map('trim', explode(',', $departments));

        $userDepartment = $request->user()?->department?->name;

        abort_unless(in_array($userDepartment, $allowed, true), 403, 'You do not have access to this section.');

        return $next($request);
    }
}
