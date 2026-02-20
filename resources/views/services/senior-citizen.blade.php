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

    <div class="form-container">

    <a href="{{ route('welcome') }}" class="btn btn-secondary" style="margin-bottom: 1rem;">← Back</a>
    
        <div class="form-header">
            <h2>Senior Citizen Discount Application</h2>
            <p>Apply for your senior citizen electricity discount</p>
        </div>

        <div class="requirements-list">
            <h4>Required Documents:</h4>
            <ul>
                <li>Barangay Clearance</li>
                <li>Photocopy of Senior ID Card</li>
                <li>Billing Receipt</li>
                <li>Authorization letter (if disabled)</li>
                <li>Personal Appearance</li>
            </ul>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('services.senior-citizen.store') }}">
            @csrf

            <div class="form-group">
                <label>Account Number <span class="required">*</span></label>
                <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" required>
            </div>

            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
            </div>

            <div class="form-group">
                <label>Contact Number <span class="required">*</span></label>
                <input type="tel" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Address <span class="required">*</span></label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Upload Requirements</h3>

            @php
                $files = [
                    'brgy_clearance' => 'Barangay Clearance',
                    'senior_id' => 'Senior Citizen ID',
                    'billing_receipt' => 'Billing Receipt',
                    'authorization' => 'Authorization Letter (if disabled)'
                ];
            @endphp

            @foreach($files as $field => $label)
                <div class="form-group">
                    <label>{{ $label }} @if($field !== 'authorization') <span class="required">*</span> @endif</label>
                    <input type="file" name="{{ $field }}" class="form-control" @if($field !== 'authorization') required @endif>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
        </form>
    </div>
</div>
@endsection
