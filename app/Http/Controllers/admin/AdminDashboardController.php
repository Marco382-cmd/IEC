<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $stats = ['total' => 0, 'pending' => 0, 'processing' => 0, 'completed' => 0, 'rejected' => 0];
        $statusCounts = DB::table('service_requests')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        foreach ($statusCounts as $row) {
            $stats[$row->status] = $row->count;
            $stats['total'] += $row->count;
        }

        // Filters
        $filterStatus = $request->get('status', 'all');
        $filterType   = $request->get('type', 'all');

        $query = DB::table('service_requests')->orderByDesc('created_at')->limit(50);
        if ($filterStatus !== 'all') $query->where('status', $filterStatus);
        if ($filterType !== 'all')   $query->where('request_type', $filterType);

        $serviceRequests = $query->get();

        return view('admin.dashboard', compact('stats', 'serviceRequests', 'filterStatus', 'filterType'));
    }

    public function requests()
    {
        $serviceRequests = DB::table('service_requests')->orderByDesc('created_at')->get();
        return view('admin.requests', compact('serviceRequests'));
    }

    public function show($id)
    {
        $request = DB::table('service_requests')->where('id', $id)->first();
        if (!$request) abort(404);

        $detailTable = match($request->request_type) {
            'new_connection'  => 'new_connection_request',
            'reconnection'    => 'reconnection_requests',
            'senior_discount' => 'senior_discount_requests',
            'change_info'     => 'change_info_requests',
            'change_meter'    => 'change_meter_requests',
            'net_metering'    => 'net_metering_requests',
            'no_power'        => 'no_power_requests',
            default           => null,
        };

        $details = $detailTable
            ? DB::table($detailTable)->where('request_id', $id)->first()
            : null;

        return view('admin.request-detail', compact('request', 'details'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status'      => 'required|in:pending,processing,completed,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        DB::table('service_requests')->where('id', $id)->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at'  => now(),
        ]);

        // Log activity
        DB::table('activity_log')->insert([
            'request_id'  => $id,
            'admin_id'    => session('admin_id'),
            'action'      => 'status_update',
            'description' => 'Status changed to: ' . $request->status,
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.requests.show', $id)
            ->with('success', "Request #{$id} updated successfully!");
    }
}