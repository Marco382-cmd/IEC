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
        <h2>New Connection Request</h2>
        <p>Please fill out all required information and upload necessary documents</p>
    </div>

        <div class="requirements-list">
            <h4>Required Documents:</h4>
            <ul>
                <li>Electrical Plan Layout</li>
                <li>Certificate of Final Electrical Inspection</li>
                <li>Fire Safety Inspection Certificate</li>
                <li>Photocopy of Cedula</li>
                <li>Tax Declaration of Real Property</li>
                <li>Kasunduan sa may ari ng lupa (Notarized)</li>
                <li>Building Permit (Optional)</li>
                <li>Seminar Attendance (Every Wednesday and Friday 1:00PM)</li>
            </ul>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('services.new-connection.store') }}">
            @csrf

            <div class="form-group">
                <label>Account Number <span class="required">*</span></label>
                <input type="text" name="account_number" class="form-control" placeholder="Enter your account number or leave blank">
            </div>

            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Contact Number <span class="required">*</span></label>
                <input type="tel" name="contact_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label>Property Address <span class="required">*</span></label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Upload Requirements</h3>

            @php
                $files = [
                    'electrical_plan' => 'Electrical Plan Layout',
                    'final_inspection' => 'Certificate of Final Electrical Inspection',
                    'fire_safety' => 'Fire Safety Inspection Certificate',
                    'cedula' => 'Photocopy of Cedula',
                    'tax_declaration' => 'Tax Declaration of Real Property',
                    'kasunduan' => 'Kasunduan sa may ari ng lupa (Notarized)',
                    'building_permit' => 'Building Permit (Optional)'
                ];
            @endphp

            @foreach($files as $field => $label)
                <div class="form-group">
                    <label>{{ $label }} @if($field !== 'building_permit') <span class="required">*</span> @endif</label>
                    <input type="file" name="{{ $field }}" class="form-control" @if($field !== 'building_permit') required @endif>
                </div>
            @endforeach

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: After submitting this form, you must attend a seminar held every Wednesday and Friday at 1:00 PM.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Request</button>
        </form>
    </div>
</div>
@endsection
