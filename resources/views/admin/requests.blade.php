@extends('admin.layouts.app')

@section('title', 'All Requests')
@section('page-title', 'All Service Requests')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h2>Complete Request List</h2>
        <input type="text" id="searchInput" placeholder="Search requests..." class="form-control"
            style="max-width:300px;" onkeyup="searchRequests()">
    </div>

    <table class="data-table" id="requestsTable">
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
            @foreach($serviceRequests as $req)
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
            @endforeach
        </tbody>
    </table>
</div>

<script>
function searchRequests() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows  = document.querySelectorAll('#requestsTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endsection