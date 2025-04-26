@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Skills</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSkillModal">
                Add Skill
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
                            <th style="width: 60px;">Icon</th>
                            <th>Skill</th>
                            <th>Category</th>
                            <th>Level</th>
                            <th>Description</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skills as $skill)
                        <tr>
                            <td>{{ $skill->id }}</td>
                            <td>
                                @if($skill->icon)
                                    <img src="{{ asset('storage/'.$skill->icon) }}" alt="{{ $skill->name_en }}" 
                                         class="img-thumbnail" style="height:40px; width:40px; object-fit:cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                         style="height:40px; width:40px;">
                                        <i class="fas fa-star text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $skill->name_en }}</div>
                                @if($skill->name_ar)
                                    <small class="text-muted" dir="rtl">{{ $skill->name_ar }}</small>
                                @endif
                            </td>
                            <td>{{ $skill->category ? $skill->category->name_en : 'N/A' }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $skill->level }}%; background-color: var(--scheme1);" 
                                         aria-valuenow="{{ $skill->level }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $skill->level }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($skill->description_en, 30) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $skill->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editSkillModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this skill?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No skills found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Skill Modal -->
<div class="modal fade" id="createSkillModal" tabindex="-1" aria-labelledby="createSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSkillModalLabel">Add New Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_en" class="form-label">Skill Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_en" name="name_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name_ar" class="form-label">Skill Name (Arabic)</label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Skill Level (%) <span class="text-danger">*</span></label>
                        <input type="range" class="form-range" id="level" name="level" min="1" max="100" value="80">
                        <div class="d-flex justify-content-between">
                            <span>1%</span>
                            <span id="levelValue">80%</span>
                            <span>100%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                        <div class="form-text">Recommended size: Square (e.g., 128x128px)</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description_en" class="form-label">Description (English)</label>
                            <textarea class="form-control" id="description_en" name="description_en" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="description_ar" class="form-label">Description (Arabic)</label>
                            <textarea class="form-control" id="description_ar" name="description_ar" rows="3" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Skill</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Skill Modal -->
<div class="modal fade" id="editSkillModal" tabindex="-1" aria-labelledby="editSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editSkillForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSkillModalLabel">Edit Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name_en" class="form-label">Skill Name (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name_en" name="name_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_name_ar" class="form-label">Skill Name (Arabic)</label>
                            <input type="text" class="form-control" id="edit_name_ar" name="name_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_level" class="form-label">Skill Level (%) <span class="text-danger">*</span></label>
                        <input type="range" class="form-range" id="edit_level" name="level" min="1" max="100" value="80">
                        <div class="d-flex justify-content-between">
                            <span>1%</span>
                            <span id="edit_levelValue">80%</span>
                            <span>100%</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_icon" class="form-label">Icon</label>
                        <div class="mb-2" id="current_icon_container" style="display: none;">
                            <p>Current icon:</p>
                            <img id="current_icon" src="" alt="Current Icon" style="max-height: 100px;">
                        </div>
                        <input type="file" class="form-control" id="edit_icon" name="icon" accept="image/*">
                        <div class="form-text">Leave empty to keep current icon. Recommended size: Square (e.g., 128x128px)</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_description_en" class="form-label">Description (English)</label>
                            <textarea class="form-control" id="edit_description_en" name="description_en" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_description_ar" class="form-label">Description (Arabic)</label>
                            <textarea class="form-control" id="edit_description_ar" name="description_ar" rows="3" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Skill</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Update level value display
    document.getElementById('level').addEventListener('input', function() {
        document.getElementById('levelValue').textContent = this.value + '%';
    });
    
    document.getElementById('edit_level').addEventListener('input', function() {
        document.getElementById('edit_levelValue').textContent = this.value + '%';
    });

    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch skill data
            fetch(`/admin/skills/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editSkillForm').action = `/admin/skills/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_name_en').value = data.name_en;
                    document.getElementById('edit_name_ar').value = data.name_ar || '';
                    document.getElementById('edit_category_id').value = data.category_id;
                    document.getElementById('edit_level').value = data.level;
                    document.getElementById('edit_levelValue').textContent = data.level + '%';
                    document.getElementById('edit_description_en').value = data.description_en || '';
                    document.getElementById('edit_description_ar').value = data.description_ar || '';
                    
                    // Show current icon if available
                    if (data.icon) {
                        document.getElementById('current_icon').src = `/storage/${data.icon}`;
                        document.getElementById('current_icon_container').style.display = 'block';
                    } else {
                        document.getElementById('current_icon_container').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching skill data:', error));
        });
    });
</script>
@endsection