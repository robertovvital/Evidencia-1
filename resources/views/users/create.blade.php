@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('title', 'New user')

@section('content')
    <div class="card">
        <h1 class="mt-0">New user</h1>

        <form class="stacked-form" method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="field">
                <label for="department_id">Department / Role</label>
                <select class="department-select" name="department_id" id="department_id" required>
                    <option value="">-- Select --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn" type="submit">Create user</button>
        </form>
    </div>
@endsection
