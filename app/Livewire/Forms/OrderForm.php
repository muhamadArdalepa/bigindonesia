<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Customer;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class OrderForm extends Form
{
    use WithFileUploads;
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $phone;
    #[Validate('image')]
    public $house_picture;

    public function submit()
    {
        Customer::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'region_id'=>1,
            'server_id'=>1,
            'packet_id'=>1,
            'address' => fake()->address,
            'coordinate' => '0,1',
        ]);
    }
}
