<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class AdminDashboardController extends Controller
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
        // dd(\Session::all());
        return Inertia::render('Dashboard/AdminIndex');
    }
}
