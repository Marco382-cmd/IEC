@extends('admin.layouts.app')

@section('title', 'Request #' . $request->id)
@section('page-title', 'Request #' . str_pad($request->id, 5, '0', STR_PAD_LEFT))

@section('content')

@if(session('success'))
    <div class="alert alert-success"><strong>✓</strong> {{ session('success') }}</div>
@endif

<div class="content-grid">

    {{-- Customer Info --}}
    <div class="info-card customer-card">
        <div class="card-header">
            <h2>Customer Information</h2>
        </div>
        <div class="card-body">
            <div class="info-item">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $request->customer_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Account Number</span>
                <span class="info-value">{{ $request->account_number }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact Number</span>
                <span class="info-value">{{ $request->contact_number }}</span>
            </div>
            @if($request->email)
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $request->email }}</span>
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $request->address }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Request Type</span>
                <span class="info-value">{{ ucwords(str_replace('_', ' ', $request->request_type)) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="status-badge status-{{ $request->status }}">{{ ucfirst($request->status) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Submitted</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>

    {{-- Uploaded Files --}}
    @if($details)
    <div class="info-card" style="margin-top: 1.5rem;">
        <div class="card-header">
            <h2>Uploaded Documents & Details</h2>
        </div>
        <div class="card-body">
            @php
                $skip = ['id', 'request_id', 'created_at', 'updated_at',
                         'account_number', 'customer_name', 'contact_number',
                         'email', 'address', 'seminar_attended', 'seminar_date',
                         'bills_paid', 'reconnection_fee_paid', 'personal_appearance'];
                $fileExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
            @endphp

            @foreach((array)$details as $key => $value)
                @if(!in_array($key, $skip) && $value !== null && $value !== '')
                    @php
                        $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                        $isFile = in_array($ext, $fileExtensions);
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                    @endphp
                    <div class="info-item" style="margin-bottom: 1.5rem;">
                        <span class="info-label">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                        <span class="info-value">
                            @if($isImage)
                                <div style="margin-top: 0.5rem;">
                                    <img src="{{ asset('storage/' . $value) }}"
                                         alt="{{ $key }}"
                                         style="max-width: 300px; max-height: 200px; border-radius: 8px; border: 1px solid #e5e7eb; cursor: pointer;"
                                         onclick="window.open('{{ asset('storage/' . $value) }}', '_blank')">
                                    <br>
                                    <a href="{{ asset('storage/' . $value) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-view"
                                       style="margin-top: 0.5rem; display: inline-block;">
                                        🔍 View Full Size
                                    </a>
                                </div>
                            @elseif($ext === 'pdf')
                                <a href="{{ asset('storage/' . $value) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-view">
                                    📄 View PDF
                                </a>
                            @else
                                {{ $value }}
                            @endif
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @else
        <div class="info-card" style="margin-top: 1.5rem;">
            <div class="card-body">
                <p style="color: #6b7280;">No additional details found for this request.</p>
            </div>
        </div>
    @endif

    {{-- Admin Notes --}}
    @if($request->admin_notes)
    <div class="info-card" style="margin-top: 1.5rem;">
        <div class="card-header"><h2>Admin Notes</h2></div>
        <div class="card-body">
            <p>{{ $request->admin_notes }}</p>
        </div>
    </div>
    @endif

    {{-- Update Form --}}
    <div class="info-card" style="margin-top: 1.5rem;">
        <div class="card-header"><h2>Update Request</h2></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.requests.update', $request->id) }}">
                @csrf
                <div class="form-group">
                    <label>Update Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending"    {{ $request->status === 'pending'    ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="processing" {{ $request->status === 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                        <option value="completed"  {{ $request->status === 'completed'  ? 'selected' : '' }}>✅ Completed</option>
                        <option value="rejected"   {{ $request->status === 'rejected'   ? 'selected' : '' }}>❌ Rejected</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Admin Notes</label>
                    <textarea name="admin_notes" class="form-control" rows="4"
                        placeholder="Add internal notes...">{{ $request->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.requests') }}" class="btn btn-secondary" style="margin-left: 0.5rem;">← Back</a>
            </form>
        </div>
    </div>

</div>
@endsection