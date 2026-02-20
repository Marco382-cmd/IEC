<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoPowerController extends Controller
{
    public function index()
    {
        return view('services.no-power');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'  => 'required|string|max:255',
            'customer_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'required|string',
            'outage_location' => 'required|string',
            'affected_area'   => 'required|string',
        ]);

        try {
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'no_power',
                'account_number' => $validated['account_number'],
                'customer_name'  => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::table('no_power_requests')->insert([
                'request_id'        => $requestId,
                'outage_location'   => $validated['outage_location'],
                'outage_start_time' => now(),
                'affected_area'     => $validated['affected_area'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            return redirect()->route('services.no-power')
                ->with('success', "Power outage report submitted! Request ID: #{$requestId}. We will respond shortly.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error submitting report. Please try again.');
        }
    }
}