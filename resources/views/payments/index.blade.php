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
        <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm mb-2" style="width: 50px; float:right;">Add</a>
    <table id="company-table" class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Company Name</th>
                <th>Selected Plan</th>
                <th>Plan Type</th>
                <th>Amount</th>
                <th>Collected Amount</th>
                <th>Payment Mode</th>
                <th>Transaction Date</th>
                <th>Reference ID</th>
                <th>Print</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach($Transaction as $tran)
            <tr>
                <td>{{ $tran->id }}</td>
                <td>{{ $tran->date }}</td>
                <td>
                    @foreach($companies as $company) @if($tran->company_id == $company->id) {{ $company->company_name }}  @endif @endforeach
                </td>
                <td>
                    @foreach($activeSubscriptionPlans as $activeSubscriptionPlan) @if($tran->selected_plan == $activeSubscriptionPlan->id) {{ $activeSubscriptionPlan->plan_name }}  @endif @endforeach
                </td>
                <td>{{ $tran->plan_type }}</td>
                <td>{{ $tran->amount }}</td>
                <td>{{ $tran->collected_amount }}</td>
                <td>{{ $tran->payment_mode }}</td>
                <td>{{ $tran->transaction_date }}</td>
                <td>{{ $tran->reference_id  }}</td>
                <td><a href="#" class="btn btn-success btn-sm">Print</a></td>
                <td>
                    <a href="{{ route('payments.edit', ['id' => $tran->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</x-layout.default>