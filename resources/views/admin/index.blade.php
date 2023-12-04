<x-layout.default>
    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />
    <link rel="stylesheet" href="Editor-2.2.2/css/editor.dataTables.css">

    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>
    <script src="Editor-2.2.2/js/dataTables.editor.js"></script>

    <script>
        $(document).ready(function() {
            $('#company-table').DataTable();
        });
    </script>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
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
        .container_table {
            width: 100%;
            overflow-x: auto;
            white-space: nowrap;
        }

        .alert-danger {
            color: red;
        }

        .alert-success {
            color: #5CB85C;
        }
    </style>
    <div class="container_table">
        <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm mb-2"
            style="width: 50px; float:right;">Add</a>
        <table id="company-table" class="table">
            <thead>
                <tr>
                    <th>Company Name </th>
                    <th>Contact Person Full Name</th>
                    <th>Selected Plan</th>
                    <th>Plan Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Plan Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Payment Status</th>
                    <th>Status (Running / Plan Over)</th>
                    {{-- <th>Website Address</th>
                <th>Contact Number</th>
                <th>Whatsapp Number</th>
                <th>Email Id</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Pin code</th>
                <th>Currency</th>
                <th>Currency Symbol</th> --}}
                    <th>Edit</th>
                    <th>Login Block Button</th>
                    <th>Direct login Button</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->company_name }}</td>
                        <td>{{ $company->contact_person_full_name }}</td>

                        @foreach ($datas as $data)
                            @if ($company->id == $data->company_name)
                                @foreach ($SubscriptionPlans as $SubscriptionPlan)
                                    @if ($data->subscription_id == $SubscriptionPlan->id)
                                        <td> {{ $SubscriptionPlan->plan_name }}</td>
                                        <td> {{ $SubscriptionPlan->plan_type }}</td>
                                        <td> {{ $data->start_date }}</td>
                                        <td> {{ $data->end_date }}</td>
                                        {{-- <td>  {{ $SubscriptionPlan->plan_type }}</td> --}}
                                    @endif
                                @endforeach

                                <td>
                                    @php
                                        $foundMatchingTransaction = false;
                                    @endphp
                                    @foreach ($Transactions as $Transaction)
                                        @if ($data->subscription_id == $Transaction->selected_plan)
                                            {{ $Transaction->amount }} <br>
                                            @php
                                                $foundTransaction = true;
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if (!$foundTransaction)
                                        Not available
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $foundTransaction = false;
                                    @endphp

                                    @foreach ($Transactions as $Transaction)
                                        @if ($data->subscription_id == $Transaction->selected_plan)
                                            {{ $Transaction->collected_amount }}
                                            @php
                                                $foundTransaction = true;
                                            @endphp
                                            <br>
                                        @endif
                                    @endforeach

                                    @if (!$foundTransaction)
                                        Not available
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $foundMatchingTransaction = false;
                                    @endphp

                                    @foreach ($Transactions as $Transaction)
                                        @if ($data->subscription_id == $Transaction->selected_plan)
                                            <?php
                                            $collected_amount = $Transaction->collected_amount;
                                            $amount = $Transaction->amount;
                                            $due = $collected_amount - $amount;
                                            echo $due;
                                            ?><br>
                                            @php
                                                $foundMatchingTransaction = true;
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if (!$foundMatchingTransaction)
                                        Not available
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $foundMatchingTransaction = false;
                                    @endphp
                                    @foreach ($Transactions as $Transaction)
                                        @if ($data->subscription_id == $Transaction->selected_plan)
                                            <?php
                                            $collected_amount = $Transaction->collected_amount;
                                            $amount = $Transaction->amount;
                                            $due = $collected_amount - $amount;
                                            if ($due == '0') {
                                                echo 'Paid';
                                            } else {
                                                echo 'Unpaid';
                                            }
                                            
                                            ?><br>
                                            @php
                                                $foundTransaction = true;
                                            @endphp
                                        @else
                                        @endif
                                    @endforeach
                                    @if (!$foundMatchingTransaction)
                                        Not available
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $foundMatchingTransaction = false;
                                    @endphp
                                        @foreach ($SubscriptionPlans as $SubscriptionPlan)
                                        @if ($data->subscription_id == $SubscriptionPlan->id)
                                            <?php
                                                $end_date = $data->end_date;
                                                if (strtotime($end_date) < time()) {
                                                    echo 'Plan Over';
                                                } else {
                                                    echo 'Running';
                                                }
                                            ?>
                                            @php
                                                $foundMatchingTransaction = true;
                                            @endphp
                                        @endif
                                    @endforeach
                                    
                                    @if (!$foundMatchingTransaction)
                                        Not available
                                    @endif
                                </td>
                            @endif
                        @endforeach

                        {{-- <td>{{ $company->website_address }}</td>
                <td>{{ $company->contact_number }}</td>
                <td>{{ $company->whatsapp_number }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->address_1 }}</td>
                <td>{{ $company->address_2 }}</td>
                <td>{{ $company->country }}</td>
                <td>{{ $company->state }}</td>
                <td>{{ $company->city }}</td>
                <td>{{ $company->pin_code }}</td>
                <td>{{ $company->currency }}</td>
                <td>{{ $company->currency_symbol }}</td> --}}

                        <td>
                            <a href="{{ route('admin.edit', ['id' => $company->id]) }}"
                                class="btn btn-primary">Edit</a>
                        </td>
                        <td width="50px"><a class="btn btn-danger">Block</a></td>
                        <td width="50px"><a class="btn btn-success">Login</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layout.default>
