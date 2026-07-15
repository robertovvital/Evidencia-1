@extends('layouts.app')

@section('title', 'New user')

@section('content')
    <h1>New user</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="department_id">Department / Role</label>
        <select name="department_id" id="department_id" required>
            <option value="">-- Select --</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Create user</button>
    </form>
@endsection
