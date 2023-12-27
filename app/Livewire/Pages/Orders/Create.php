<?php

namespace App\Livewire\Pages\Orders;

use App\Livewire\Forms\OrderForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;
    public OrderForm $form;
    public function submit()
    {
        $this->form->validate();
        $this->form->submit();
        session()->flash('success', 'form submitted');
        // $this->form->reset();
        $this->dispatch('order-created','oke');
    }
    public function render()
    {
        return view('pages.orders.create');
    }
}
