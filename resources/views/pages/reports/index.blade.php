<?php

use App\Models\Order;
use function Livewire\Volt\{usesPagination, on, computed, state};

usesPagination();

state(['search' => '']);

$orders = computed(
    fn () => Order::with('customer')
        ->whereHas('customer', fn ($query) => $query->where('name', 'LIKE', "%$this->search%"))
        ->latest()
        ->paginate(5),
);
on(['order-created' => fn () => ($this->orders = $this->orders)]);
?>
<x-layouts.app>
    @volt
    <div class="card">
        <div class="card-header p-3 p-md-4 pb-0">
            <h6 class="m-0">List Laporan Gangguan</h6>
            <a href="#Modal" class="btn btn-dark" data-bs-toggle="modal">
                <x-i-btn-content reverse gap="2" icon="fa-solid fa-plus">
                    Tambah Laporan
                </x-i-btn-content>
            </a>
            @push('modal') <x-reports.modal /> @endpush
        </div>
        <div class="card-body p-3 p-md-4">
            <input type="search" wire:model.live="search" class="form-control form-control-sm">
            <div class="table-responsive" id="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Marketer</th>
                            <th>Nama Calon User</th>
                            <th>No Telepon</th>
                            <th>Koordinat</th>
                            <th>Alamat</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th class="freeze"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->marketer->name }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{{ $order->customer->coordinate }}</td>
                            <td>{{ $order->customer->address }}</td>
                            <td>
                                {{ $order->customer->packet->name }}
                                 - 
                                {{ number_format($order->customer->packet->price) }}
                            </td>
                            <td>{{ $order->status }}</td>
                            <td class="freeze">
                                <a href="{{ url('orders/' . $order->id) }}" class="btn btn-sm btn-dark" wire:navigate.hover>
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
</x-layouts.app>
