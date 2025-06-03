<div id="leadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 overflow-y-auto hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 my-8 p-4 sm:p-8 relative">
        <button type="button" onclick="closeLeadModal()" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 text-2xl leading-none z-10" aria-label="Close">&times;</button>
        <h2 id="modalTitle" class="text-2xl font-bold mb-6">Add Lead</h2>
        <form id="leadForm" method="POST" action="{{ route('leads.store') }}">
            @csrf
            <input type="hidden" name="id" id="leadId">
            <div class="mb-4">
                <label class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" id="leadName" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Work Position</label>
                <input type="text" name="position" id="leadPosition" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Company</label>
                <input type="text" name="company" id="leadCompany" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Designation</label>
                <input type="text" name="designation" id="leadDesignation" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Work Email</label>
                <input type="email" name="email" id="leadEmail" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Contact Type</label>
                <input type="text" name="contact_type" id="leadContactType" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Work Phone</label>
                <input type="text" name="phone" id="leadPhone" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Date Creation</label>
                <input type="date" name="created_at" id="leadCreatedAt" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Add Activity / Task</label>
                <input type="text" name="activity_title" id="activityTitle" class="w-full border rounded px-3 py-2" placeholder="Activity Title">
                <textarea name="activity_description" id="activityDescription" class="w-full border rounded px-3 py-2 mt-2" placeholder="Activity Description"></textarea>
                <input type="date" name="activity_due_date" id="activityDueDate" class="w-full border rounded px-3 py-2 mt-2" placeholder="Due Date">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeLeadModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-orange-500 text-white hover:bg-orange-600" id="modalSubmitBtn">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="calendarModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 overflow-y-auto hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 my-8 p-4 sm:p-8 relative">
        <button type="button" onclick="closeEventModal()" class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 text-2xl leading-none z-10" aria-label="Close">&times;</button>
        <h2 class="text-2xl font-bold mb-6">Add Event</h2>
        <form id="eventForm" method="POST" action="{{ route('events.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Event Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Date</label>
                <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEventModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600">Add Event</button>
            </div>
        </form>
    </div>
</div>