<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPackageController extends Controller
{
    public function index()
    { 
        $userid = Auth::user()->id;
        
        // $userpackage = DB::table('users')
        // ->join('packages', 'users.package_id', '=', 'packages.id')
        // ->select('users.id', 'users.first_name', 'users.last_name', 'users.package_id', 'packages.package_name', 'packages.package_duration', 'packages.package_benefits', 'packages.price')
        // ->where('users.id', $userid)
        // ->get();

        $up = DB::table('subscription_details')
            ->join('users', 'users.id', '=', 'subscription_details.user_id')
            ->join('packages', 'packages.product_id', '=', 'subscription_details.product_id')
            ->select('*')
            ->where(['users.id' => $userid, 'subscription_details.is_active' => 1])
            ->get();
        // dd($up);
        $allpackages = Package::withoutTrashed()->get();

        return Inertia::render('Package/UserPackage', [
             'userpack' => $up,
             'allpack' => $allpackages,
        ]);
    }
}
