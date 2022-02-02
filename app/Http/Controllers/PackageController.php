<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;

class PackageController extends Controller
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
        // $packages = DB::select('select * from packages');
        $packages = Package::withoutTrashed()->get();
        
        // $packages = Package::all();
        return Inertia::render('Package/Package', [
            'packages' => $packages,
        ]);
    }

    public function create()
    {
        return Inertia::render('Package/Create', [
            'durations' => ['day', 'week', 'month', 'year'],
            'yesno' => ['Yes', 'No'],
        ]);
    }

    public function store(Request $request)
    {
        
        $validator = $request->validate([
            'package_name' => ['required', 'max:50'],
            'package_benefits' => ['required', 'max:50'],
            'package_duration' => ['required'],
            'is_active' => ['required'],
            'price' => ['required'],
        ]);

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );

        $product = $stripe->products->create([
            'name' => $request->package_name,
            'description' => "Gives you " . $request->package_benefits . " Leads",
        ]);        

        //create stripe_price_id
        $stripe_price = $stripe->prices->create([
            'unit_amount' => $request->price * 100,
            'currency' => 'cad',
            'recurring' => ['interval' => $request->package_duration],
            'product' => $product->id,
        ]);
        

        try {
            $package = Package::create([
                'product_id' => $product->id,
                'package_name' => $request->package_name,
                'package_benefits' => $request->package_benefits,
                'package_duration' => $request->package_duration,
                'is_active' => true,
                'price_id' => $stripe_price->id,
                'price' => $request->price, 
                'offer_price'=> $request->offer_price,    
            ]);
        }catch (Exception $e) {
            return Redirect::back()->with( 'error', 'Could not create package, Try Again!');
        }
    
        return Redirect::route('admin.package')->with('success', 'Package created.');
    }

    public function destroy(Package $id) {
        $id->delete();
        return Redirect::back()->with('success', 'Package deleted.');
    }
}
