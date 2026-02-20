<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeMeterController extends Controller
{
    public function index()
    {
        return view('services.change-meter');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number'  => 'required|string|max:255',
            'customer_name'   => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'required|string',
            'meter_condition' => 'required|string|in:stop_meter,creeping_forward,defective,burned,overload',
            'assessment'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'receipt'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $requestId = DB::table('service_requests')->insertGetId([
                'request_type'   => 'change_meter',
                'account_number' => $validated['account_number'],
                'customer_name'  => $validated['customer_name'],
                'contact_number' => $validated['contact_number'],
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            $assessmentPath = null;
            if ($request->hasFile('assessment')) {
                $assessmentPath = $request->file('assessment')
                    ->store("uploads/change-meter/{$requestId}", 'public');
            }

            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')
                    ->store("uploads/change-meter/{$requestId}", 'public');
            }

            DB::table('change_meter_requests')->insert([
                'request_id'      => $requestId,
                'meter_condition' => $validated['meter_condition'],
                'assessment_form' => $assessmentPath,
                'payment_receipt' => $receiptPath,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            return redirect()->route('services.change-meter')
                ->with('success', "Meter change request submitted! Request ID: #{$requestId}");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error submitting request. Please try again.');
        }
    }
}