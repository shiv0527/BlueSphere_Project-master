<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Leads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LeadsController extends Controller
{
    public function create() 
    {
        $user_id = Auth::user()->id;

        $userleads = Leads::withoutTrashed()->where('user_id', $user_id)->paginate(10);

        return Inertia::render('Leads/Leads', [
            'sample' => $userleads,
        ]);
    }

    public function update(Request $request)
    {
        $lead = DB::table('leads')
                ->select('leads.*')
                ->where('leads.id', $request->id)
                ->get();

        return Inertia::render('Leads/Update', [
            'lead' => $lead[0],
            'status' => ['Contacted', 'Converted', 'Not Contacted', 'Not Interested', 'Closed'],
        ]);
    }

    public function store(Request $request)
    {

        DB::table('leads')
                ->where('id', $request->id)
                ->update(['lead_notes' => $request->notepad,
                          'lead_status' => $request->lead_status]);

        return Redirect::route('leads')->with('success', 'Lead Updated');
    }

    public function destroy(Leads $id)
    {
        $id->delete();
        return Redirect::back()->with('success', 'Lead deleted successfully.');
    }

}
