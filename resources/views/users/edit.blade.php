@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $user->name) }}" 
                class="form-control" 
                required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', $user->email) }}" 
                class="form-control" 
                required>
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">Select role</option>
                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Staff" {{ old('role', $user->role) == 'Staff' ? 'selected' : '' }}>Staff</option>
            </select>
            @error('role')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Password (leave blank to keep current password)</label>
            <input 
                type="password" 
                name="password" 
                class="form-control" 
                autocomplete="new-password">
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="form-control" 
                autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
