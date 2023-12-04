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
<!-- forms grid -->
<form action="{{ route('admin.update',['id' => $data->id]) }}" method="post">
    @csrf
    <input type="hidden" value="{{$data->id }}" name="id">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="companyName">Company Name</label>
            <input id="companyName" type="text" name="company_name" placeholder="Enter Company Name" value="{{ $data->company_name }}" class="form-input" />
            @error('company_name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="companyShortName">Company Short Name (Barcode Print)</label>
            <input id="companyShortName" type="text" value="{{ $data->company_short_name }}" name="company_short_name" placeholder="Enter Short Name" class="form-input" />
            @error('company_short_name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div>
        <label for="contactPersonFullName">Contact Person Full Name</label>
        <input id="contactPersonFullName" type="text" value="{{ $data->contact_person_full_name }}" name="contact_person_full_name" placeholder="Enter Contact Person Name" class="form-input" />
        @error('contact_person_full_name')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="websiteAddress">Website Address</label>
        <input id="websiteAddress" type="text" value="{{ $data->website_address }}" name="website_address" placeholder="Enter Website Address" class="form-input" />
        @error('website_address')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="contactNumber">Contact Number</label>
            <input id="contactNumber" type="text" value="{{ $data->contact_number }}" name="contact_number" placeholder="Enter Contact Number" class="form-input" />
            @error('contact_number')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="whatsappNumber">Whatsapp Number</label>
            <input id="whatsappNumber" value="{{ $data->whatsapp_number }}" type="text" name="whatsapp_number" placeholder="Enter Whatsapp Number" class="form-input" />
            @error('whatsapp_number')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ $data->email }}" placeholder="Enter Email" class="form-input" />
        @error('email')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="address1">Address 1</label>
        <input id="address1" type="text" name="address_1" value="{{ $data->address_1 }}" placeholder="Enter Address 1" class="form-input" />
        @error('address_1')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="address2">Address 2</label>
        <input id="address2" type="text" name="address_1" value="{{ $data->address_1 }}" placeholder="Enter Address 2" class="form-input" />
        @error('address_2')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label for="city">City</label>
            <input id="city" type="text" name="city" value="{{ $data->city }}" placeholder="Enter City" class="form-input" />
            @error('city')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="state">State</label>
            <select id="state" name="state" class="form-select text-white-dark">
                <option>Choose...</option>
                <option>...</option>
            </select>
            @error('state')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="pinCode">Pin Code</label>
            <input id="pinCode" type="text" name="pin_code"  value="{{ $data->pin_code }}" placeholder="Enter Pin Code" class="form-input" />
            @error('pin_code')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="{{ $data->password }}" placeholder="Enter Password" class="form-input" />
        @error('password')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="currency">Currency</label>
        <input id="currency" type="text" name="currency" value="{{ $data->currency }}" placeholder="Enter Currency" class="form-input" />
        @error('currency')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="currencySymbol">Currency Symbol</label>
        <input id="currencySymbol" type="text" name="currency_symbol" value="{{ $data->currency_symbol }}" placeholder="Enter Currency Symbol" class="form-input" />
        @error('currency_symbol')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary !mt-6">Submit</button>
</form>


</x-layout.default>