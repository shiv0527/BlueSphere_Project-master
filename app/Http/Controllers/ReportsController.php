<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use DB;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin:admin');
    }

    
    public function index()
    {
        $users = DB::table('leads')
                    ->select(DB::raw('count(lead_status) as status_count, lead_status, user_id'))
                    ->groupBy('user_id', 'lead_status')
                    ->where('lead_status', '!=', null)
                    ->where('deleted_at', '=', null)
                    ->get();
        // dd($users);

        return Inertia::render('Reports/Index', [
            'users' => $users,
        ]);
    }
}
