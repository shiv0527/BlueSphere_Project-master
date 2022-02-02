<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Leads;
use App\Models\Subscription_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $userleads = Leads::withoutTrashed()->where('user_id', $user_id)->get();
        
        $sd = Auth::user()->customer_id;
        return Inertia::render('Dashboard/Index', [
            'sample' => $userleads,
            'stripe' => $sd,
        ]);
    }
}
