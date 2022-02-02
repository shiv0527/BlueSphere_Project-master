<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOrganizationsController extends Controller
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
        // dd("hello");
        return Inertia::render('Package/Package');
    }
}
