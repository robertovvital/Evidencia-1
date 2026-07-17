@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('title', 'Edit user')

@section('content')
    <div class="card">
        <h1 class="mt-0">Edit user</h1>

        <form class="stacked-form" method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="field">
                <label for="password">New password (leave blank to keep current)</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="field">
                <label for="department_id">Department / Role</label>
                <select class="department-select" name="department_id" id="department_id" required>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id', $user->department_id) == $department->id)>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="active">Status</label>
                <select name="active" id="active" required>
                    <option value="1" @selected(old('active', (int) $user->active) === 1)>Active</option>
                    <option value="0" @selected(old('active', (int) $user->active) === 0)>Inactive</option>
                </select>
            </div>

            <button class="btn" type="submit">Save changes</button>
        </form>
    </div>
@endsection
