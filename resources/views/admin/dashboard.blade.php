@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success"><strong>✓</strong> {{ session('success') }}</div>
@endif

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card total">
        <div class="stat-label">Total Requests</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-icon">📊</div>
    </div>
    <div class="stat-card pending">
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
        <div class="stat-icon">⏳</div>
    </div>
    <div class="stat-card processing">
        <div class="stat-label">Processing</div>
        <div class="stat-value">{{ $stats['processing'] }}</div>
        <div class="stat-icon">⚙️</div>
    </div>
    <div class="stat-card completed">
        <div class="stat-label">Completed</div>
        <div class="stat-value">{{ $stats['completed'] }}</div>
        <div class="stat-icon">✓</div>
    </div>
</div>

<!-- Filters -->
<div class="table-container">
    <div class="table-header">
        <h2>Recent Requests</h2>
        <div class="table-filters">
            <select class="filter-select" onchange="window.location.href='?status='+this.value+'&type={{ $filterType }}'">
                <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending"    {{ $filterStatus === 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $filterStatus === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed"  {{ $filterStatus === 'completed'  ? 'selected' : '' }}>Completed</option>
                <option value="rejected"   {{ $filterStatus === 'rejected'   ? 'selected' : '' }}>Rejected</option>
            </select>
            <select class="filter-select" onchange="window.location.href='?status={{ $filterStatus }}&type='+this.value">
                <option value="all"            {{ $filterType === 'all'            ? 'selected' : '' }}>All Types</option>
                <option value="new_connection"  {{ $filterType === 'new_connection'  ? 'selected' : '' }}>New Connection</option>
                <option value="reconnection"    {{ $filterType === 'reconnection'    ? 'selected' : '' }}>Reconnection</option>
                <option value="senior_discount" {{ $filterType === 'senior_discount' ? 'selected' : '' }}>Senior Discount</option>
                <option value="change_info"     {{ $filterType === 'change_info'     ? 'selected' : '' }}>Change Info</option>
                <option value="change_meter"    {{ $filterType === 'change_meter'    ? 'selected' : '' }}>Change Meter</option>
                <option value="net_metering"    {{ $filterType === 'net_metering'    ? 'selected' : '' }}>Net Metering</option>
                <option value="no_power"        {{ $filterType === 'no_power'        ? 'selected' : '' }}>No Power</option>
            </select>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Customer</th>
                <th>Account #</th>
                <th>Contact</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($serviceRequests as $req)
                <tr>
                    <td><strong>#{{ $req->id }}</strong></td>
                    <td>{{ ucwords(str_replace('_', ' ', $req->request_type)) }}</td>
                    <td>{{ $req->customer_name }}</td>
                    <td>{{ $req->account_number }}</td>
                    <td>{{ $req->contact_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ $req->status }}">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-sm btn-view">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">📭</div>
                            <h3>No requests found</h3>
                            <p>There are no requests matching your filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection