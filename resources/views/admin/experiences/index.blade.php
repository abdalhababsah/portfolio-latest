@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Work Experience</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createExperienceModal">
                Add Experience
            </button>
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Company</th>
                            <th>Position</th>
                            <th>Duration</th>
                            <th>Date Added</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($experiences as $experience)
                        <tr>
                            <td>{{ $experience->id }}</td>
                            <td>
                                <div>{{ $experience->company_en }}</div>
                                @if($experience->company_ar)
                                    <small class="text-muted" dir="rtl">{{ $experience->company_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <div>{{ $experience->position_en }}</div>
                                @if($experience->position_ar)
                                    <small class="text-muted" dir="rtl">{{ $experience->position_ar }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $experience->start_date->format('M Y') }} - 
                                {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Present' }}
                            </td>
                            <td>{{ $experience->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $experience->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editExperienceModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.experiences.destroy', $experience->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this experience?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No experiences found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Experience Modal -->
<div class="modal fade" id="createExperienceModal" tabindex="-1" aria-labelledby="createExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.experiences.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createExperienceModalLabel">Add New Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="company_en" class="form-label">Company Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company_en" name="company_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_ar" class="form-label">Company Name (Arabic)</label>
                            <input type="text" class="form-control" id="company_ar" name="company_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="position_en" class="form-label">Position (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="position_en" name="position_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="position_ar" class="form-label">Position (Arabic)</label>
                            <input type="text" class="form-control" id="position_ar" name="position_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="month" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="month" class="form-control" id="end_date" name="end_date">
                            <div class="form-text">Leave empty if this is your current job</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description_en" class="form-label">Description (English)</label>
                            <textarea class="form-control" id="description_en" name="description_en" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="description_ar" class="form-label">Description (Arabic)</label>
                            <textarea class="form-control" id="description_ar" name="description_ar" rows="4" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Experience Modal -->
<div class="modal fade" id="editExperienceModal" tabindex="-1" aria-labelledby="editExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editExperienceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editExperienceModalLabel">Edit Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_company_en" class="form-label">Company Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_company_en" name="company_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_company_ar" class="form-label">Company Name (Arabic)</label>
                            <input type="text" class="form-control" id="edit_company_ar" name="company_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_position_en" class="form-label">Position (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_position_en" name="position_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_position_ar" class="form-label">Position (Arabic)</label>
                            <input type="text" class="form-control" id="edit_position_ar" name="position_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="month" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_date" class="form-label">End Date</label>
                            <input type="month" class="form-control" id="edit_end_date" name="end_date">
                            <div class="form-text">Leave empty if this is your current job</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_description_en" class="form-label">Description (English)</label>
                            <textarea class="form-control" id="edit_description_en" name="description_en" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_description_ar" class="form-label">Description (Arabic)</label>
                            <textarea class="form-control" id="edit_description_ar" name="description_ar" rows="4" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Format dates for month input
    function formatDateForMonthInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
    }

    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch experience data
            fetch(`/admin/experiences/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editExperienceForm').action = `/admin/experiences/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_company_en').value = data.company_en;
                    document.getElementById('edit_company_ar').value = data.company_ar || '';
                    document.getElementById('edit_position_en').value = data.position_en;
                    document.getElementById('edit_position_ar').value = data.position_ar || '';
                    document.getElementById('edit_start_date').value = formatDateForMonthInput(data.start_date);
                    document.getElementById('edit_end_date').value = formatDateForMonthInput(data.end_date);
                    document.getElementById('edit_description_en').value = data.description_en || '';
                    document.getElementById('edit_description_ar').value = data.description_ar || '';
                })
                .catch(error => console.error('Error fetching experience data:', error));
        });
    });
</script>
@endsection