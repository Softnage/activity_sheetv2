@extends('admin.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-blue-600 text-white text-center py-3">
                    <h5 class="mb-0 font-semibold">System Settings</h5>
                </div>
                <div class="card-body p-4">
                @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        
                        <!-- Reporting Interval Selection -->
                        <div class="mb-4">
                            <label for="reporting_interval" class="form-label font-medium text-sm text-gray-700">Reporting Interval</label>
                            <select name="reporting_interval" id="reporting_interval"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                <option value="hourly" {{ $interval == 'hourly' ? 'selected' : '' }}>Hourly</option>
                <option value="bi-hourly" {{ $interval == 'bi-hourly' ? 'selected' : '' }}>Bi-Hourly</option>
            </select>
                        </div>

                        <!-- Timezone Selection -->
                        <div class="mb-4">
                            <label for="timezone" class="form-label font-medium text-sm text-gray-700">Timezone</label>
                            <select name="timezone" id="timezone" class="form-select p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 w-full" required>
                                @foreach (timezone_identifiers_list() as $tz)
                                    <option value="{{ $tz }}" {{ $setting->timezone == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full py-3 text-lg rounded-md shadow-md transition duration-200 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Update Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
