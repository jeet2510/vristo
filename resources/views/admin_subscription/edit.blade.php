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

<form action="{{ route('admin_subscription.update') }}" method="post">
    @csrf

        <input type="hidden" name="id" value="{{$data->id}}">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="company">Select Company</label>
            <select id="company" name="company_name" class="form-select">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $data->id) selected @endif>{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <label for="contactPerson">Contact Person Name</label>
            <select id="contactPerson" name="contact_person" class="form-select" readonly>
                @foreach($companies as $company)
                    <option value="{{ $company->contact_person_full_name }}"  data-company="{{ $company->id }}">{{ $company->contact_person_full_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class=" mt-2">
        <label for="subscriptionPlan">Select Plan</label>
        <select id="subscriptionPlan" name="subscription_id" class="form-select">
            @foreach($activeSubscriptionPlans as $plan)
                <option value="{{ $plan->plan_type }}{{$plan->id}}" @if($plan->id == $data->id) selected @endif data-type="{{ $plan->plan_type }}" >{{ $plan->plan_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class=" mt-2">
        <label for="startDate">Start Date</label>
        <input type="date" id="startDate" name="start_date" class="form-input" value="{{$data->start_date}}" onchange="formatDate()">

    </div>

    <div class=" mt-2">
        <label for="endDate">End Date</label>
        <input type="date" id="endDate"  value="{{$data->end_date}}" class="form-input" readonly>
        
        <input type="hidden" name="end_date" id="hiddenEndDate">
    </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Update Assign Subscription Plan</button>
</form>

</x-layout.default>
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('company').addEventListener('change', function () {
            fetchContactPerson();
        });
        
        document.getElementById('startDate').addEventListener('change', function () {
            calculateEndDate();
        })
    });

    function formatDate() {
        const inputDate = document.getElementById('startDate').value;
        const formattedDate = new Date(inputDate).toISOString().split('T')[0];
        document.getElementById('startDate').value = formattedDate;
        }
    function calculateEndDate() {
        var startDate = document.getElementById("startDate").value;
        var subscriptionPlan = document.getElementById("subscriptionPlan").value;
        
        var endDateField = document.getElementById("endDate");
        var hiddenEndDateField = document.getElementById("hiddenEndDate");

        var startDateObject = new Date(startDate);
        const yearlyMatch = subscriptionPlan.match(/Yearly(\d+)/);
        const MonthlyMatch = subscriptionPlan.match(/Monthly(\d+)/);
        if (yearlyMatch) {
            startDateObject.setFullYear(startDateObject.getFullYear() + 1);
        } else if (MonthlyMatch) {
            startDateObject.setMonth(startDateObject.getMonth() + 1);
        }

        var endDate = formatDate(startDateObject);

        endDateField.value = endDate;
        hiddenEndDateField.value = endDate;

    }

    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        // return `${day}-${month}-${year}`;
        return `${year}-${month}-${day}`;
    }
    function fetchContactPerson() {
        var companyId = document.getElementById("company").value;

        var contactPersonSelect = document.getElementById("contactPerson");
        var options = contactPersonSelect.options;

        for (var i = 0; i < options.length; i++) {
            var option = options[i];
            if (option.getAttribute("data-company") === companyId) {
                option.style.display = "";  
                option.selected = true;  
            } else {
                option.style.display = "none";
                option.selected = false; 
            }
        }
    }
</script>
