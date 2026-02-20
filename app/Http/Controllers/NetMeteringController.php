<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NetMeteringController extends Controller
{
    public function index()
    {
        return view('services.net-metering');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'       => 'required|string|max:255',
            'customer_name'        => 'required|string|max:255',
            'contact_number'       => 'required|string|max:20',
            'email'                => 'nullable|email|max:255',
            'address'              => 'required|string',
            'system_capacity'      => 'required|string|max:100',
            'installation_details' => 'required|string',
            'documents'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // 1. Insert into service_requests
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'net_metering',
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
            $docsPath = null;
            if ($request->hasFile('documents')) {
                $docsPath = $request->file('documents')
                    ->store("uploads/net-metering/{$requestId}", 'public');
            }

            // 3. Insert into net_metering_requests with all customer info
            DB::table('net_metering_requests')->insert([
                'request_id'           => $requestId,
                'account_number'       => $validated['account_number'],
                'customer_name'        => $validated['customer_name'],
                'contact_number'       => $validated['contact_number'],
                'email'                => $validated['email'] ?? null,
                'address'              => $validated['address'],
                'system_capacity'      => $validated['system_capacity'],
                'installation_details' => $validated['installation_details'],
                'supporting_documents' => $docsPath,
                'created_at'           => now(),
            ]);

            return redirect()->route('services.net-metering')
                ->with('success', "Net metering application submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Submission failed: ' . $e->getMessage());
        }
    }
}