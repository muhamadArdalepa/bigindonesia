<div class="card">
    <div class="card-header">
        <h6 class="m-0">List Penjualan</h6>
        <a href="#Modal" class="btn btn-dark" data-bs-toggle="modal">
            Tambah Penjualan
        </a>
    </div>
</div>
@push('modal')
    <livewire:pages.orders.create />
@endpush
