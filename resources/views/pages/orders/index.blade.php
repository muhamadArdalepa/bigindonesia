<?php

use function Livewire\Volt\{with, usesPagination, on, computed};

usesPagination();
$orders = computed(function () {
    return \App\Models\Customer::latest()->paginate(5);
});
with(fn() => ['orders' => $this->orders]);
on(['order-created' => fn() => ($this->orders = $this->orders)]);

?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header">
                <h6 class="m-0">List Penjualan</h6>
                <a href="#Modal" class="btn btn-dark" data-bs-toggle="modal">
                    Tambah Penjualan
                </a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-sm opacity-7">
                        Menampilkan
                        {{ 1 + $orders->perPage() * ($orders->currentPage() - 1) }}
                        hingga
                        {{$orders->currentPage() == $orders->lastPage() ? $orders->total() : ($orders->perPage() * ($orders->currentPage())) }}
                        dari
                        {{ $orders->total() }}
                        entri
                    </div>
                    {{ $orders->links('vendor.livewire.bootstrap') }}
                </div>
            </div>
        </div>
    @endvolt
    @push('modal')
        <livewire:order.modal />
    @endpush
</x-layouts.app>
