<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Models\AdminSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'company_name' => 'required|string|max:255',
        'company_short_name' => 'required|string|max:255',
        'contact_person_full_name' => 'required|string|max:255',
        'website_address' => 'nullable|string|max:255',
        'contact_number' => 'nullable|string|max:20',
        'whatsapp_number' => 'nullable|string|max:20',
        'email' => 'required|email|unique:admins',
        'address_1' => 'nullable|string|max:255',
        'address_2' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'pin_code' => 'nullable|string|max:20',
        'password' => 'required|string|min:6',
        'currency' => 'nullable|string|max:255',
        'currency_symbol' => 'nullable|string|max:10',
    ]);

    $validatedData['password'] = Hash::make($request->password);

    try {
        Admin::create($validatedData);

        return redirect()->route('admin.show')->with('success', 'Admin added successfully!');
    } catch (\QueryException $e) {
        \Log::error('Failed to add admin. ' . $e->getMessage());
        return redirect()->route('admin.create')->with('error', 'Failed to add admin.');
    }
}
    public function show(){
        $companies = Admin::get();
        $datas = AdminSubscription::get();
        $SubscriptionPlans  = SubscriptionPlan::get();
        $Transactions  = Transaction::get();
        
        return view('admin.index', compact('companies','datas','SubscriptionPlans','Transactions'));
    }
    public function edit(Request $request){
        $id = $request->id;
        $data = Admin::where('id', $id)->first();
        return view('admin.edit', compact('data'));
    }

    use Illuminate\Support\Facades\Hash;

    public function update(Request $request)
    {
    // Validate the request data
    try {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_short_name' => 'required|string|max:255',
            'contact_person_full_name' => 'required|string|max:255',
            'website_address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:admins,email,' . $request->id,
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'currency' => 'nullable|string|max:255',
            'currency_symbol' => 'nullable|string|max:10',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $id = $request->id;
        $data = Admin::where('id', $id)->first();

        return view('admin.edit', compact('data'))->withErrors($e->errors());
    }

    try {
        $id = $request->id;
        $company = Admin::findOrFail($id);

        // Update the validated data
        $validatedData['password'] = Hash::make($request->password);
        $company->update($validatedData);

        return redirect()->route('admin.show')->with('success', 'Admin updated successfully!');
    } catch (\QueryException  $e) {
        \Log::error('Failed to update admin. ' . $e->getMessage());
        return redirect()->route('admin.edit', ['id' => $request->id])->with('error', 'Failed to update admin.');
    }
    }

    public function login(Request $request){
        return view('admin.login');
    }
    public function login_check(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
