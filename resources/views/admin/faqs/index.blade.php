@extends('admin.layout.app')

@section('styles')
<style>
    .faq-item {
        cursor: grab;
        transition: all 0.2s;
    }
    .faq-item:hover {
        background-color: #f8f9fa;
    }
    .faq-item.dragging {
        opacity: 0.5;
        background-color: #e9ecef;
        cursor: grabbing;
    }
    .sortable-ghost {
        background-color: #e9ecef;
        border: 2px dashed #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">FAQs</h4>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createFaqModal">
                Add FAQ
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
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>Frequently Asked Questions</span>
                <div>
                    <small class="text-muted me-2">Drag and drop to reorder</small>
                    <button id="save-order" class="btn btn-sm btn-primary" style="display: none;">Save Order</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Date Added</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="faq-list">
                        @forelse($faqs as $faq)
                        <tr class="faq-item" data-id="{{ $faq->id }}">
                            <td>
                                <span class="badge bg-secondary">{{ $faq->display_order }}</span>
                                <i class="fas fa-grip-vertical ms-2 text-muted"></i>
                            </td>
                            <td>
                                <div>{{ $faq->question_en }}</div>
                                @if($faq->question_ar)
                                    <small class="text-muted" dir="rtl">{{ $faq->question_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <div>{{ \Illuminate\Support\Str::limit(strip_tags($faq->answer_en), 100) }}</div>
                                @if($faq->answer_ar)
                                    <small class="text-muted" dir="rtl">{{ \Illuminate\Support\Str::limit(strip_tags($faq->answer_ar), 100) }}</small>
                                @endif
                            </td>
                            <td>{{ $faq->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                    data-id="{{ $faq->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editFaqModal">
                                    Edit
                                </button>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this FAQ?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No FAQs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create FAQ Modal -->
<div class="modal fade" id="createFaqModal" tabindex="-1" aria-labelledby="createFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createFaqModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="question_en" class="form-label">Question (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="question_en" name="question_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="question_ar" class="form-label">Question (Arabic)</label>
                            <input type="text" class="form-control" id="question_ar" name="question_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="answer_en" class="form-label">Answer (English) <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="answer_en" name="answer_en" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="answer_ar" class="form-label">Answer (Arabic)</label>
                            <textarea class="form-control" id="answer_ar" name="answer_ar" rows="5" dir="rtl"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="{{ $faqs->count() + 1 }}" min="1">
                        <div class="form-text">Lower numbers appear first. You can also drag and drop to reorder after creating.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFaqForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_question_en" class="form-label">Question (English) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_question_en" name="question_en" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_question_ar" class="form-label">Question (Arabic)</label>
                            <input type="text" class="form-control" id="edit_question_ar" name="question_ar" dir="rtl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_answer_en" class="form-label">Answer (English) <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_answer_en" name="answer_en" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_answer_ar" class="form-label">Answer (Arabic)</label>
                            <textarea class="form-control" id="edit_answer_ar" name="answer_ar" rows="5" dir="rtl"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_display_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_display_order" name="display_order" min="1">
                        <div class="form-text">Lower numbers appear first. You can also drag and drop to reorder after saving.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    // Initialize Sortable.js
    const faqList = document.getElementById('faq-list');
    if (faqList) {
        const sortable = new Sortable(faqList, {
            animation: 150,
            handle: '.fa-grip-vertical',
            ghostClass: 'sortable-ghost',
            onStart: function(evt) {
                evt.item.classList.add('dragging');
                document.getElementById('save-order').style.display = 'inline-block';
            },
            onEnd: function(evt) {
                evt.item.classList.remove('dragging');
            }
        });
    }

    // Save reordered items
    document.getElementById('save-order').addEventListener('click', function() {
        const items = Array.from(document.querySelectorAll('.faq-item')).map(item => item.dataset.id);
        
        fetch('{{ route("admin.faqs.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error saving order:', error));
    });

    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Fetch FAQ data
            fetch(`/admin/faqs/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Update form action URL
                    document.getElementById('editFaqForm').action = `/admin/faqs/${id}`;
                    
                    // Set form values
                    document.getElementById('edit_question_en').value = data.question_en;
                    document.getElementById('edit_question_ar').value = data.question_ar || '';
                    document.getElementById('edit_answer_en').value = data.answer_en;
                    document.getElementById('edit_answer_ar').value = data.answer_ar || '';
                    document.getElementById('edit_display_order').value = data.display_order;
                })
                .catch(error => console.error('Error fetching FAQ data:', error));
        });
    });
</script>
@endsection