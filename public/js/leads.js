function openAddModal() {
    document.getElementById('leadModal').classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Add Lead';
    document.getElementById('leadForm').action = '/leads'; // Adjust if using route()
    document.getElementById('leadForm').reset();
    document.getElementById('leadId').value = '';
    document.getElementById('modalSubmitBtn').innerText = 'Save';
}

function openEditModal(id, name, email, phone, company) {
    document.getElementById('leadModal').classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Edit Lead';
    document.getElementById('leadForm').action = '/leads/' + id; // Adjust if using route()
    document.getElementById('leadId').value = id;
    document.getElementById('leadName').value = name;
    document.getElementById('leadEmail').value = email;
    document.getElementById('leadPhone').value = phone;
    document.getElementById('leadCompany').value = company;
    document.getElementById('modalSubmitBtn').innerText = 'Update';
}

function closeLeadModal() {
    document.getElementById('leadModal').classList.add('hidden');
}