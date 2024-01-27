<?php

use App\Models\Installation;
use function Livewire\Volt\{usesPagination, on, computed, state};

usesPagination();

state(['search' => '']);

$orders = computed(
    fn() => Installation::latest()
        ->paginate(5),
);
?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header p-3 p-md-4 pb-0">
                <h5 class="m-0">List Penjualan</h5>
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
                            @foreach ($this->installations as $installation)
                                <tr>
                                    <td>{{ $installation->id }}</td>
                                    <td>{{ $installation->customer->name }}</td>
                                    <td class="freeze">
                                        <a href="{{ url('installations/' . $order->id) }}" class="btn btn-sm btn-dark"
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
</x-layouts.app>
