<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = DB::table('admin_users')
            ->where('username', $request->username)
            ->first();

        if ($admin && password_verify($request->password, $admin->password)) {
            session([
                'admin_id'       => $admin->id,
                'admin_username' => $admin->username,
                'admin_name'     => $admin->full_name,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid username or password.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_username', 'admin_name']);
        return redirect()->route('admin.login');
    }
}