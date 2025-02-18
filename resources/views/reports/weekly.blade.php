@extends(auth()->user()->role === 'admin' ? 'admin.layout' : 'layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-gray-800 text-center">📅 Weekly Activity Report</h2>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-md hidden sm:table">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 text-left border">🕒 Time</th>
                        @foreach ($daysOfWeek as $day)
                            <th class="p-3 text-center border">{{ \Carbon\Carbon::parse($day)->format('l') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($timeSlots as $slot => $range)
                        <tr class="hover:bg-gray-100">
                            <td class="p-3 border font-semibold">{{ $slot }}</td>
                            @foreach ($daysOfWeek as $day)
                                <td class="p-3 border text-center">
                                    @php
                                        $activities = $structuredActivities[$day][$slot] ?? [];
                                    @endphp
                                    @if (count($activities) > 0)
                                        @foreach ($activities as $activity)
                                            @php
                                                $taskTitle = $activity->task->title ?? 'Unknown Task';
                                                $loggedBy = $activity->user->name ?? 'Unknown User';
                                            @endphp
                                            <button class="text-blue-600 font-semibold underline hover:text-blue-800 transition block"
                                                onclick="openModal(
                                                    '{{ md5($day . $slot . $activity->id) }}', 
                                                    '{{ addslashes($taskTitle) }}', 
                                                    '{{ ucfirst($activity->task->status) }}', 
                                                    '{{ \Carbon\Carbon::parse($activity->logged_at)->format('H:i') }}', 
                                                    '{{ addslashes($activity->description) }}',
                                                    '{{ auth()->user()->role === 'admin' ? addslashes($loggedBy) : '' }}'
                                                )">
                                                {{ $taskTitle }}
                                            </button>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 italic">No Activity</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile-Friendly View -->
        <div class="sm:hidden space-y-4">
            @foreach ($timeSlots as $slot => $range)
                <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800">🕒 {{ $slot }}</h3>
                    @foreach ($daysOfWeek as $day)
                        <div class="border-t mt-2 pt-2">
                            <p class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($day)->format('l') }}</p>
                            @php
                                $activities = $structuredActivities[$day][$slot] ?? [];
                            @endphp
                            @if (count($activities) > 0)
                                @foreach ($activities as $activity)
                                    @php
                                        $taskTitle = $activity->task->title ?? 'Unknown Task';
                                        $loggedBy = $activity->user->name ?? 'Unknown User';
                                    @endphp
                                    <button class="text-blue-600 font-semibold underline hover:text-blue-800 transition"
                                        onclick="openModal(
                                            '{{ md5($day . $slot . $activity->id) }}', 
                                            '{{ addslashes($taskTitle) }}', 
                                            '{{ ucfirst($activity->task->status) }}', 
                                            '{{ \Carbon\Carbon::parse($activity->logged_at)->format('H:i') }}', 
                                            '{{ addslashes($activity->description) }}',
                                            '{{ auth()->user()->role === 'admin' ? addslashes($loggedBy) : '' }}'
                                        )">
                                        {{ $taskTitle }}
                                    </button>
                                @endforeach
                            @else
                                <span class="text-gray-500 italic">No Activity</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Dynamic Activity Modal -->
<div id="activityModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center border-b pb-3">
            <h5 id="modalTitle" class="text-lg font-bold text-gray-800"></h5>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
        <div class="py-4 space-y-2">
            @if(auth()->user()->role === 'admin')
                <p class="text-gray-600"><strong>👤 Logged By:</strong> <span id="modalUser"></span></p>
            @endif
            <p class="text-gray-600"><strong>🔹 Status:</strong> <span id="modalStatus"></span></p>
            <p class="text-gray-600"><strong>🕒 Logged At:</strong> <span id="modalTime"></span></p>
            <p class="text-gray-600"><strong>📝 Description:</strong> <span id="modalDescription"></span></p>
        </div>
        <div class="flex justify-end pt-3 border-t">
            <button onclick="closeModal()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openModal(id, title, status, time, description, user = '') {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalStatus').innerText = status;
    document.getElementById('modalTime').innerText = time;
    document.getElementById('modalDescription').innerText = description;

    if (user) {
        document.getElementById('modalUser').innerText = user;
    }

    document.getElementById('activityModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('activityModal').classList.add('hidden');
}
</script>
@endsection
