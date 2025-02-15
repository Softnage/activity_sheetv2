@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>

    <!-- Edit Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                    class="w-full mt-2 p-3 border border-gray-300 rounded-lg">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                    class="w-full mt-2 p-3 border border-gray-300 rounded-lg" readonly>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Role</label>
                <select name="role" class="w-full mt-2 p-3 border border-gray-300 rounded-lg">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Update User
            </button>
        </form>
    </div>
</div>
@endsection
