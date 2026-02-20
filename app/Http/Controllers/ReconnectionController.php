<?php

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
            // 1. Insert into service_requests
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

            // 2. Handle file upload
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptPath = $request->file('payment_receipt')
                    ->store("uploads/reconnection/{$requestId}", 'public');
            }

            // 3. Insert into reconnection_requests with all customer info
            DB::table('reconnection_requests')->insert([
                'request_id'            => $requestId,
                'account_number'        => $validated['account_number'],
                'customer_name'         => $validated['customer_name'],
                'contact_number'        => $validated['contact_number'],
                'email'                 => $validated['email'] ?? null,
                'address'               => $validated['address'],
                'seminar_attended'      => 0,
                'seminar_date'          => null,
                'bills_paid'            => 0,
                'payment_receipt'       => $receiptPath,
                'reconnection_fee_paid' => 0,
                'created_at'            => now(),
            ]);

            return redirect()->route('services.reconnection')
                ->with('success', "Your reconnection request has been submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Submission failed: ' . $e->getMessage());
        }
    }
}