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
            <h2>Report Power Outage</h2>
            <p>Report electrical issues or power outages in your area</p>
        </div>

        <div class="alert alert-info">
            <strong>⚠️ Emergency:</strong> For urgent electrical emergencies, please call our 24/7 hotline immediately.
        </div>

        <form method="POST" action="{{ route('services.no-power.store') }}">
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
                <label>Your Address <span class="required">*</span></label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                    required>{{ old('address') }}</textarea>
                @error('address')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Outage Location <span class="required">*</span></label>
                <textarea name="outage_location" class="form-control @error('outage_location') is-invalid @enderror"
                    required placeholder="Specific location of the power outage">{{ old('outage_location') }}</textarea>
                @error('outage_location')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Affected Area Description <span class="required">*</span></label>
                <textarea name="affected_area" class="form-control @error('affected_area') is-invalid @enderror"
                    required placeholder="Describe which areas/streets are affected">{{ old('affected_area') }}</textarea>
                @error('affected_area')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: Our team will be dispatched to your area as soon as possible after your report is received.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Report</button>
        </form>
    </div>
</div>
@endsection