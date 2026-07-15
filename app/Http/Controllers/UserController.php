<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Listado general de usuarios (activos e inactivos).
     */
    public function index(): View
    {
        $users = User::with('department')
            ->orderBy('name')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('users.create', compact('departments'));
    }

    /**
     * Alta de usuario con asignación de rol/departamento.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'department_id'     => $data['department_id'],
            'active'            => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $departments = Department::orderBy('name')->get();

        return view('users.edit', compact('user', 'departments'));
    }

    /**
     * Edición de datos básicos, departamento, o baja lógica (inactivo).
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'      => ['nullable', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,id'],
            'active'        => ['required', 'boolean'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->department_id = $data['department_id'];
        $user->active = $data['active'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }
}
