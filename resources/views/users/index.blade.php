@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <h1>Users</h1>
    <p><a href="{{ route('users.create') }}">+ New user</a></p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->department->name ?? '-' }}</td>
                    <td>{{ $user->active ? 'Active' : 'Inactive' }}</td>
                    <td><a href="{{ route('users.edit', $user) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection
