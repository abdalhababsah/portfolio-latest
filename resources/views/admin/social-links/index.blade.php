@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Social Links</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSocialLinkModal">
                Add Social Link
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
                            <th style="width: 80px;">Icon</th>
                            <th>Platform</th>
                            <th>URL</th>
                            <th>Date Added</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($socialLinks as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center" style="height: 40px; width: 40px;">
                                    <i class="{{ $link->icon_class }} fa-2x"></i>
                                </div>
                            </td>
                            <td>{{ $link->platform }}</td>
                            <td>
                                <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 300px;">
                                    {{ $link->url }}
                                </a>
                            </td>
                            <td>{{ $link->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $link->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editSocialLinkModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.social-links.destroy', $link->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this social link?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No social links found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Social Link Modal -->
<div class="modal fade" id="createSocialLinkModal" tabindex="-1" aria-labelledby="createSocialLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.social-links.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSocialLinkModalLabel">Add New Social Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="platform" class="form-label">Platform <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="platform" name="platform" required placeholder="e.g., Facebook, Twitter, LinkedIn">
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="url" name="url" required placeholder="https://...">
                        <div class="form-text">Enter the full URL to your profile or page</div>
                    </div>

                    <div class="mb-3">
                        <label for="icon_class" class="form-label">Icon Class <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="icon_preview" class="fab fa-facebook"></i></span>
                            <input type="text" class="form-control" id="icon_class" name="icon_class" required value="fab fa-facebook">
                        </div>
                        <div class="form-text">
                            Font Awesome class name (e.g., fab fa-facebook, fab fa-twitter). 
                            <a href="https://fontawesome.com/icons?d=gallery&s=brands" target="_blank">Browse icons</a>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Common Social Icons</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-facebook">
                                <i class="fab fa-facebook"></i> Facebook
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-instagram">
                                <i class="fab fa-instagram"></i> Instagram
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-linkedin">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-github">
                                <i class="fab fa-github"></i> GitHub
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary icon-btn" data-icon="fab fa-youtube">
                                <i class="fab fa-youtube"></i> YouTube
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Social Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Social Link Modal -->
<div class="modal fade" id="editSocialLinkModal" tabindex="-1" aria-labelledby="editSocialLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSocialLinkForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSocialLinkModalLabel">Edit Social Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_platform" class="form-label">Platform <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_platform" name="platform" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_url" class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="edit_url" name="url" required>
                        <div class="form-text">Enter the full URL to your profile or page</div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_icon_class" class="form-label">Icon Class <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="edit_icon_preview" class="fab fa-facebook"></i></span>
                            <input type="text" class="form-control" id="edit_icon_class" name="icon_class" required>
                        </div>
                        <div class="form-text">
                            Font Awesome class name (e.g., fab fa-facebook, fab fa-twitter). 
                            <a href="https://fontawesome.com/icons?d=gallery&s=brands" target="_blank">Browse icons</a>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Common Social Icons</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-facebook">
                                <i class="fab fa-facebook"></i> Facebook
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-instagram">
                                <i class="fab fa-instagram"></i> Instagram
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-linkedin">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-github">
                                <i class="fab fa-github"></i> GitHub
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary edit-icon-btn" data-icon="fab fa-youtube">
                                <i class="fab fa-youtube"></i> YouTube
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Social Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Icon preview for create form
    document.getElementById('icon_class').addEventListener('input', function() {
        document.getElementById('icon_preview').className = this.value;
    });

    // Icon preview for edit form
    document.getElementById('edit_icon_class').addEventListener('input', function() {
        document.getElementById('edit_icon_preview').className = this.value;
    });

    // Quick icon selection for create form
    document.querySelectorAll('.icon-btn').forEach(button => {
        button.addEventListener('click', function() {
            const iconClass = this.getAttribute('data-icon');
            document.getElementById('icon_class').value = iconClass;
            document.getElementById('icon_preview').className = iconClass;
            
            // Auto-fill platform name if empty
            const platformInput = document.getElementById('platform');
            if (!platformInput.value) {
                // Extract platform name from icon class (e.g., fa-facebook → Facebook)
                const platformName = iconClass.split('fa-')[1];
                if (platformName) {
                    platformInput.value = platformName.charAt(0).toUpperCase() + platformName.slice(1);
                }
            }
        });
    });

    // Quick icon selection for edit form
    document.querySelectorAll('.edit-icon-btn').forEach(button => {
        button.addEventListener('click', function() {
            const iconClass = this.getAttribute('data-icon');
            document.getElementById('edit_icon_class').value = iconClass;
            document.getElementById('edit_icon_preview').className = iconClass;
        });
    });

    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch social link data
            fetch(`/admin/social-links/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editSocialLinkForm').action = `/admin/social-links/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_platform').value = data.platform;
                    document.getElementById('edit_url').value = data.url;
                    document.getElementById('edit_icon_class').value = data.icon_class;
                    document.getElementById('edit_icon_preview').className = data.icon_class;
                })
                .catch(error => console.error('Error fetching social link data:', error));
        });
    });
</script>
@endsection