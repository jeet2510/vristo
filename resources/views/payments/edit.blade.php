<x-layout.default>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

<form action="{{ route('payments.update') }}" method="post" class="space-y-5">
    @csrf
    <input type="hidden" name="id" value="{{$data->id}}">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="date">Date</label>
            <input id="date" type="date" name="date" class="form-input" value="{{$data->date}}" />
        </div>
        <div>
            <label for="company">Select Company</label>
            <select id="company" name="company_id" class="form-select text-white-dark">
                <option value="" selected disabled>Choose Company...</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}"  @if($company->id == $data->id) selected @endif>{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="selected_plan">Show Selected Plan</label>
            <select id="selected_plan" name="selected_plan" class="form-select text-white-dark" readonly>
                <option value="" selected disabled>Choose Plan...</option>
            </select>
        </div>
        <div>
            <label for="plan_type">Show Plan Type</label>
            <input id="plan_type" type="text" name="plan_type" placeholder="Show Plan Type" class="form-input" readonly />
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label for="amount">Show Amount</label>
            <input id="amount" type="text" name="amount" placeholder="Show Amount" class="form-input" readonly />
        </div>
        <div>
            <label for="collected_amount">Collect Amount</label>
            <input id="collected_amount" type="text" name="collected_amount" placeholder="Collect Amount" class="form-input" readonly />
        </div>
        <div>
            <label for="payment_mode">Payment Mode</label>
            <select id="payment_mode" name="payment_mode" class="form-select text-white-dark">
                <option value="Cash"  @if( $data->payment_mode == 'Cash' ) selected @endif>Cash</option>
                <option value="Wire" @if( $data->payment_mode == 'Wire' ) selected @endif>Wire</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="transaction_date">Transaction Date</label>
            <input id="transaction_date" type="date" name="transaction_date" class="form-input"  value="{{ $data->transaction_date}}" />
        </div>
        <div>
        <label for="reference_id">Reference ID</label>
        <input id="reference_id" type="text" name="reference_id" placeholder="Reference ID" value="{{ $data->reference_id}}" class="form-input" />
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary !mt-6">Submit</button>
</form>
</x-layout.default>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
       document.getElementById('company').addEventListener('change', function () {
           fetchplan();
       });
   });
   $(document).ready(function() {
    setTimeout(function() {
        fetchplan();
    }, 500); 
    });
   
   function fetchplan(){
       var companyId = document.getElementById("company").value;
       var csrfToken = $('meta[name="csrf-token"]').attr('content');
       $.ajax({
               url: '/fetchplan', 
               method: 'post',
               data: {
               companyId: companyId,
               _token: csrfToken // Include the CSRF token
               },
               success: function(data) {
                   var selectElement = $('#selected_plan');
                       selectElement.empty();
                       var planTypeElement = $('#plan_type');

                       var amount = $('#amount');
                       var collected_amount = $('#collected_amount');
                       $len = data.plan_name.length;
                       if ($len > '0') {
                               selectElement.html('<option value="' + data.subscription_id + '">' + data.plan_name + '</option>');
                           planTypeElement.empty().val(data.plan_type);                           
                           amount.empty().val(data.amount);
                           collected_amount.empty().val(data.amount);
                       } else {
                           selectElement.html('<option value="">No plans available</option>');
                           planTypeElement.empty();
                           amount.empty();
                           collected_amount.empty();
                       }

               },
               error: function(error) {
                   console.error('Error fetching data:', error);
               }
           });
   }
       
</script>