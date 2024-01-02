<?php

use App\Models\Order;
use function Livewire\Volt\{usesPagination, on, computed, state};

usesPagination();

state(['search' => '']);

$orders = computed(
    fn() => Order::with('customer')
        ->whereHas('customer', fn($query) => $query->where('name', 'LIKE', "%$this->search%"))
        ->latest()
        ->paginate(5),
);
on(['order-created' => fn() => ($this->orders = $this->orders)]);
?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header p-3 p-md-4 pb-0">
                <h6 class="m-0">List Penjualan</h6>
                @can('create-order')
                    <a href="#Modal" class="btn btn-dark" data-bs-toggle="modal">
                        <x-i-btn-content reverse gap="2" icon="fa-solid fa-plus">
                            Tambah Penjualan
                        </x-i-btn-content>
                    </a>
                @endrole
            </div>
            <div class="card-body p-3 p-md-4">
                <input type="search" wire:model.live="search" class="form-control form-control-sm">
                <div class="table-responsive" id="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th class="freeze"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->orders as $order)
                                <tr id="tr{{ $order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td class="freeze">
                                        <a href="{{ url('orders/' . $order->id) }}" class="btn btn-sm btn-dark"
                                            wire:navigate.hover>
                                            <x-i-btn-content icon="fa-solid fa-arrow-up-right-from-square">
                                                Detail
                                            </x-i-btn-content>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $this->orders->links('components.pagination') }}
            </div>
        </div>
    @endvolt
    @can('create-order')
        @push('modal')
            <x-orders.modal />
        @endpush
    @endcan
</x-layouts.app>
