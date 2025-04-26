@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Testimonials</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
                Add Testimonial
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
                            <th style="width: 80px;">Photo</th>
                            <th>Client</th>
                            <th>Message</th>
                            <th>Rating</th>
                            <th>Date</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->id }}</td>
                            <td>
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/'.$testimonial->image) }}" alt="{{ $testimonial->name }}" 
                                         class="img-thumbnail rounded-circle" style="height:50px; width:50px; object-fit:cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle" 
                                         style="height:50px; width:50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $testimonial->name }}</div>
                                <small class="text-muted">{{ $testimonial->role }}</small>
                            </td>
                            <td>
                                <div>{{ \Illuminate\Support\Str::limit($testimonial->message_en, 80) }}</div>
                                @if($testimonial->message_ar)
                                    <small class="text-muted" dir="rtl">{{ \Illuminate\Support\Str::limit($testimonial->message_ar, 80) }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $testimonial->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">{{ $testimonial->rating }}/5</span>
                                </div>
                            </td>
                            <td>{{ $testimonial->date_given->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $testimonial->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editTestimonialModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this testimonial?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No testimonials found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Testimonial Modal -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1" aria-labelledby="createTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTestimonialModalLabel">Add New Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Client Role/Company <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="role" name="role" required placeholder="e.g. CEO at Company">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-2" id="rating" name="rating" min="1" max="5" value="5">
                                <div id="rating-display" class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-2 text-dark">5/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="date_given" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date_given" name="date_given" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Client Photo</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Recommended: Square image (1:1 ratio)</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="message_en" class="form-label">Testimonial (English) <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message_en" name="message_en" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="message_ar" class="form-label">Testimonial (Arabic)</label>
                            <textarea class="form-control" id="message_ar" name="message_ar" rows="5" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Testimonial Modal -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestimonialModalLabel">Edit Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Client Role/Company <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_role" name="role" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-2" id="edit_rating" name="rating" min="1" max="5" value="5">
                                <div id="edit_rating-display" class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-2 text-dark">5/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_date_given" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_date_given" name="date_given" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Client Photo</label>
                        <div id="current_image_container" class="mb-2" style="display: none;">
                            <p>Current photo:</p>
                            <img id="current_image" src="" alt="Current Photo" style="max-height: 100px; border-radius: 50%;">
                        </div>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="form-text">Leave empty to keep current photo. Recommended: Square image (1:1 ratio)</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_message_en" class="form-label">Testimonial (English) <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_message_en" name="message_en" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_message_ar" class="form-label">Testimonial (Arabic)</label>
                            <textarea class="form-control" id="edit_message_ar" name="message_ar" rows="5" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
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

    // Rating display for create form
    document.getElementById('rating').addEventListener('input', function() {
        updateRatingDisplay(this.value, 'rating-display');
    });

    // Rating display for edit form
    document.getElementById('edit_rating').addEventListener('input', function() {
        updateRatingDisplay(this.value, 'edit_rating-display');
    });

    // Rating display helper function
    function updateRatingDisplay(value, displayId) {
        const display = document.getElementById(displayId);
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= value) {
                stars += '<i class="fas fa-star"></i>';
            } else {
                stars += '<i class="far fa-star"></i>';
            }
        }
        stars += `<span class="ms-2 text-dark">${value}/5</span>`;
        display.innerHTML = stars;
    }

    // Handle edit button clicks
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch testimonial data
            fetch(`/admin/testimonials/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editTestimonialForm').action = `/admin/testimonials/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_role').value = data.role;
                    document.getElementById('edit_rating').value = data.rating;
                    document.getElementById('edit_date_given').value = formatDateForInput(data.date_given);
                    document.getElementById('edit_message_en').value = data.message_en;
                    document.getElementById('edit_message_ar').value = data.message_ar || '';
                    
                    // Update rating display
                    updateRatingDisplay(data.rating, 'edit_rating-display');
                    
                    // Show current image if available
                    if (data.image) {
                        document.getElementById('current_image').src = `/storage/${data.image}`;
                        document.getElementById('current_image_container').style.display = 'block';
                    } else {
                        document.getElementById('current_image_container').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching testimonial data:', error));
        });
    });
</script>
@endsection