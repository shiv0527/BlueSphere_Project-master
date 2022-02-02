<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Sales;
use App\Models\Leads;
use App\Models\Package_uses;
use App\Imports\LeadsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class UploadLeadsController extends Controller
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
        $clients = DB::table('packages')
            ->join('subscription_details', 'packages.product_id', '=', 'subscription_details.product_id')
            ->join('users', 'users.id', '=', 'subscription_details.user_id')
            ->join('package_uses', 'subscription_details.subscription_id', '=', 'package_uses.subscription_id')
            ->select('subscription_details.user_id', 'users.first_name', 'users.last_name', 'users.email', 'packages.id', 'packages.package_benefits', 'packages.package_name', 'packages.product_id', 'subscription_details.subscription_id', 'package_uses.leads_left', 'users.deleted_at')
            ->where('subscription_details.is_active', 1)
            ->get();

        return Inertia::render('Leads/UploadLeads', [
            'clients' => $clients,
        ]);
    }

    public function import(Request $request)
    {
        $subs_user = DB::table('subscription_details')
                ->select('subscription_details.product_id', 'subscription_details.subscription_id')
                ->where(['subscription_details.user_id' => $request->user_id, 'subscription_details.is_active' => 1])
                ->get();
        
        $current_leads_left = Package_uses::select('leads_left')
            ->where(['subscription_id' => $subs_user[0]->subscription_id, 'product_id' => $subs_user[0]->product_id])->get();

        
        $leadsimport = new LeadsImport;  
        $path = $request->file('avatar');

        //validate
        $leads = (new LeadsImport)->toArray($path);
        if (count($leads[0]) > $current_leads_left[0]->leads_left){
            return Redirect::back()->with( 'error', 'Number of Leads exceeded for the user, check again!');
        }        
        
        try {
            $data = Excel::import($leadsimport, $path);
        }
        catch (Exception $e) {
            return Redirect::back()->with( 'error', 'There is an error in File, please check file requirements');
        }
        
        $rows = $leadsimport->getRowCount();
        $leads_left = $current_leads_left[0]->leads_left - $rows;

        Package_uses::where(['subscription_id' => $subs_user[0]->subscription_id, 'product_id' => $subs_user[0]->product_id])
                    ->update(array('leads_left' => $leads_left));
        
        return Redirect::route('admin.dashboard')->with('upload success', 'Data imported.');
    }

    public function leads(Request $request)
    {
        $leads = DB::table('leads')
                ->select('*')
                ->where('leads.user_id', $request->id)
                ->get();

        return Inertia::render('Leads/LeadsView', [
            'leads' => $leads,
        ]);
    }

    public function user(Request $request) {
        // $leads = DB::table('leads')
        //             ->select('*')
        //             ->where('leads.user_id', $request->id)
        //             // ->whereMonth('created_at', '')
        //             ->paginate(10);
        $leads = Leads::withoutTrashed()->where('user_id', $request->id)->paginate(10);
        $user = DB::table('users')->select('*')->where('id', $request->id)->first();
    
        return Inertia::render('Leads/UserView', [
            'leads' => $leads,
            'user' => $request->id,
            'blocked' => $user->deleted_at,
        ]);
    }

    public function delete(Request $request)
    {
        // dd($request->user);

        $client = DB::table('packages')
            ->join('subscription_details', 'packages.product_id', '=', 'subscription_details.product_id')
            ->join('users', 'users.id', '=', 'subscription_details.user_id')
            ->join('package_uses', 'subscription_details.subscription_id', '=', 'package_uses.subscription_id')
            ->select('subscription_details.user_id', 'users.first_name', 'users.last_name', 'users.email', 'packages.id', 'packages.package_benefits', 'packages.package_name', 'packages.product_id', 'subscription_details.subscription_id', 'package_uses.leads_left')
            ->where('subscription_details.is_active', 1)
            ->where('users.id', $request->user)
            ->get();

        $upt = DB::table('package_uses')
                ->where(['product_id' => $client[0]->product_id, 'subscription_id' => $client[0]->subscription_id])
                ->increment('leads_left');


        $lead = Leads::findOrFail($request->id);
        $del = $lead->delete();

        if ($upt == 1 && $del == true){
            return Redirect::back()->with('success', 'Lead Deleted for this user!');
        }
        else {
            return Redirect::back()->with('error', 'Lead not Deleted for this user!'); 
        }
    }
}
