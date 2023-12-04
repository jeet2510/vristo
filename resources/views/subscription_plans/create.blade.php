<x-layout.default>
     <!-- forms grid -->
     @if(session('success'))
     <div class="alert alert-success">
         {{ session('success') }}
     </div>
 @endif
 
 @if(session('error'))
     <div class="alert alert-danger">
         {{ session('error') }}
     </div>
 @endif
 
 @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif

 <style>
    .alert-danger{
        color: red;
    }
    </style>
    
    <form action="{{ route('subscription_plans.store') }}" method="post" class="space-y-5">
        @csrf
    
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="planName">Plan Name</label>
                <input id="planName" type="text" name="plan_name" placeholder="Enter Plan Name" class="form-input" />
            </div>
            <div>
                <label for="planType">Plan Type</label>
                <select id="planType" name="plan_type" class="form-select text-white-dark">
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="amount">Amount</label>
                <input id="amount" type="number" name="amount" placeholder="Enter Amount" class="form-input" />
            </div>
        
            <div>
                <label for="numCompaniesAllowed">No. of Companies Allowed</label>
                <input id="numCompaniesAllowed" type="number" name="num_of_companies_allowed" placeholder="Enter No. of Companies Allowed" class="form-input" />
            </div>
        </div>
    
        <!-- Additional Address and Checkbox fields -->
    
        <button type="submit" class="btn btn-primary !mt-6">Submit</button>
    </form>
</x-layout.default>