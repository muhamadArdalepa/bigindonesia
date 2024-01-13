<?php
use App\Models\Odp;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\InstallationProcedure;
use function Livewire\Volt\{state, on};
use App\Models\InstallationProcedureDetail;

state([
    'procedure' => fn() => $this->procedure,
    'form' => fn() => $this->procedure->details[0],
    'user' => fn() => $this->procedure->details[1],
    'desc'=> fn() => $this->procedure->desc,
    'isFilled' => fn() => $this->form->picture && $this->user->picture,
]);
on([
    'picture-added' => function () {
        if ($this->form->picture && $this->user->picture) {
            $this->isFilled = true;
        }
    },
]);

$save = function () {
    try {
        DB::beginTransaction();
        $this->procedure->desc = $this->desc;
        if (!$this->procedure->is_done) {
            $this->procedure->is_done = true;
            $this->procedure->installation->status = 2;
            $this->procedure->installation->save();

            $customer = $this->procedure->installation->order->customer;
            $int_id = str_pad(intval(substr(Customer::where('server_id', $customer->server_id)->orderBy('id', 'desc')->first()->id, 1)) + 1, 4, "0", STR_PAD_LEFT);            
            $customer->number =  $customer->server->code. $int_id;
            $customer->va = str_pad($customer->server_id, 2, "0", STR_PAD_LEFT) .  $int_id;
            $customer->save();
            Invoice::create([
                'customer_id' => $customer->id,
                'type' => 0,
            ]);
        }
        $this->procedure->save();
        DB::commit();
        $this->dispatch('procedure-updated');
    } catch (\Throwable $th) {
        DB::rollBack();
        $this->dispatch('procedure-fails');
    }
};

?>
<div>
    @volt
        <div class="d-flex gap-4 flex-column">
            <livewire:installations.procedure-image-uploader :data="$form" />
            <livewire:installations.procedure-image-uploader :data="$user" />
            <form wire:submit="save">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="Keterangan" wire:model="desc">
                    <label>Keterangan (Opsional)</label>
                </div>
                @if ($isFilled)
                    <div class="text-end" >
                        <button class="btn btn-dark" wire:dirty>Simpan</button>
                    </div>
                @endif
            </form>
        </div>
    @endvolt
</div>
