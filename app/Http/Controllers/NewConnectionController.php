<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewConnectionController extends Controller
{
    public function index()
    {
        return view('services.new-connection');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'contact_number'   => 'required|string|max:20',
            'address'          => 'required|string',
            'email'            => 'nullable|email|max:255',
            'account_number'   => 'nullable|string|max:50',
            'electrical_plan'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'final_inspection' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fire_safety'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'cedula'           => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tax_declaration'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kasunduan'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'building_permit'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // 1. Save to service_requests
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'new_connection',
                'account_number' => $validated['account_number'] ?? '',
                'customer_name'  => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // 2. Upload files
            $fileFields = [
                'electrical_plan'  => 'final_inspection_cert', // mapped below
                'final_inspection' => 'final_inspection_cert',
                'fire_safety'      => 'fire_safety_cert',
                'cedula'           => 'cedula_copy',
                'tax_declaration'  => 'tax_declaration',
                'kasunduan'        => 'kasunduan',
                'building_permit'  => 'building_permit',
            ];

            $uploadedPaths = [];
            $fileInputs = [
                'electrical_plan', 'final_inspection', 'fire_safety',
                'cedula', 'tax_declaration', 'kasunduan', 'building_permit'
            ];

            foreach ($fileInputs as $field) {
                $uploadedPaths[$field] = $request->hasFile($field)
                    ? $request->file($field)->store("uploads/new_connection/{$requestId}", 'public')
                    : null;
            }

            // 3. Save to new_connection_request (all info in one table)
            DB::table('new_connection_request')->insert([
                'request_id'           => $requestId,
                'account_number'       => $validated['account_number'] ?? null,
                'customer_name'        => $validated['customer_name'],
                'contact_number'       => $validated['contact_number'],
                'email'                => $validated['email'] ?? null,
                'address'              => $validated['address'],
                'electrical_plan'      => $uploadedPaths['electrical_plan'],
                'final_inspection_cert'=> $uploadedPaths['final_inspection'],
                'fire_safety_cert'     => $uploadedPaths['fire_safety'],
                'cedula_copy'          => $uploadedPaths['cedula'],
                'tax_declaration'      => $uploadedPaths['tax_declaration'],
                'kasunduan'            => $uploadedPaths['kasunduan'],
                'building_permit'      => $uploadedPaths['building_permit'],
                'seminar_attended'     => 0,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            return back()->with('success', "New connection request submitted successfully! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Submission failed: ' . $e->getMessage());
        }
    }
}