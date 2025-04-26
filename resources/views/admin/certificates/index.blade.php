@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Certificates</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCertificateModal">
                Add Certificate
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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
                            <th>Title</th>
                            <th>Issued By</th>
                            <th>Date Issued</th>
                            <th>Expiry</th>
                            <th>File</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->id }}</td>
                            <td>
                                <div>{{ $certificate->title_en }}</div>
                                @if($certificate->title_ar)
                                    <small class="text-muted" dir="rtl">{{ $certificate->title_ar }}</small>
                                @endif
                            </td>
                            <td>{{ $certificate->issued_by }}</td>
                            <td>{{ $certificate->date_issued->format('d/m/Y') }}</td>
                            <td>
                                @if($certificate->expiry_date)
                                    {{ $certificate->expiry_date->format('d/m/Y') }}
                                    @if($certificate->expiry_date->isPast())
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                @else
                                    <span class="badge bg-success">No Expiry</span>
                                @endif
                            </td>
                            <td>
                                @if($certificate->file_path)
                                    @php
                                        $extension = pathinfo(storage_path('app/public/' . $certificate->file_path), PATHINFO_EXTENSION);
                                        $isPdf = strtolower($extension) === 'pdf';
                                    @endphp
                                    
                                    @if($isPdf)
                                        <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                    @else
                                        <img src="{{ asset('storage/' . $certificate->file_path) }}" 
                                             style="height: 40px; width: 40px; object-fit: cover;" 
                                             class="img-thumbnail" alt="{{ $certificate->title_en }}">
                                    @endif
                                @else
                                    <span class="badge bg-secondary">No File</span>
                                @endif
                            </td>
                            <td>
                                @if($certificate->file_path)
                                    <a href="{{ route('admin.certificates.download', $certificate->id) }}" 
                                       class="btn btn-sm btn-info" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $certificate->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editCertificateModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this certificate? This cannot be undone.')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No certificates found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Certificate Modal -->
<div class="modal fade" id="createCertificateModal" tabindex="-1" aria-labelledby="createCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCertificateModalLabel">Add New Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title_en" class="form-label">Certificate Title (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title_en" name="title_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="title_ar" class="form-label">Certificate Title (Arabic)</label>
                            <input type="text" class="form-control" id="title_ar" name="title_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="issued_by" class="form-label">Issued By <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="issued_by" name="issued_by" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_issued" name="date_issued" required>
                        </div>
                        <div class="col-md-6">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                            <div class="form-text">Leave empty if certificate does not expire</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="certificate_file" class="form-label">Certificate File</label>
                        <input type="file" class="form-control" id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Accepted formats: PDF, JPG, PNG (max 10MB)</div>
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
                    <button type="submit" class="btn btn-primary">Save Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Certificate Modal -->
<div class="modal fade" id="editCertificateModal" tabindex="-1" aria-labelledby="editCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editCertificateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCertificateModalLabel">Edit Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_title_en" class="form-label">Certificate Title (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_title_en" name="title_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_title_ar" class="form-label">Certificate Title (Arabic)</label>
                            <input type="text" class="form-control" id="edit_title_ar" name="title_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_issued_by" class="form-label">Issued By <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_issued_by" name="issued_by" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_date_issued" name="date_issued" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date">
                            <div class="form-text">Leave empty if certificate does not expire</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_certificate_file" class="form-label">Certificate File</label>
                        <div id="current_file_container" class="mb-2" style="display: none;">
                            <p>Current file: <span id="current_file_name" class="fw-bold"></span></p>
                        </div>
                        <input type="file" class="form-control" id="edit_certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Leave empty to keep current file. Accepted formats: PDF, JPG, PNG (max 10MB)</div>
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
                    <button type="submit" class="btn btn-primary">Update Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Format dates for date input
    function formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toISOString().split('T')[0]; // Returns YYYY-MM-DD format
    }

    // Extract filename from path
    function getFilenameFromPath(path) {
        if (!path) return '';
        return path.split('/').pop();
    }

    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch certificate data
            fetch(`/admin/certificates/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editCertificateForm').action = `/admin/certificates/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_title_en').value = data.title_en;
                    document.getElementById('edit_title_ar').value = data.title_ar || '';
                    document.getElementById('edit_issued_by').value = data.issued_by;
                    document.getElementById('edit_date_issued').value = formatDateForInput(data.date_issued);
                    document.getElementById('edit_expiry_date').value = formatDateForInput(data.expiry_date);
                    document.getElementById('edit_description_en').value = data.description_en || '';
                    document.getElementById('edit_description_ar').value = data.description_ar || '';
                    
                    // Show current file info if available
                    if (data.file_path) {
                        document.getElementById('current_file_name').textContent = getFilenameFromPath(data.file_path);
                        document.getElementById('current_file_container').style.display = 'block';
                    } else {
                        document.getElementById('current_file_container').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching certificate data:', error));
        });
    });
</script>
@endsection