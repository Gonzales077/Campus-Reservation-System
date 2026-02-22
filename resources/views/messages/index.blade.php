@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Messages</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if($messages->isEmpty())
        <div class="alert alert-info">No messages yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject }}</td>
                        <td style="max-width:420px; white-space:pre-wrap;">{{ Str::limit($message->message, 120) }}</td>
                        <td>
                            @if(is_null($message->read_at))
                                <span class="badge bg-danger">Unread</span>
                            @else
                                <span class="badge bg-success">Read</span>
                            @endif
                        </td>
                        <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
