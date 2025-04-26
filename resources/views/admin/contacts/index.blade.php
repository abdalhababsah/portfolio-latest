@extends('admin.layout.app')

@section('styles')
<style>
    .unread {
        font-weight: 600;
        background-color: rgba(var(--bs-primary-rgb), 0.05);
    }
    .message-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .contact-checkbox {
        width: 20px;
        height: 20px;
    }
    .select-all-container {
        min-width: 120px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Contact Messages</h4>
                <p class="text-muted mb-0" id="unread-count">
                    {{ $contacts->whereNull('read_at')->count() }} unread messages
                </p>
            </div>
            <div class="d-flex gap-2">
                <div class="dropdown select-all-container">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="selectionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <input type="checkbox" id="select-all" class="form-check-input me-2 contact-checkbox">
                        <span>Select</span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="selectionDropdown">
                        <li><a class="dropdown-item" href="#" id="select-all-option">Select All</a></li>
                        <li><a class="dropdown-item" href="#" id="select-none-option">Select None</a></li>
                        <li><a class="dropdown-item" href="#" id="select-unread-option">Select Unread</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="mark-selected-read">Mark Selected as Read</a></li>
                    </ul>
                </div>
                
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" id="mark-read-btn" disabled>
                        Mark as Read
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th style="width: 60px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date Received</th>
                            <th style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->read_at ? '' : 'unread' }}" data-id="{{ $contact->id }}">
                            <td>
                                <input type="checkbox" class="form-check-input contact-checkbox contact-select" data-id="{{ $contact->id }}">
                            </td>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </td>
                            <td>{{ $contact->subject }}</td>
                            <td class="message-preview">{{ $contact->message }}</td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info">
                                    View
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No contact messages found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkbox
        const selectAllCheckbox = document.getElementById('select-all');
        const selectAllOption = document.getElementById('select-all-option');
        const selectNoneOption = document.getElementById('select-none-option');
        const selectUnreadOption = document.getElementById('select-unread-option');
        const contactCheckboxes = document.querySelectorAll('.contact-select');
        const markReadBtn = document.getElementById('mark-read-btn');
        const markSelectedRead = document.getElementById('mark-selected-read');
        
        // Update button state based on selections
        function updateButtonState() {
            const selectedItems = document.querySelectorAll('.contact-select:checked');
            markReadBtn.disabled = selectedItems.length === 0;
        }
        
        // Select all contacts
        function selectAll() {
            contactCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            selectAllCheckbox.checked = true;
            updateButtonState();
        }
        
        // Deselect all contacts
        function deselectAll() {
            contactCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            updateButtonState();
        }
        
        // Select only unread contacts
        function selectUnread() {
            contactCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                checkbox.checked = row.classList.contains('unread');
            });
            updateSelectAllState();
            updateButtonState();
        }
        
        // Update select all checkbox state
        function updateSelectAllState() {
            const totalCheckboxes = contactCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.contact-select:checked').length;
            
            selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
            selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        }
        
        // Mark selected messages as read
        function markAsRead() {
            const selectedIds = Array.from(document.querySelectorAll('.contact-select:checked')).map(cb => cb.dataset.id);
            
            if (selectedIds.length === 0) return;
            
            fetch('{{ route('admin.contacts.mark-read') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI to reflect read status
                    selectedIds.forEach(id => {
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            row.classList.remove('unread');
                        }
                    });
                    
                    // Update unread count
                    updateUnreadCount();
                    
                    // Show success message
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error marking messages as read:', error));
        }
        
        // Update unread count
        function updateUnreadCount() {
            fetch('{{ route('admin.contacts.unread-count') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('unread-count').textContent = `${data.count} unread messages`;
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }
        
        // Event listeners
        selectAllCheckbox.addEventListener('change', function() {
            if (this.checked) {
                selectAll();
            } else {
                deselectAll();
            }
        });
        
        selectAllOption.addEventListener('click', function(e) {
            e.preventDefault();
            selectAll();
        });
        
        selectNoneOption.addEventListener('click', function(e) {
            e.preventDefault();
            deselectAll();
        });
        
        selectUnreadOption.addEventListener('click', function(e) {
            e.preventDefault();
            selectUnread();
        });
        
        contactCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
                updateButtonState();
            });
        });
        
        markReadBtn.addEventListener('click', markAsRead);
        markSelectedRead.addEventListener('click', function(e) {
            e.preventDefault();
            markAsRead();
        });
        
        // Initialize button state
        updateButtonState();
    });
</script>
@endsection