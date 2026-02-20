<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SeniorCitizenController extends Controller
{
    // Show the form
    public function index()
    {
        return view('services.senior-citizen');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'  => 'required|string|max:255',
            'customer_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'required|string',
            'brgy_clearance'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'senior_id'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'billing_receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'authorization'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // Insert into service_requests
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'senior_discount',
                'account_number' => $validated['account_number'],
                'customer_name'  => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Handle file uploads
            $uploadPath = "uploads/senior-citizen/{$requestId}/";
            $brgyClearance  = $request->file('brgy_clearance')?->store($uploadPath, 'public');
            $seniorId       = $request->file('senior_id')?->store($uploadPath, 'public');
            $billingReceipt = $request->file('billing_receipt')?->store($uploadPath, 'public');
            $authorization  = $request->file('authorization')?->store($uploadPath, 'public');

            // Insert into senior_discount_requests
            DB::table('senior_discount_requests')->insert([
                'request_id'          => $requestId,
                'brgy_clearance'      => $brgyClearance,
                'senior_id_copy'      => $seniorId,
                'billing_receipt'     => $billingReceipt,
                'authorization_letter'=> $authorization,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            return redirect()->route('services.senior-citizen')
                             ->with('success', "Senior citizen discount request submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Error submitting request. Please try again.');
        }
    }
}
