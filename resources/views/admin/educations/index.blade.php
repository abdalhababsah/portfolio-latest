@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Education</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createEducationModal">
                Add Education
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
                            <th>Institution</th>
                            <th>Degree</th>
                            <th>Duration</th>
                            <th>Description</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($educations as $education)
                        <tr>
                            <td>{{ $education->id }}</td>
                            <td>
                                <div>{{ $education->institution_en }}</div>
                                @if($education->institution_ar)
                                    <small class="text-muted" dir="rtl">{{ $education->institution_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <div>{{ $education->degree_en }}</div>
                                @if($education->degree_ar)
                                    <small class="text-muted" dir="rtl">{{ $education->degree_ar }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $education->start_date->format('M Y') }} - 
                                {{ $education->end_date ? $education->end_date->format('M Y') : 'Present' }}
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($education->description_en, 50) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $education->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editEducationModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.educations.destroy', $education->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this education record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No education records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Education Modal -->
<div class="modal fade" id="createEducationModal" tabindex="-1" aria-labelledby="createEducationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.educations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createEducationModalLabel">Add New Education</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="institution_en" class="form-label">Institution (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institution_en" name="institution_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="institution_ar" class="form-label">Institution (Arabic)</label>
                            <input type="text" class="form-control" id="institution_ar" name="institution_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="degree_en" class="form-label">Degree (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="degree_en" name="degree_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="degree_ar" class="form-label">Degree (Arabic)</label>
                            <input type="text" class="form-control" id="degree_ar" name="degree_ar" dir="rtl">
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
                            <div class="form-text">Leave empty if still studying or ongoing</div>
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
                    <button type="submit" class="btn btn-primary">Save Education</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Education Modal -->
<div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="editEducationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEducationForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editEducationModalLabel">Edit Education</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_institution_en" class="form-label">Institution (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_institution_en" name="institution_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_institution_ar" class="form-label">Institution (Arabic)</label>
                            <input type="text" class="form-control" id="edit_institution_ar" name="institution_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_degree_en" class="form-label">Degree (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_degree_en" name="degree_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_degree_ar" class="form-label">Degree (Arabic)</label>
                            <input type="text" class="form-control" id="edit_degree_ar" name="degree_ar" dir="rtl">
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
                            <div class="form-text">Leave empty if still studying or ongoing</div>
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
                    <button type="submit" class="btn btn-primary">Update Education</button>
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
            
            // Fetch education data
            fetch(`/admin/educations/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editEducationForm').action = `/admin/educations/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_institution_en').value = data.institution_en;
                    document.getElementById('edit_institution_ar').value = data.institution_ar || '';
                    document.getElementById('edit_degree_en').value = data.degree_en;
                    document.getElementById('edit_degree_ar').value = data.degree_ar || '';
                    document.getElementById('edit_start_date').value = formatDateForMonthInput(data.start_date);
                    document.getElementById('edit_end_date').value = formatDateForMonthInput(data.end_date);
                    document.getElementById('edit_description_en').value = data.description_en || '';
                    document.getElementById('edit_description_ar').value = data.description_ar || '';
                })
                .catch(error => console.error('Error fetching education data:', error));
        });
    });
</script>
@endsection