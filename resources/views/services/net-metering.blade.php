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
            <h2>Net Metering Application</h2>
            <p>Apply for net metering if you have solar or renewable energy systems</p>
        </div>

        <form method="POST" action="{{ route('services.net-metering.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Account Number <span class="required">*</span></label>
                <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror"
                    required value="{{ old('account_number') }}">
                @error('account_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                    required value="{{ old('customer_name') }}">
                @error('customer_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Contact Number <span class="required">*</span></label>
                <input type="tel" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror"
                    required value="{{ old('contact_number') }}">
                @error('contact_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Address <span class="required">*</span></label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                    required>{{ old('address') }}</textarea>
                @error('address')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>System Capacity (kW) <span class="required">*</span></label>
                <input type="text" name="system_capacity" class="form-control @error('system_capacity') is-invalid @enderror"
                    required placeholder="e.g., 5kW" value="{{ old('system_capacity') }}">
                @error('system_capacity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Installation Details <span class="required">*</span></label>
                <textarea name="installation_details" class="form-control @error('installation_details') is-invalid @enderror"
                    required placeholder="Describe your solar/renewable energy system installation">{{ old('installation_details') }}</textarea>
                @error('installation_details')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Supporting Documents</label>
                <div class="file-upload">
                    <input type="file" name="documents" id="documents" accept=".pdf,.jpg,.jpeg,.png">
                    <label for="documents" class="file-upload-label">
                        <strong>Upload</strong> system specs, permits, etc.<br>
                        <small>PDF, JPG, PNG – Max 5MB</small>
                    </label>
                </div>
                @error('documents')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: Your application will be reviewed by our technical team. Processing may take 5–10 business days.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
        </form>
    </div>
</div>
@endsection