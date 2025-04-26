@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Site Settings</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSettingModal">
                Add New Setting
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
                            <th>ID</th>
                            <th>Key</th>
                            <th>English Value</th>
                            <th>Arabic Value</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                        <tr>
                            <td>{{ $setting->id }}</td>
                            <td>{{ $setting->key_name }}</td>
                            <td>
                                @if(str_starts_with($setting->key_name, 'profile_image'))
                                    <img src="{{ asset('storage/'.$setting->value_en) }}" alt="Profile" style="height:50px; object-fit:cover;">
                                @else
                                    {{ \Illuminate\Support\Str::limit($setting->value_en, 50) }}
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($setting->value_ar, 50) }}</td>
                            <td>{{ $setting->created_at ? $setting->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $setting->id }}"
                                    data-key="{{ $setting->key_name }}"
                                    data-value-en="{{ $setting->value_en }}"
                                    data-value-ar="{{ $setting->value_ar }}"
                                    data-bs-toggle="modal" data-bs-target="#editSettingModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.site-settings.destroy', $setting->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this setting?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No settings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Setting Modal -->
<div class="modal fade" id="createSettingModal" tabindex="-1" aria-labelledby="createSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.site-settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSettingModalLabel">Add New Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="key_name" class="form-label">Setting Key</label>
                        <select class="form-select" id="key_name" name="key_name" required>
                            <option value="">Select a key</option>
                            <option value="profile_image">Profile Image</option>
                            <option value="about_me">About Me</option>
                            <option value="email">Email</option>
                            <option value="hero_heading">Hero Heading</option>
                            <option value="hero_tagline">Hero Tagline</option>
                            <option value="site_title">Site Title</option>
                            <option value="cv_url">CV URL</option>
                        </select>
                    </div>

                    <!-- Profile Image Fields -->
                    <div class="mb-3 setting-field" id="profile_image_field" style="display: none;">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                        <small class="text-muted">Recommended size: 500x500px</small>
                    </div>

                    <!-- About Me Fields -->
                    <div class="setting-field" id="about_me_field" style="display: none;">
                        <div class="mb-3">
                            <label for="about_me_en" class="form-label">About Me (English)</label>
                            <textarea class="form-control" id="about_me_en" name="about_me_en" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="about_me_ar" class="form-label">About Me (Arabic)</label>
                            <textarea class="form-control" id="about_me_ar" name="about_me_ar" rows="4" dir="rtl"></textarea>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3 setting-field" id="email_field" style="display: none;">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <!-- Hero Heading Fields -->
                    <div class="setting-field" id="hero_heading_field" style="display: none;">
                        <div class="mb-3">
                            <label for="hero_heading_en" class="form-label">Hero Heading (English)</label>
                            <input type="text" class="form-control" id="hero_heading_en" name="hero_heading_en">
                        </div>
                        <div class="mb-3">
                            <label for="hero_heading_ar" class="form-label">Hero Heading (Arabic)</label>
                            <input type="text" class="form-control" id="hero_heading_ar" name="hero_heading_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- Hero Tagline Fields -->
                    <div class="setting-field" id="hero_tagline_field" style="display: none;">
                        <div class="mb-3">
                            <label for="hero_tagline_en" class="form-label">Hero Tagline (English)</label>
                            <input type="text" class="form-control" id="hero_tagline_en" name="hero_tagline_en">
                        </div>
                        <div class="mb-3">
                            <label for="hero_tagline_ar" class="form-label">Hero Tagline (Arabic)</label>
                            <input type="text" class="form-control" id="hero_tagline_ar" name="hero_tagline_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- Site Title Fields -->
                    <div class="setting-field" id="site_title_field" style="display: none;">
                        <div class="mb-3">
                            <label for="site_title_en" class="form-label">Site Title (English)</label>
                            <input type="text" class="form-control" id="site_title_en" name="site_title_en">
                        </div>
                        <div class="mb-3">
                            <label for="site_title_ar" class="form-label">Site Title (Arabic)</label>
                            <input type="text" class="form-control" id="site_title_ar" name="site_title_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- CV URL Field -->
                    <div class="mb-3 setting-field" id="cv_url_field" style="display: none;">
                        <label for="cv_url" class="form-label">CV URL</label>
                        <input type="text" class="form-control" id="cv_url" name="cv_url" placeholder="https://example.com/cv.pdf">
                        <small class="text-muted">Enter the full URL to your CV file</small>
                    </div>

                    <!-- Default Value Fields -->
                    <div class="mb-3 setting-field" id="default_value_field">
                        <div class="mb-3">
                            <label for="value_en" class="form-label">Value (English)</label>
                            <input type="text" class="form-control" id="value_en" name="value_en">
                        </div>
                        <div class="mb-3">
                            <label for="value_ar" class="form-label">Value (Arabic)</label>
                            <input type="text" class="form-control" id="value_ar" name="value_ar" dir="rtl">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Setting Modal -->
