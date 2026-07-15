@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
    <h1>Edit user</h1>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>

        <label for="password">New password (leave blank to keep current)</label>
        <input type="password" name="password" id="password">

        <label for="department_id">Department / Role</label>
        <select name="department_id" id="department_id" required>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $user->department_id) == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>

        <label for="active">Status</label>
        <select name="active" id="active" required>
            <option value="1" @selected(old('active', (int) $user->active) === 1)>Active</option>
            <option value="0" @selected(old('active', (int) $user->active) === 0)>Inactive</option>
        </select>

        <button type="submit">Save changes</button>
    </form>
@endsection
