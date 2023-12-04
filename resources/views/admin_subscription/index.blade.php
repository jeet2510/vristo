

<x-layout.default>
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />
    <link rel="stylesheet" href="Editor-2.2.2/css/editor.dataTables.css">
    
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>
    <script src="Editor-2.2.2/js/dataTables.editor.js"></script>
    
    <script>
        
        $(document).ready(function() {
            $('#company-table').DataTable();
        });
    </script>

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
    .container_table{
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
    }
    .alert-danger{
        color: red;
    }
    .alert-success{
        color: #5CB85C;
    }
</style>

    <div class="container_table">

        <form action="/fillter_admin_sub" method="get" class="space-y-5">
            @csrf
            
            
            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                <div class="col">
                    <label for="plan" class="form-label"> Select Plan:</label>
                    
                    <select id="plan" name="plan" class="form-select">
                        <option value="" selected>All</option>
                        @foreach($activeSubscriptionPlans as $activeSubscriptionPlan)
                        <option value="{{ $activeSubscriptionPlan->id }}">{{ $activeSubscriptionPlan->plan_name }}</option>
                        @endforeach
                    </select>
                    
                </div>

                <div class="col">
                    <label for="type" class="form-label"> Select Type:</label>
                    <select id="type" name="type" class="form-select">
                        <option value="" selected>All</option>
                        <option value="Yearly">Yearly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </div>

                <div class="col">
                    <label for="company" class="form-label"> Select Company:</label>
                    <select id="company" name="company" class="form-select">
                        <option value="" selected>All</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}"> {{ $company->company_name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" selected>All</option>
                        <option value="running">Running</option>
                        <option value="plan_over">Plan Over</option>
                    </select>
                </div>
            
                <div class="col">
                    <input type="submit" class="btn btn-info" value="fillter">
                </div>

            </div>
        </form>

        
    
        <a href="{{ route('admin_subscription.show_assign_form') }}" class="btn btn-primary btn-sm mb-2" style="width: 50px; float:right;">Add</a>
    <table id="company-table" class="table">
        <thead>
            <tr>
                <th>S no</th>
                <th>Company Name</th>
                {{-- <th>Contact Person Full Name</th> --}}
                <th>Plan Name</th>
                <th>Plan Type</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Plan Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Status (Running / Plan Over)</th>
                <th>Edit</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($Transaction as $tran)
            <tr>
                <td>{{ $tran->id }}</td>
                <td>@foreach($companies as $company) @if($tran->company_name == $company->id) {{ $company->company_name }}  @endif @endforeach</td>
                {{-- <td>{{ $tran->contact_person }}</td> --}}
                
                <td>@foreach($activeSubscriptionPlans as $activeSubscriptionPlan) @if($tran->subscription_id == $activeSubscriptionPlan->id) {{ $activeSubscriptionPlan->plan_name }}  @endif @endforeach</td>
                <td>@foreach($activeSubscriptionPlans as $activeSubscriptionPlan) @if($tran->subscription_id == $activeSubscriptionPlan->id) {{ $activeSubscriptionPlan->plan_type }}  @endif @endforeach</td>

                <td>{{ $tran->start_date }}</td>
                <td>{{ $tran->end_date }}</td>
                <td> 
                    @foreach($Transactions as $Transaction) 
                        @if($tran->subscription_id == $Transaction->id) 
                            {{$Transaction->amount}}
                        @endif
                    @endforeach
                </td>
                <td> 
                    @foreach($Transactions as $Transaction) 
                        @if($tran->subscription_id == $Transaction->id) 
                            {{$Transaction->collected_amount}}
                        @endif
                    @endforeach
                </td>
                <td> 
                    @foreach($Transactions as $Transaction) 
                        @if($tran->subscription_id == $Transaction->id) 
                        <?php
                            $collected_amount = $Transaction->collected_amount;
                            $amount = $Transaction->amount;
                            $due = $collected_amount - $amount;
                            echo $due;
                        ?><br>
                        @endif
                    @endforeach
                </td>
                <td> 
                    @foreach($Transactions as $Transaction) 
                        @if($tran->subscription_id == $Transaction->id) 
                        <?php
                        $collected_amount = $Transaction->collected_amount;
                        $amount = $Transaction->amount;
                        $due = $collected_amount - $amount;
                        if ($due == '0'){
                            echo 'Paid';
                        }
                        else {
                            echo 'Unpaid';
                        }
                        ?>
                        @endif
                    @endforeach
                </td>
                <td> 
                    <?php
                        $end_date = $tran->end_date;
                        if (strtotime($end_date) < time()) {
                            echo 'Plan Over';
                        } else {
                            echo 'Running';
                        }
                    ?>  
                </td>
                <td>
                    <a href="{{ route('admin_subscription.edit', ['id' => $tran->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</x-layout.default>