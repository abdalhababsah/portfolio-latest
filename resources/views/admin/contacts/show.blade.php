@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">View Message</h4>
            <div>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Messages
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">{{ $contact->subject }}</h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="badge bg-info">Received: {{ $contact->created_at->format('d/m/Y H:i') }}</span>
                    
                    @if($contact->read_at)
                        <span class="badge bg-success ms-2">Read: {{ $contact->read_at->format('d/m/Y H:i') }}</span>
                    @else
                        <span class="badge bg-warning ms-2">Unread</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">From:</h6>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $contact->name }}</div>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                        <i class="fas fa-reply me-2"></i>Reply via Email
                    </a>
                </div>
            </div>

            <div class="message-content p-4 bg-light rounded">
                <div class="message-body" style="white-space: pre-line;">
                    {{ $contact->message }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this message? This cannot be undone.')">
                        <i class="fas fa-trash me-2"></i>Delete Message
                    </button>
                </form>
                
                <div>
                    @if($contact->created_at)
                    <small class="text-muted">Message ID: {{ $contact->id }} • IP: {{ $contact->ip_address ?? 'N/A' }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection