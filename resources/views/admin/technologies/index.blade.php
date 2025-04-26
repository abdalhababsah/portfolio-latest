@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Technologies</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTechnologyModal">
                Add Technology
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
                            <th style="width: 80px;">Logo</th>
                            <th>Technology</th>
                            <th>Projects</th>
                            <th>Date Added</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($technologies as $technology)
                        <tr>
                            <td>{{ $technology->id }}</td>
                            <td>
                                @if($technology->logo)
                                    <img src="{{ asset('storage/'.$technology->logo) }}" alt="{{ $technology->name_en }}" 
                                         class="img-thumbnail" style="height:40px; width:40px; object-fit:cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                         style="height:40px; width:40px;">
                                        <i class="fas fa-code text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $technology->name_en }}</div>
                                @if($technology->name_ar)
                                    <small class="text-muted" dir="rtl">{{ $technology->name_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $technology->projects->count() }}</span>
                            </td>
                            <td>{{ $technology->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $technology->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editTechnologyModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.technologies.destroy', $technology->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this technology? This cannot be undone.')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No technologies found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Technology Modal -->
<div class="modal fade" id="createTechnologyModal" tabindex="-1" aria-labelledby="createTechnologyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.technologies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTechnologyModalLabel">Add New Technology</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_en" class="form-label">Technology Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_en" name="name_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name_ar" class="form-label">Technology Name (Arabic)</label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <div class="form-text">Recommended size: Square (e.g., 200x200px)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Technology</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Technology Modal -->
<div class="modal fade" id="editTechnologyModal" tabindex="-1" aria-labelledby="editTechnologyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editTechnologyForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTechnologyModalLabel">Edit Technology</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name_en" class="form-label">Technology Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name_en" name="name_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_name_ar" class="form-label">Technology Name (Arabic)</label>
                            <input type="text" class="form-control" id="edit_name_ar" name="name_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_logo" class="form-label">Logo</label>
                        <div class="mb-2" id="current_logo_container" style="display: none;">
                            <p>Current logo:</p>
                            <img id="current_logo" src="" alt="Current Logo" style="max-height: 100px;">
                        </div>
                        <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*">
                        <div class="form-text">Leave empty to keep current logo. Recommended size: Square (e.g., 200x200px)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Technology</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch technology data
            fetch(`/admin/technologies/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editTechnologyForm').action = `/admin/technologies/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_name_en').value = data.name_en;
                    document.getElementById('edit_name_ar').value = data.name_ar || '';
                    
                    // Show current logo if available
                    if (data.logo) {
                        document.getElementById('current_logo').src = `/storage/${data.logo}`;
                        document.getElementById('current_logo_container').style.display = 'block';
                    } else {
                        document.getElementById('current_logo_container').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching technology data:', error));
        });
    });
</script>
@endsection