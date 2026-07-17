@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('title', 'Users')

@section('content')
    <div class="card">
        <h1 class="mt-0">Users</h1>
        <p><a class="btn btn--sm" href="{{ route('users.create') }}">+ New user</a></p>

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
                        <td>
                            <span class="user-status {{ $user->active ? 'user-status--active' : 'user-status--inactive' }}">
                                {{ $user->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td><a href="{{ route('users.edit', $user) }}">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
