<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSubscription;
use App\Models\Admin;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;


class AdminSubscriptionController extends Controller
{
    public function showAssignSubscriptionForm(Request $request)
    {
    
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
        
        return view('admin_subscription.assign_form', compact('companies', 'activeSubscriptionPlans'));
    }
    public function assignSubscription(Request $request)
    {
        
        try {
            $validatedData = $request->validate([
                'company_name' => 'required',
                'contact_person' => 'required',
                'subscription_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);          
           
            $subscriptionId = $request->subscription_id;
            $parts = explode("Monthly", $subscriptionId);
            if (count($parts) > 1) {
                // It's a Monthly subscription
                $number = $parts[1];
                $validatedData['subscription_id'] = $number;
            } else {
                $parts = explode("Yearly", $subscriptionId);
                if (count($parts) > 1) {
                    // It's a Yearly subscription
                    $number = $parts[1];
                    $validatedData['subscription_id'] = $number;
                }
            }
            

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin_subscription.show_assign_form')->withErrors($e->errors())->withInput();
        }

        try {
            AdminSubscription::create($validatedData);
            return redirect()->route('admin-subscription.show')->with('success', 'Subscription plan assigned successfully!');
        } catch (\QueryException  $e) {
            \Log::error('Failed to add admin. ' . $e->getMessage());
            return redirect()->route('admin_subscription.show_assign_form')->with('error', 'Failed to add admin.');
        }
    }


    public function fetchplan( Request $request){
        $companyId = $request->companyId;
        $adminSubscription = AdminSubscription::where('company_name', $companyId)->first();

        if ($adminSubscription) {
            $subscriptionId = $adminSubscription->subscription_id;

            $subscriptionPlan = SubscriptionPlan::where('id', $subscriptionId)->first();

            if ($subscriptionPlan) {
                $planName = $subscriptionPlan->plan_name;
                $plan_type = $subscriptionPlan->plan_type;
                $amount = $subscriptionPlan->amount;
                
                return response()->json(['subscription_id' => $subscriptionId, 'plan_name' => $planName , 'plan_type' => $plan_type,'amount'=> $amount]);
            }

            // Handle the case where no plan is found for the given subscription_id
            return response()->json(['error' => 'No plan found']);
        }

        return response()->json(['error' => 'No plans found for the given company name']);
    }
    public function show(){
        $Transaction  = AdminSubscription::get();
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
        $datas  = SubscriptionPlan::get();
        
        $Transactions  = Transaction::get();
        
        return view('admin_subscription.index', compact('Transaction','companies','activeSubscriptionPlans','Transactions','datas'));
    }
    public function edit(Request $request){
        $id = $request->id;
        $data = AdminSubscription::where('id', $id)->first();
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
        return view('admin_subscription.edit', compact('data','companies','activeSubscriptionPlans'));
    }
    
    public function update(Request $request){
        
        try {
            
            $validatedData = $request->validate([
                'id' => 'required',
                'company_name' => 'required',
                'contact_person' => 'required',
                'subscription_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
            
            $subscriptionId = $request->subscription_id;
            $parts = explode("Monthly", $subscriptionId);
            if (count($parts) > 1) {
                $number = $parts[1];
                $validatedData['subscription_id'] = $number;
            } else {
                $parts = explode("Yearly", $subscriptionId);
                if (count($parts) > 1) {
                    $number = $parts[1];
                    $validatedData['subscription_id'] = $number;
                }
            }
          
            $id = $request->id;
            $company = AdminSubscription::findOrFail($id);
            $company->update($validatedData);
           
            return redirect()->route('admin-subscription.show')->with('success', 'successfully!');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $id = $request->id;
            
            $data = AdminSubscription::where('id', $id)->first();
            $companies = DB::table('admins')->select('*')->distinct()->get();
            $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
            return redirect()->route('admin_subscription.edit', compact('data', 'companies', 'activeSubscriptionPlans'))
            ->withErrors($e->errors())
            ->withInput();
        }
    }   
    public function fillter(Request $request){
            

            $Transaction  = AdminSubscription::get();
            $companies = DB::table('admins')->select('*')->distinct()->get();
            $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
            $datas  = SubscriptionPlan::get();
            
            $Transactions  = Transaction::get();
            $plan = $request->plan;
            if($plan){
                $activeSubscriptionPlans = SubscriptionPlan::where('id', $plan)->first();
                if (!$activeSubscriptionPlans) {
                
                    return redirect()->back()->with('error', 'Plan not found');
                }
            }
            
            return view('admin_subscription.index', compact('Transaction','companies','activeSubscriptionPlans','Transactions','datas'));
    }

}
