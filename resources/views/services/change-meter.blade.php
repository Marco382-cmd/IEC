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
            <h2>Meter Replacement Request</h2>
            <p>Request meter replacement for defective or damaged meters</p>
        </div>

        <div class="requirements-list">
            <h4>Without Payment (Stop / Creeping / Defective):</h4>
            <ul>
                <li>Go to CWD and request change meter</li>
                <li>Job order will be issued</li>
                <li>Technical department releases materials</li>
                <li>Lineman will replace meter</li>
            </ul>

            <h4 style="margin-top: 1rem;">With Payment (Burned / Overload):</h4>
            <ul>
                <li>Get assessment form from ISD</li>
                <li>Pay replacement fee at teller</li>
                <li>Return receipt to ISD</li>
                <li>Job order issued and processed</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('services.change-meter.store') }}" enctype="multipart/form-data">
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
                <label>Meter Condition <span class="required">*</span></label>
                <select name="meter_condition" class="form-control @error('meter_condition') is-invalid @enderror" required>
                    <option value="">Select condition</option>
                    <option value="stop_meter"       {{ old('meter_condition') === 'stop_meter'       ? 'selected' : '' }}>Stop Meter (No Payment)</option>
                    <option value="creeping_forward" {{ old('meter_condition') === 'creeping_forward' ? 'selected' : '' }}>Creeping Forward (No Payment)</option>
                    <option value="defective"        {{ old('meter_condition') === 'defective'        ? 'selected' : '' }}>Defective Meter (No Payment)</option>
                    <option value="burned"           {{ old('meter_condition') === 'burned'           ? 'selected' : '' }}>Burned Meter (With Payment)</option>
                    <option value="overload"         {{ old('meter_condition') === 'overload'         ? 'selected' : '' }}>Overload Meter (With Payment)</option>
                </select>
                @error('meter_condition')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Show file upload fields only for burned/overload --}}
            <div id="payment-fields" style="display: none;">
                <div class="form-group">
                    <label>Assessment Form <small>(for Burned / Overload)</small></label>
                    <div class="file-upload">
                        <input type="file" name="assessment" id="assessment" accept=".pdf,.jpg,.jpeg,.png">
                        <label for="assessment" class="file-upload-label">
                            <strong>Upload</strong> Assessment Form<br>
                            <small>PDF, JPG, PNG – Max 5MB</small>
                        </label>
                    </div>
                    @error('assessment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Payment Receipt <small>(for Burned / Overload)</small></label>
                    <div class="file-upload">
                        <input type="file" name="receipt" id="receipt" accept=".pdf,.jpg,.jpeg,.png">
                        <label for="receipt" class="file-upload-label">
                            <strong>Upload</strong> Receipt<br>
                            <small>PDF, JPG, PNG – Max 5MB</small>
                        </label>
                    </div>
                    @error('receipt')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="alert alert-info" style="margin-top: 2rem;">
                <strong>ℹ</strong> Note: A lineman will be dispatched after your request is processed and approved.
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Request</button>
        </form>
    </div>
</div>

<script>
    const meterCondition = document.querySelector('select[name="meter_condition"]');
    const paymentFields  = document.getElementById('payment-fields');

    function togglePaymentFields() {
        const requiresPayment = ['burned', 'overload'].includes(meterCondition.value);
        paymentFields.style.display = requiresPayment ? 'block' : 'none';
    }

    meterCondition.addEventListener('change', togglePaymentFields);

    // On page load, restore state if validation failed
    togglePaymentFields();
</script>
@endsection