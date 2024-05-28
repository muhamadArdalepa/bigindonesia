<?php

use function Livewire\Volt\{state, rules};
state(['email', 'password', 'fails' => false]);

$login = function () {
    $validated = $this->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6',
    ]);
    if (auth()->attempt($validated)) {
        session()->regenerate();
        return $this->redirect(url('a/dashboard'), navigate: true);
    }
    $this->fails = true;
};

?>

<x-layouts.guest>
    @volt
        <div class="col-md-4 col-sm-7 col-12">
            <div class="card w-100">
                <div class="card-header flex-column">
                    <img src="{{ asset('img/logos/big-warna.png') }}" height="50px" class="mb-3">
                    <h4 class="m-0">BIG Super App</h4>
                    <p class="m-0">Masuk Untuk Melanjutkan</p>
                </div>
                <div class="card-body">
                    <form wire:submit="login()">
                        <div class="mb-3">
                            <input type="email" wire:model="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                            @error('email')
                                <div class="invalid-feedback text-sm ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-group @error('password') has-validation @enderror @if ($fails) has-validation @endif mb-3">
                            <input type="password" wire:model="password" style="border-right: none !important" class="form-control @error('password') is-invalid @enderror @if ($fails) is-invalid @endif form-control-lg" placeholder="Password">
                            <span onclick="showPassword(this)" style="border-left: none !important" class="input-group-text">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                            @error('password')
                                <div class="invalid-feedback text-sm ps-2">{{ $message }}</div>
                            @enderror
                            @if ($fails)
                                <div class="invalid-feedback text-sm ps-2">Password Salah</div>
                            @endif
                        </div>
                        <button class="btn btn-dark btn-lg w-100">Login</button>
                        <div class="d-flex text-sm mt-3 ">
                            <a href="{{url('/g/faq')}}">Butuh Bantuan?</a>
                            <a class="ms-auto" href="{{url('/g/forgot-password')}}">Lupa Password</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endvolt
</x-layouts.guest>
