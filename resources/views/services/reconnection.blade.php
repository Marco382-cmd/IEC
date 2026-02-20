@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            <strong>✓</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <strong>✕</strong> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <a href="{{ route('welcome') }}" class="btn btn-secondary" style="margin-bottom: 1rem;">← Back</a>

        <div class="form-header">
            <h2>Reconnection / Disconnection Request</h2>
            <p>Submit your meter reconnection or disconnection request</p>
        </div>

        <div class="requirements-list">
            <h4>Steps for Reconnection:</h4>
            <ul>
                <li>Attend a Seminar</li>
                <li>Pay your bills and the reconnection fee</li>
                <li>Proceed to CWD and give the copy of receipt</li>
                <li>Wait for job order issuance</li>
                <li>Technical Department will verify and process</li>
                <li>Maintenance will install the meter</li>
            </ul>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('services.reconnection.store') }}">
            @csrf

            <div class="form-group">
                <label>Account Number <span class="required">*</span></label>
                <input type="text" name="account_number" class="form-control" required value="{{ old('account_number') }}">
            </div>

            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="customer_name" class="form-control" required value="{{ old('customer_name') }}">
            </div>

            <div class="form-group">
                <label>Contact Number <span class="required">*</span></label>
                <input type="tel" name="contact_number" class="form-control" required value="{{ old('contact_number') }}">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Address <span class="required">*</span></label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Upload Payment Receipt</h3>

            <div class="form-group">
                <label>Payment Receipt (After payment)</label>
                <input type="file" name="payment_receipt" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">PDF, JPG, PNG (Max 5MB)</small>
            </div>

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: Please attend the seminar before submitting this request.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Request</button>
        </form>
    </div>
</div>
@endsection