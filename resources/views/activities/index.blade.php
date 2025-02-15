@extends(auth()->user()->role === 'admin' ? 'admin.layout' : 'layouts.app')

@section('content')
<div class="container py-10">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-gradient-to-r from-blue-600 to-indigo-600 text-white d-flex justify-content-between align-items-center py-4 px-5">
                    <h4 class="mb-0 font-semibold"><i class="fas fa-clipboard-list me-2"></i> Activity Logs</h4>
                </div>

                <div class="card-body p-6 bg-gray-50">
                    @if ($activities->isEmpty())
                        <div class="alert alert-info text-center font-medium p-4 rounded-lg shadow-sm bg-white">
                            <i class="fas fa-info-circle me-2 text-blue-500"></i> No activities logged yet.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border rounded-lg overflow-hidden shadow-sm">
                                <thead class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white">
                                    <tr class="text-center">
                                        <th class="py-3"><i class="fas fa-tasks me-1"></i> Task</th>
                                        <th class="py-3"><i class="fas fa-align-left me-1"></i> Description</th>
                                        <th class="py-3"><i class="fas fa-clock me-1"></i> Logged At</th>
                                        <th class="py-3"><i class="fas fa-user me-1"></i> Employee</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($activities as $activity)
                                        <tr class="border-b hover:bg-gray-100 transition duration-200 ease-in-out">
                                            <td class="px-4 py-3 font-semibold text-gray-700">
                                                <i class="fas fa-tasks text-blue-500 me-2"></i> {{ $activity->task->title }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">
                                                {{ Str::limit($activity->description, 50) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-500">
                                                <i class="fas fa-calendar-alt text-green-500 me-2"></i> {{ $activity->logged_at->format('d M Y, h:i A') }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-700">
                                                <i class="fas fa-user text-purple-500 me-2"></i> {{ $activity->user->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
