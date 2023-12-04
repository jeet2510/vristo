<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanController extends Controller
{
    public function create()
    {
        return view('subscription_plans.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'plan_name' => 'required|string|max:255',
                'plan_type' => 'required|in:Monthly,Yearly',
                'amount' => 'required|numeric|min:0',
                'num_of_companies_allowed' => 'required|integer|min:1',
            ]);

            SubscriptionPlan::create($validatedData);

            return redirect()->route('subscription_plans.create')->with('success', 'Subscription Plan added successfully!');
        } catch (\QueryException  $e) {
            \Log::error('Failed to add Subscription Plan.' . $e->getMessage());
            return redirect()->route('subscription_plans.create')->with('error', 'Failed to add subscription plan.');
        }

        return redirect()->route('subscription_plans.show')->with('success', 'Subscription Plan added successfully!');
    }

    public function show(){
        // $SubscriptionPlan  = SubscriptionPlan::get();

        $SubscriptionPlan = DB::table('subscription_plans')
    ->select('subscription_plans.*')
    ->leftJoin('admin_subscriptions', 'subscription_plans.id', '=', 'admin_subscriptions.subscription_id')
    ->groupBy('subscription_plans.id', 'subscription_plans.plan_name')
    ->selectRaw('COUNT(admin_subscriptions.company_name) as no_of_admin_allotted')
    ->get();
    
// dd($no_of_admin_allotted);

/*    ->selectRaw('COUNT(admin_subscriptions.company_name) as no_of_admin_allotted')
    ->leftJoin('admin_subscriptions', 'subscription_plans.id', '=', 'admin_subscriptions.subscription_id')
    ->groupBy('subscription_plans.id', 'subscription_plans.plan_name')
    ->get();*/

        return view('subscription_plans.index', compact('SubscriptionPlan'));
    }
    public function edit(Request $request){
        $id = $request->id;
        $data = SubscriptionPlan::where('id', $id)->first();
        return view('subscription_plans.edit', compact('data'));
    }
    public function update(Request $request){

        try {
            $validatedData = $request->validate([
                'id' => 'required',
                'plan_name' => 'required|string|max:255',
                'plan_type' => 'required|in:Monthly,Yearly',
                'amount' => 'required|numeric|min:0',
                'num_of_companies_allowed' => 'required|integer|min:1',
            ]);
            $id = $request->id;
            $company = SubscriptionPlan::findOrFail($id);
            $company->update($validatedData);
            return redirect()->route('subscription_plans.show')->with('success', 'successfully!');
        }
        catch (\QueryException  $e) {

            \Log::error('Failed to Subscription Plan.' . $e->getMessage());
            $id = $request->id;
            $data = SubscriptionPlan::where('id', $id)->first();
            return view('subscription_plans.edit', compact('data'))->withErrors($e->errors());
        }
    }
}
