<?php

use App\Models\Report;
use function Livewire\Volt\{usesPagination, on, computed, state};

usesPagination();

state(['search' => '']);

$reports = computed(
    fn() => Report::with('customer')
        ->whereHas('customer', fn($query) => $query->where('name', 'LIKE', "%$this->search%"))
        ->latest()
        ->paginate(5),
);
on(['report-created' => fn() => ($this->reports = $this->reports)]);
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
                @push('modal')
                    <x-reports.modal />
                @endpush
            </div>
            <div class="card-body p-3 p-md-4">
                <input type="search" wire:model.live="search" class="form-control form-control-sm">
                <div class="table-responsive" id="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Penerima</th>
                                <th>Pelanggan</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Jenis Laporan</th>
                                <th>Terima</th>
                                <th>Status</th>
                                <th class="freeze"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->reports as $report)
                                <tr>
                                    <td>{{ $report->created_at->translatedFormat('l, j F Y') }}</td>
                                    <td>{{ $report->cs->name }}</td>
                                    <td>{{ $report->customer->name }}</td>
                                    <td>{{ $report->customer->address }}</td>
                                    <td>{{ $report->customer->phone }}</td>
                                    <td>{{ $report->report_type }}</td>
                                    <td>{{ $report->created_at->translatedFormat('H:i') }}</td>
                                    <td>{{ ['Menunggu','Open','Proses','Done','Cancel'][$report->status] }}</td>
                                    <td class="freeze">
                                        <a href="{{ url('reports/' . $report->id) }}" class="btn btn-sm btn-dark"
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
                {{ $this->reports->links('components.pagination') }}
            </div>
        </div>
        @script
            <script>
                $wire.on('fire-success', (event) => {
                    Success.fire(event.message)
                })
                $wire.on('fire-failed', (event) => {
                    console.error(event.errors)
                    Failed.fire(event.message)
                })
            </script>
        @endscript
    @endvolt
</x-layouts.app>
