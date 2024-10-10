<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User; 
use App\Models\Admin;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    { 
        $totalVerticals = Affiliate::count();
        return view('admin.dashboard',compact('totalVerticals'));
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }
    public function profile(Request $request)
    {
        $data = Auth::guard('admin')->user();
        return view('admin.users.admin.profile',compact('data'));
    }
}

