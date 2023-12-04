<x-layout.default>
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />
    <link rel="stylesheet" href="Editor-2.2.2/css/editor.dataTables.css">
    
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>
    <script src="Editor-2.2.2/js/dataTables.editor.js"></script>

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    
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
    .switch-group{
        width: 140px;
    }
    .switch.btn.btn-info{
        width: 90px !important;
    }
    .switch.btn.btn-light.off{
        width: 70px !important;
    }
</style>
    <div class="container_table">
        <a href="{{ route('subscription_plans.create') }}" class="btn btn-primary btn-sm mb-2" style="width: 50px;float: right;">Add</a>

    <table id="company-table" class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Plan Name</th>
                <th>Plan Type</th>
                <th>Amount</th>
                <th>Number of Companies Allowed</th>
                <th>No Of Admin Allotted</th>
                <th>Status</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($SubscriptionPlan as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->plan_name }}</td>
                <td>{{ $company->plan_type }}</td>
                <td>{{ $company->amount }}</td>
                <td>{{ $company->num_of_companies_allowed }}</td>
                <td>{{ $company->no_of_admin_allotted  }}</td>
                <td >
                    <input type="checkbox" data-toggle="switchbutton" {{ $company->status == 'Active' ? 'checked' : '' }} data-onstyle="info">
                </td>
                <td>
                    <a href="{{ route('subscription_plans.edit', ['id' => $company->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</x-layout.default>