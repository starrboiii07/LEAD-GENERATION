@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans">
    <!-- Sidebar -->
    <aside class="bg-white border-r w-64 p-6 flex flex-col">
        <h2 class="text-2xl font-extrabold mb-8 text-gray-900 tracking-tight">Customer<br>Relationship<br>Management</h2>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li><a href="/dashboard" class="block px-4 py-2 rounded hover:bg-orange-100">Dashboard</a></li>
                <li><a href="/clients" class="block px-4 py-2 rounded hover:bg-orange-100">Client Contacts</a></li>
                <li>
                    <a href="/leads" class="block px-4 py-2 rounded bg-orange-500 text-white font-semibold">Leads Generation</a>
                </li>
                <li><a href="/pipeline" class="block px-4 py-2 rounded hover:bg-orange-100">Sales Pipeline</a></li>
                <li><a href="/tasks" class="block px-4 py-2 rounded hover:bg-orange-100">Tasks & Activities</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Email & Communication</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Automation & Workflows</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Reports & Analytics</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Customer Support</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Documents & Files</a></li>
                <li><a href="#" class="block px-4 py-2 rounded hover:bg-orange-100">Admin & Settings</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Leads Management</h1>
            <button onclick="openAddModal()" class="flex items-center bg-orange-500 text-white px-5 py-2 rounded-full shadow hover:bg-orange-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Add Lead
            </button>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">Leads Management</h2>
            <div class="divide-y" id="leadsList">
                @include('leads.partials.leads-list', ['leads' => $leads])
            </div>
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="w-96 p-6 flex flex-col space-y-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center">
            <div class="text-lg font-bold mb-2">{{ \Carbon\Carbon::now()->format('l, F d') }}</div>
            <div class="mb-4">
                <svg width="60" height="60" viewBox="0 0 60 60"><circle cx="30" cy="30" r="28" fill="#FFF9E5"/><circle cx="30" cy="30" r="18" fill="#FFD600"/><path d="M20 40 Q30 50 40 40" stroke="#FFA000" stroke-width="2" fill="none"/></svg>
            </div>
            <div class="text-gray-700 mb-4">Nothing planned for today</div>
            <button onclick="openEventModal()" class="bg-green-200 text-green-900 px-4 py-2 rounded-full">New event</button>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-bold mb-2">Open Tasks</h3>
            <ul class="space-y-2 text-gray-700 text-sm">
                @forelse($tasks as $task)
                    <li>{{ $task->title }} - Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</li>
                @empty
                    <li>No open tasks.</li>
                @endforelse
            </ul>
        </div>
    </aside>
</div>

@include('leads.modals')

<script>
function openAddModal() {
    document.getElementById('leadModal').classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Add Lead';
    document.getElementById('leadForm').action = "{{ route('leads.store') }}";
    document.getElementById('leadForm').reset();
    document.getElementById('leadId').value = '';
    document.getElementById('modalSubmitBtn').innerText = 'Save';
}
function openEditModal(id, name, email, phone, company, contact_type, position, designation, created_at) {
    document.getElementById('leadModal').classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Edit Lead';
    document.getElementById('leadForm').action = '/leads/' + id;
    document.getElementById('leadId').value = id;
    document.getElementById('leadName').value = name;
    document.getElementById('leadEmail').value = email;
    document.getElementById('leadPhone').value = phone;
    document.getElementById('leadCompany').value = company;
    document.getElementById('leadContactType').value = contact_type;
    document.getElementById('leadPosition').value = position;
    document.getElementById('leadDesignation').value = designation;
    document.getElementById('leadCreatedAt').value = created_at ? created_at.substring(0,10) : '';
    document.getElementById('modalSubmitBtn').innerText = 'Update';
}
function closeLeadModal() {
    document.getElementById('leadModal').classList.add('hidden');
}
function openEventModal() {
    document.getElementById('calendarModal').classList.remove('hidden');
}
function closeEventModal() {
    document.getElementById('calendarModal').classList.add('hidden');
}

// AJAX for delete and update
document.addEventListener('DOMContentLoaded', function () {
    // DELETE
    document.getElementById('leadsList').addEventListener('submit', function(e) {
        if (e.target.matches('form[action*="leads"]')) {
            e.preventDefault();
            if (!confirm('Delete this lead?')) return;
            fetch(e.target.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(e.target)
            })
            .then(res => res.json())
            .then(() => refreshLeads())
            .catch(() => alert('Failed to delete lead.'));
        }
    });

    // UPDATE/ADD
    document.getElementById('leadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = e.target;
        let url = form.action;
        let method = form.querySelector('#leadId').value ? 'POST' : 'POST';
        let data = new FormData(form);
        if (form.querySelector('#leadId').value) {
            data.append('_method', 'PUT');
        }
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: data
        })
        .then(res => res.json())
        .then(() => {
            closeLeadModal();
            refreshLeads();
        })
        .catch(() => alert('Failed to save lead.'));
    });
});

// Refresh leads list via AJAX
function refreshLeads() {
    fetch("{{ route('leads.index') }}", {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(res => res.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newList = doc.getElementById('leadsList');
            if (newList) {
                document.getElementById('leadsList').innerHTML = newList.innerHTML;
            } else {
                document.getElementById('leadsList').innerHTML = html;
            }
        });
}
</script>
@endsection