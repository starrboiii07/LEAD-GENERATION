@foreach($leads as $lead)
<div class="flex items-center py-4">
    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-500 mr-4">
        {{ strtoupper(substr($lead->name,0,1)) }}
    </div>
    <div class="flex-1">
        <div>
            <span class="font-bold text-blue-800">{{ $lead->name }}</span>
            @if($lead->position)
                <span class="ml-2 text-gray-400">{{ $lead->position }}</span>
            @endif
            @if($lead->company)
                <span class="ml-2 text-blue-700 font-bold">{{ $lead->company }}</span>
            @endif
        </div>
        <div class="text-sm text-gray-500">Work Email: {{ $lead->email }}</div>
        <div class="text-sm text-gray-500">Work Phone: {{ $lead->phone }}</div>
        <div class="text-sm text-gray-500">Contact Type: {{ $lead->contact_type }}</div>
        <div class="text-sm text-gray-500">Designation: {{ $lead->designation }}</div>
        <div class="text-sm text-gray-500">Creation Date: {{ $lead->created_at ? \Carbon\Carbon::parse($lead->created_at)->format('M d, Y') : '-' }}</div>
        <div class="text-sm text-gray-500">Last Activity: {{ $lead->last_activity ?? '-' }}</div>
    </div>
    <div>
        <button
            onclick="openEditModal(
                '{{ $lead->id }}',
                '{{ addslashes($lead->name) }}',
                '{{ addslashes($lead->email) }}',
                '{{ addslashes($lead->phone) }}',
                '{{ addslashes($lead->company) }}',
                '{{ addslashes($lead->contact_type) }}',
                '{{ addslashes($lead->position) }}',
                '{{ addslashes($lead->designation) }}',
                '{{ $lead->created_at }}'
            )"
            class="px-3 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200 mr-2"
        >Edit</button>
        <form method="POST" action="{{ route('leads.destroy', $lead->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200">Delete</button>
        </form>
    </div>
</div>
@endforeach