@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">System Settings</h2>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="reporting_interval" class="block text-gray-700 font-medium mb-2">Reporting Interval</label>
            <select name="reporting_interval" id="reporting_interval"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                <option value="hourly" {{ $interval == 'hourly' ? 'selected' : '' }}>Hourly</option>
                <option value="bi-hourly" {{ $interval == 'bi-hourly' ? 'selected' : '' }}>Bi-Hourly</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Save Changes
        </button>
    </form>
</div>
@endsection
