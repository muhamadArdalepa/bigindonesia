<?php
use App\Models\User;
use function Livewire\Volt\{state, computed, placeholder, usesPagination};
usesPagination();
state([
    'access' => fn() => $this->access,
])->reactive();

state([
    'search', 
    'region_id' => fn() => auth()->user()->region_id, 
    'order' => ['name', 'asc']
]);

$users = computed(
    fn() => User::where(function ($query) {
            $query
                ->where('name', 'LIKE', "%$this->search%")
                ->orWhere('email', 'LIKE', "%$this->search%")
                ->orWhere('phone', 'LIKE', "%$this->search%");
        })
        ->orderBy($this->order[0], $this->order[1])
        ->paginate(25),
);

?>

<div>
    @volt
        <div>
            <div class="d-flex">
                <input type="search" wire:model.live="search" class="form-control">
                <select class=""></select>
            </div>
            <div class="table-responsive" id="table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Is Place ?</th>
                            <th>Peran</th>
                            <th class="freeze"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8">Loading</td>
                            <td class="freeze"></td>
                        </tr>
                        @foreach ($this->users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->avatar }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge bg-gradient-{{ $user->isActive ? 'success' : 'danger' }}">
                                        @if ($user->isActive)
                                            <i class="fa-solid fa-circle fa-2xs me-1"></i>
                                        @endif
                                        {{ $user->isActive ? 'Hadir' : 'Tidak Hadir' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-{{ $user->isPlace ? 'success' : 'danger' }}">
                                        {{ $user->isPlace ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <ul class="m-0">
                                        @foreach ($user->roles()->whereNot('name', $access)->get() as $role)
                                            <li> {{ $role->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="freeze">
                                    <button class="btn btn-dark btn-sm">
                                        <x-i-btn-content icon="fa-solid fa-pen-to-square" reverse gap="2">
                                            Edit
                                        </x-i-btn-content>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $this->users->links('components.pagination') }}
        </div>
    @endvolt
</div>
