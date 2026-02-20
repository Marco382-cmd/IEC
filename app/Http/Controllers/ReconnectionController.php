<?php
// app/Http/Controllers/ReconnectionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconnectionController extends Controller
{
    public function index()
    {
        return view('services.reconnection');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'  => 'required|string|max:255',
            'customer_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'required|string',
            'payment_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // Insert into service_requests
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'reconnection',
                'account_number' => $validated['account_number'],
                'customer_name'  => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Handle file upload
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptPath = $request->file('payment_receipt')
                    ->store("uploads/reconnection/{$requestId}", 'public');
            }

            // Insert into reconnection_requests
            DB::table('reconnection_requests')->insert([
                'request_id'      => $requestId,
                'payment_receipt' => $receiptPath,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            return redirect()->route('services.reconnection')
                ->with('success', "Your reconnection request has been submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error submitting request. Please try again.');
        }
    }
}