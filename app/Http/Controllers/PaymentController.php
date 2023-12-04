<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use App\Models\AdminSubscription;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class PaymentController extends Controller
{
    public function create()
    {
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
        $admin_subscriptions = AdminSubscription::all();

        return view('payments.create', compact('companies', 'activeSubscriptionPlans','admin_subscriptions'));
        
    }
    public function store(Request $request){
        try {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'company_id' => 'required|integer',
            'selected_plan' => 'required|string',
            'plan_type' => 'required|string',
            'amount' => 'required|numeric',
            'collected_amount' => 'required|numeric',
            'payment_mode' => 'required|string',
            'transaction_date' => 'required|date',
            'reference_id' => 'required|integer',
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
                
            return redirect()->route('payments.create')->withErrors($e->errors())->withInput();
        }
    
        try {
            $transaction = Transaction::create($validatedData);
        } catch (\QueryException  $e) {
            \Log::error('Failed to add . ' . $e->getMessage());
            return redirect()->route('payments.create')->with('error', 'Failed to add payments.');
        }

        return redirect()->route('payments.show')->with('success', 'payments added successfully!');
    }
    public function show(){
        
        $Transaction = Transaction::get();
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
        $admin_subscriptions = AdminSubscription::all();
      
        return view('payments.index', compact('Transaction','companies','activeSubscriptionPlans','admin_subscriptions'));
    }
    public function edit(Request $request){
        $id = $request->id;
        $data = Transaction::where('id', $id)->first();
        $companies = DB::table('admins')->select('*')->distinct()->get();
        $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get('id');
        
        $admin_subscriptions = AdminSubscription::all();
        return view('payments.edit', compact('data','companies','activeSubscriptionPlans','admin_subscriptions'));
    }
    public function update(Request $request){
        try {
            $validatedData = $request->validate([
                'id' => 'required', 
                'date' => 'required|date',
                'company_id' => 'required|integer',
                'selected_plan' => 'required|string',
                'plan_type' => 'required|string',
                'amount' => 'required|numeric',
                'collected_amount' => 'required|numeric',
                'payment_mode' => 'required|string',
                'transaction_date' => 'required|date',
                'reference_id' => 'required|integer',
            ]);
            $id = $request->id;
            $company = Transaction::findOrFail($id);
            $company->update($validatedData);

            return redirect()->route('payments.show')->with('success', 'payments successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
                
            $id = $request->id;
            $data = Transaction::where('id', $id)->first();
            $companies = DB::table('admins')->select('*')->distinct()->get();
            $activeSubscriptionPlans = SubscriptionPlan::where('status', 'Active')->get();
            $admin_subscriptions = AdminSubscription::all();
            return view('payments.edit', compact('data','companies','activeSubscriptionPlans','admin_subscriptions'));
        }
    }
}
