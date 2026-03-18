@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Message Details</h2>
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Back to Inbox</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $message->subject ?? 'No Subject' }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">From: {{ $message->name }} &lt;{{ $message->email }}&gt;</h6>
            <p class="card-text" style="white-space:pre-wrap;">{{ $message->message }}</p>
            <p class="text-muted">Received: {{ $message->created_at->format('Y-m-d H:i') }}</p>
            <p>
                @if(is_null($message->read_at))
                    <span class="badge bg-danger">Unread</span>
                @else
                    <span class="badge bg-success">Read</span>
                @endif
            </p>
        </div>
    </div>
</div>

@endsection
