<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;

class ContactPerson extends Component
{
    public $companyName;
    public $contactPerson;

    public function render()
    {
        // Fetch the contact person's name based on the selected company name
        $admin = Admin::where('company_name', $this->companyName)->first();

        if ($admin) {
            $this->contactPerson = $admin->contact_person_full_name;
        } else {
            $this->contactPerson = null;
        }

        return view('livewire.contact-person');
    }
}
