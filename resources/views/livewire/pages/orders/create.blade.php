<div class="modal fade" id="Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabel">Tambah Penjualan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="submit">
                    <div class="form-floating has-validation">
                        <select id="server_id" class="form-select" wire:model="server_id">
                            <option value="">Server</option>
                        </select>
                        <label for="server_id">Zona</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('server_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <select id="packet_id" class="form-select" wire:model="packet_id">
                            <option value="">Server</option>
                        </select>
                        <label for="packet_id">Paket Pilihan</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('packet_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="name" type="text" wire:model="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nama">
                        <label for="name">Nama Calon User</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="nik" type="number" wire:model="nik"
                            class="form-control @error('nik') is-invalid @enderror" placeholder="NIK">
                        <label for="nik">NIK</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('nik')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="phone" type="tel" wire:model="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Phone">
                        <label for="phone">Phone</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="coordinate" type="text" wire:model="coordinate"
                            class="form-control @error('coordinate') is-invalid @enderror" placeholder="coordinate">
                        <label for="coordinate">Koordinat</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('coordinate')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <textarea type="text" id="address" class="form-control @error('address') is-invalid @enderror" style="height: 7rem"
                            placeholder="Alamat" wire:model="address"></textarea>
                        <label for="address">Alamat</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    @if ($ktp_picture)
                        <img src="{{ $ktp_picture->temporaryUrl() }}" class="w-100 rounded-3">
                    @endif
                    <div wire:loading wire:target="ktp_picture">
                        <i class="fa-solid fa-spin fa-spinner me-1"></i>
                        Memproses Foto
                    </div>
                    <div class="form-floating has-validation">
                        <input type="file" id="ktp_picture"
                            class="form-control form-control-file @error('ktp_picture') is-invalid @enderror"
                            wire:model="ktp_picture" placeholder="Foto KTP">
                        <label for="ktp_picture">Foto KTP</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('ktp_picture')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    @if ($house_picture)
                        <img src="{{ $house_picture->temporaryUrl() }}" class="w-100 rounded-3">
                    @endif
                    <div class="form-floating has-validation">
                        <input type="file" id="house_picture" class="form-control form-control-file"
                            wire:model="house_picture" placeholder="Foto KTP">
                        <label for="house_picture">Foto KTP</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('house_picture')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-dark w-100 btn-lg">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{--
<div class="row  justify-content-center">
    <div class="col-md-6">
        <div class="card {{ $errors->any() ? 'border border-danger' : '' }}">
            <div class="card-header">
                <h6 class="m-0">
                    <a href="{{ url('orders') }}" class="link link-dark me-2" wire:navigate.hover>
                        <i class="fa-solid fa-chevron-circle-left fa-lg"></i>
                    </a>

                </h6>
            </div>
            <div class="card-body">

            </div>
            <div class="btn"
                @click="myModal.show()">KLIK</div>
        </div>
    </div>
</div> --}}
{{-- @script
    <script>

    </script>
@endscript --}}
