
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
            <h2>Change Information Request</h2>
            <p>Update your account name, address, or contact details</p>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('services.change-info.store') }}">
            @csrf

            <h3 style="margin: 0 0 1rem;">Current Information</h3>

            <div class="form-group">
                <label>Account Number <span class="required">*</span></label>
                <input type="text" name="account_number" class="form-control" required value="{{ old('account_number') }}">
            </div>

            <div class="form-group">
                <label>Current Name <span class="required">*</span></label>
                <input type="text" name="customer_name" class="form-control" required value="{{ old('customer_name') }}">
            </div>

            <div class="form-group">
                <label>Current Contact Number <span class="required">*</span></label>
                <input type="tel" name="contact_number" class="form-control" required value="{{ old('contact_number') }}">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Current Address <span class="required">*</span></label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
            </div>

            <h3 style="margin: 2rem 0 1rem;">New Information</h3>

            <div class="form-group">
                <label>New Account Name</label>
                <input type="text" name="new_account_name" class="form-control"
                    placeholder="Leave blank if not changing" value="{{ old('new_account_name') }}">
            </div>

            <div class="form-group">
                <label>New Address</label>
                <textarea name="new_address" class="form-control"
                    placeholder="Leave blank if not changing">{{ old('new_address') }}</textarea>
            </div>

            <div class="form-group">
                <label>New Contact Number</label>
                <input type="tel" name="new_contact" class="form-control"
                    placeholder="Leave blank if not changing" value="{{ old('new_contact') }}">
            </div>

            <h3 style="margin: 2rem 0 1rem;">Supporting Documents</h3>

            <div class="form-group">
                <label>Upload Document</label>
                <input type="file" name="documents" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Valid ID, Proof of address, etc. (PDF, JPG, PNG - Max 5MB)</small>
            </div>

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: Your updated information will reflect on the next billing cycle.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Request</button>
        </form>
    </div>
</div>
@endsection