<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription_details;
use App\Models\Package_uses;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;
use Exception;

class StripeController extends Controller
{
    public function index(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );

        $card = null;
        if (Auth::user()->customer_id != null){
            $cus = $stripe->customers->retrieve(
                Auth::user()->customer_id,
                []
            );
            try {
                $ret = $cus->invoice_settings->default_payment_method;
            } catch (Exception $e) {
                return Redirect::back()->with( 'error', 'Could not retrieve customer\'s default payment method');
            }

            if ($ret != null) {
                try{
                    $pm = $stripe->paymentMethods->retrieve(
                        $cus->invoice_settings->default_payment_method,
                        []
                    );
                } catch (Exception $e) {
                    return Redirect::back()->with( 'error', 'Could not retrieve customer\'s default payment method');
                }
                $card = $pm;
            }
        }

        $package = DB::table('packages')
                    ->select('packages.*')
                    ->where('packages.price_id', $request->id)
                    ->get();
        
        return Inertia::render('Payment/Stripe', [
            'pck' => $package,
            'price_id' => $request->id,
            'card' => $card,
        ]);
    }

    public function store(Request $request)
    {
        //create stripe _subscription
        
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );

        
        if (Auth::user()->customer_id == null){
            $cus_id = $stripe->customers->create([
                'description' => 'My Test Customer (created for API docs)',
                'email' => Auth::user()->email,
                'id' => Auth::user()->id,
            ]);

            Auth::user()->customer_id = $cus_id->id;
            Auth::user()->save();
            

            //attach a payment method to that customer
            $stripe->paymentMethods->attach(
                $request->id,
                ['customer' => $cus_id->id,]
            );

        
            // set default payment method
            $t = $stripe->customers->update(
                $cus_id->id,
                [
                    'invoice_settings' => ['default_payment_method' => $request->id]
                ]
            );
        }

        
        //if customer already exists and add a card
        else if($request->default_card == null){
            $cus_id = Auth::user()->customer_id;
            //attach a payment method to that customer

            $stripe->paymentMethods->attach(
                $request->id,
                ['customer' => $cus_id,]
            );
        
            // set default payment method
            $t = $stripe->customers->update(
                $cus_id,
                [
                    'invoice_settings' => ['default_payment_method' => $request->id]
                ]
            );
        }

        $subs = $stripe->subscriptions->create([
            'customer' => Auth::user()->customer_id,
            'items' => [
                ['price' => $request->price_id],
            ],
        ]);

        try {
            //entry in subs table
            $subscription_details = Subscription_details::create([
                'subscription_id' => $subs->id,
                'user_id' => Auth::user()->id,
                'product_id' => $request->package_id,
                'is_active' => true,
            ]);

            //entry in package_use table
            $package_use = Package_uses::create([
                'product_id' => $request->package_id,
                'use_type' => null,
                'leads' => $request->package_leads,
                'leads_left' => $request->package_leads,
                'start_date' => $subs->current_period_start,
                'end_date' => $subs->current_period_end,
                'subscription_id' => $subs->id,
            ]);

            $sales = Sales::create([
                'product_id' => $request->package_id,
                'user_id' => Auth::user()->id,
                'price' => $request->package_price,
                'transaction_id' => $subs->latest_invoice,
            ]);
        } catch(Exception $e){
            return Redirect::back()->with( 'error', 'Something went wrong!');
        }
           
        return Redirect::route('package')->with('success', 'Subscription Created!.');

    }

    public function destroy($subscription_id) {
    
        $update = Subscription_details::where('subscription_id', $subscription_id)->update(array('is_active' => 0));

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        
        $stripe->subscriptions->cancel(
            $subscription_id,
            []
        );

        if ($update){
            return Redirect::back()->with('success', 'Subscription Cancelled!.');
        }
        else{
            return Redirect::back()->with('error', 'Something went wrong!');
        }
        
    }

    
}
