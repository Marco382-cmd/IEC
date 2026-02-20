<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeInfoController extends Controller
{
    public function index()
    {
        return view('services.change-info');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'   => 'required|string|max:255',
            'customer_name'    => 'required|string|max:255',
            'contact_number'   => 'required|string|max:20',
            'email'            => 'nullable|email|max:255',
            'address'          => 'required|string',
            'new_account_name' => 'nullable|string|max:255',
            'new_address'      => 'nullable|string',
            'new_contact'      => 'nullable|string|max:20',
            'documents'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // 1. Insert into service_requests
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'change_info',
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
                    ->store("uploads/change-info/{$requestId}", 'public');
            }

            // 3. Insert into change_info_requests with all customer info
            DB::table('change_info_requests')->insert([
                'request_id'           => $requestId,
                'account_number'       => $validated['account_number'],
                'customer_name'        => $validated['customer_name'],
                'contact_number'       => $validated['contact_number'],
                'email'                => $validated['email'] ?? null,
                'address'              => $validated['address'],
                'new_account_name'     => $validated['new_account_name'] ?? null,
                'new_address'          => $validated['new_address'] ?? null,
                'new_contact'          => $validated['new_contact'] ?? null,
                'supporting_documents' => $docsPath,
                'created_at'           => now(),
            ]);

            return redirect()->route('services.change-info')
                ->with('success', "Change information request submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Submission failed: ' . $e->getMessage());
        }
    }
}