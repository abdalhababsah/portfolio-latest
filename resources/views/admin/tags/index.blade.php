@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tags</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTagModal">
                Add Tag
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
                            <th>Name</th>
                            <th>Projects</th>
                            <th>Blogs</th>
                            <th>Date Added</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>
                                <div>{{ $tag->name_en }}</div>
                                @if($tag->name_ar)
                                    <small class="text-muted" dir="rtl">{{ $tag->name_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $tag->projects_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $tag->blogs_count }}</span>
                            </td>
                            <td>{{ $tag->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $tag->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editTagModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        {{ ($tag->projects_count > 0 || $tag->blogs_count > 0) ? 'disabled' : '' }}
                                        {{ ($tag->projects_count > 0 || $tag->blogs_count > 0) ? 'title=Cannot delete tags that are in use' : 'onclick=return confirm("Delete this tag?")' }}>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No tags found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Tag Modal -->
<div class="modal fade" id="createTagModal" tabindex="-1" aria-labelledby="createTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTagModalLabel">Add New Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_en" class="form-label">Tag Name (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" required>
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">Tag Name (Arabic)</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" dir="rtl">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Tag Modal -->
<div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTagForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTagModalLabel">Edit Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name_en" class="form-label">Tag Name (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name_en" name="name_en" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_name_ar" class="form-label">Tag Name (Arabic)</label>
                        <input type="text" class="form-control" id="edit_name_ar" name="name_ar" dir="rtl">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Tag</button>
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
            
            // Fetch tag data
            fetch(`/admin/tags/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editTagForm').action = `/admin/tags/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_name_en').value = data.name_en;
                    document.getElementById('edit_name_ar').value = data.name_ar || '';
                })
                .catch(error => console.error('Error fetching tag data:', error));
        });
    });
</script>
@endsection