<div class="modal fade" id="editSettingModal" tabindex="-1" aria-labelledby="editSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editSettingForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSettingModalLabel">Edit Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_key_name" class="form-label">Setting Key</label>
                        <input type="text" class="form-control" id="edit_key_name" name="key_name" readonly>
                    </div>

                    <!-- Profile Image Fields -->
                    <div class="mb-3 edit-setting-field" id="edit_profile_image_field" style="display: none;">
                        <label for="edit_profile_image" class="form-label">Profile Image</label>
                        <div class="mb-2" id="current_image_container" style="display: none;">
                            <p>Current image:</p>
                            <img id="current_image" src="" alt="Current Profile" style="max-height: 100px;">
                        </div>
                        <input type="file" class="form-control" id="edit_profile_image" name="profile_image">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <!-- About Me Fields -->
                    <div class="edit-setting-field" id="edit_about_me_field" style="display: none;">
                        <div class="mb-3">
                            <label for="edit_about_me_en" class="form-label">About Me (English)</label>
                            <textarea class="form-control" id="edit_about_me_en" name="about_me_en" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_about_me_ar" class="form-label">About Me (Arabic)</label>
                            <textarea class="form-control" id="edit_about_me_ar" name="about_me_ar" rows="4" dir="rtl"></textarea>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3 edit-setting-field" id="edit_email_field" style="display: none;">
                        <label for="edit_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>

                    <!-- Hero Heading Fields -->
                    <div class="edit-setting-field" id="edit_hero_heading_field" style="display: none;">
                        <div class="mb-3">
                            <label for="edit_hero_heading_en" class="form-label">Hero Heading (English)</label>
                            <input type="text" class="form-control" id="edit_hero_heading_en" name="hero_heading_en">
                        </div>
                        <div class="mb-3">
                            <label for="edit_hero_heading_ar" class="form-label">Hero Heading (Arabic)</label>
                            <input type="text" class="form-control" id="edit_hero_heading_ar" name="hero_heading_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- Hero Tagline Fields -->
                    <div class="edit-setting-field" id="edit_hero_tagline_field" style="display: none;">
                        <div class="mb-3">
                            <label for="edit_hero_tagline_en" class="form-label">Hero Tagline (English)</label>
                            <input type="text" class="form-control" id="edit_hero_tagline_en" name="hero_tagline_en">
                        </div>
                        <div class="mb-3">
                            <label for="edit_hero_tagline_ar" class="form-label">Hero Tagline (Arabic)</label>
                            <input type="text" class="form-control" id="edit_hero_tagline_ar" name="hero_tagline_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- Site Title Fields -->
                    <div class="edit-setting-field" id="edit_site_title_field" style="display: none;">
                        <div class="mb-3">
                            <label for="edit_site_title_en" class="form-label">Site Title (English)</label>
                            <input type="text" class="form-control" id="edit_site_title_en" name="site_title_en">
                        </div>
                        <div class="mb-3">
                            <label for="edit_site_title_ar" class="form-label">Site Title (Arabic)</label>
                            <input type="text" class="form-control" id="edit_site_title_ar" name="site_title_ar" dir="rtl">
                        </div>
                    </div>

                    <!-- CV URL Field -->
                    <div class="mb-3 edit-setting-field" id="edit_cv_url_field" style="display: none;">
                        <label for="edit_cv_url" class="form-label">CV URL</label>
                        <input type="text" class="form-control" id="edit_cv_url" name="cv_url" placeholder="https://example.com/cv.pdf">
                        <small class="text-muted">Enter the full URL to your CV file</small>
                    </div>

                    <!-- Default Value Fields -->
                    <div class="edit-setting-field" id="edit_default_value_field">
                        <div class="mb-3">
                            <label for="edit_value_en" class="form-label">Value (English)</label>
                            <input type="text" class="form-control" id="edit_value_en" name="value_en">
                        </div>
                        <div class="mb-3">
                            <label for="edit_value_ar" class="form-label">Value (Arabic)</label>
                            <input type="text" class="form-control" id="edit_value_ar" name="value_ar" dir="rtl">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Handle create modal field visibility based on key selection
    document.getElementById('key_name').addEventListener('change', function() {
        // Hide all fields first
        document.querySelectorAll('.setting-field').forEach(field => {
            field.style.display = 'none';
        });

        // Show relevant fields based on selection
        const selectedKey = this.value;
        if (selectedKey === 'profile_image') {
            document.getElementById('profile_image_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'about_me') {
            document.getElementById('about_me_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'email') {
            document.getElementById('email_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'hero_heading') {
            document.getElementById('hero_heading_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'hero_tagline') {
            document.getElementById('hero_tagline_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'site_title') {
            document.getElementById('site_title_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else if (selectedKey === 'cv_url') {
            document.getElementById('cv_url_field').style.display = 'block';
            document.getElementById('default_value_field').style.display = 'none';
        } else {
            document.getElementById('default_value_field').style.display = 'block';
        }
    });

    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const key = this.getAttribute('data-key');
            const valueEn = this.getAttribute('data-value-en');
            const valueAr = this.getAttribute('data-value-ar');
            
            // Update form action URL
            document.getElementById('editSettingForm').action = `/admin/site-settings/${id}`;
            
            // Set form values
            document.getElementById('edit_key_name').value = key;
            
            // Hide all fields first
            document.querySelectorAll('.edit-setting-field').forEach(field => {
                field.style.display = 'none';
            });
            
            // Show relevant fields based on key
            if (key.startsWith('profile_image')) {
                document.getElementById('edit_profile_image_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                
                // Show current image if available
                if (valueEn) {
                    document.getElementById('current_image').src = `/storage/${valueEn}`;
                    document.getElementById('current_image_container').style.display = 'block';
                }
            } else if (key.startsWith('about_me')) {
                document.getElementById('edit_about_me_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_about_me_en').value = valueEn;
                document.getElementById('edit_about_me_ar').value = valueAr;
            } else if (key.startsWith('email')) {
                document.getElementById('edit_email_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_email').value = valueEn;
            } else if (key.startsWith('hero_heading')) {
                document.getElementById('edit_hero_heading_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_hero_heading_en').value = valueEn;
                document.getElementById('edit_hero_heading_ar').value = valueAr;
            } else if (key.startsWith('hero_tagline')) {
                document.getElementById('edit_hero_tagline_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_hero_tagline_en').value = valueEn;
                document.getElementById('edit_hero_tagline_ar').value = valueAr;
            } else if (key.startsWith('site_title')) {
                document.getElementById('edit_site_title_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_site_title_en').value = valueEn;
                document.getElementById('edit_site_title_ar').value = valueAr;
            } else if (key.startsWith('cv_url')) {
                document.getElementById('edit_cv_url_field').style.display = 'block';
                document.getElementById('edit_default_value_field').style.display = 'none';
                document.getElementById('edit_cv_url').value = valueEn;
            } else {
                document.getElementById('edit_default_value_field').style.display = 'block';
                document.getElementById('edit_value_en').value = valueEn;
                document.getElementById('edit_value_ar').value = valueAr;
            }
        });
    });
</script>
@endsection