@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>
        
        <!-- Update Profile Information -->
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label for="name" class="block font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>
            
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h2 class="text-2xl font-semibold mb-6">Change Password</h2>
        
        <!-- Update Password -->
        <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-4">
            @csrf
            @method('POST')
            
            <div>
                <label for="current_password" class="block font-medium text-gray-700">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="new_password" class="block font-medium text-gray-700">New Password</label>
                <input type="password" id="new_password" name="new_password" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="new_password_confirmation" class="block font-medium text-gray-700">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update Password</button>
        </form>
    </div>
</div>
@endsection
