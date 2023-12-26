<?php

namespace App\Livewire\Pages\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class Create extends Component
{
    use WithFileUploads;
    public $server_id;
    public $packet_id;
    public $name;
    public $nik;
    public $phone;
    public $coordinate;
    public $address;
    public $ktp_picture;
    public $house_picture;

    public function submit()
    {
        session()->flash('success','form submitted')
        // $this->validate([
        //     'server_id' => 'required|exists:servers,id',
        //     'packet_id' => 'required|exists:packets,id',
        //     'name' => 'required|max:255',
        //     'nik' => 'required|numeric|digits:16',
        //     'phone' => 'required|min:11|max:15',
        //     'coordinate' => ['required', 'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', 'max:255'],
        //     'address' => 'required|max:255',
        //     'ktp_picture' => 'required|image|mimes:jpg,png,jpeg,bmp',
        //     'house_picture' => 'required|image|mimes:jpg,png,jpeg,bmp',
        // ]);

        // try {
        //     $manager = new ImageManager(new Driver());
        //     $ktp_filename = Str::random(32);
        //     $ktp_dir = Str::random(1);
        //     $ktp_encoded = $manager->read($this->ktp_picture)->toJpeg(50);
        //     Storage::disk('private')->put("customers/ktp/$ktp_dir/$ktp_filename.jpeg", $ktp_encoded);

        //     $house_filename = Str::random(32);
        //     $house_dir = Str::random(1);
        //     $house_encoded = $manager->read($this->house_picture)->toJpeg(50);
        //     Storage::disk('private')->put("customers/house/$house_dir/$house_filename.jpeg", $house_encoded);
        // } catch (\Exception $e) {
        //     $this->dispatch('error', $e->getMessage());
        //     return;
        // }


        // try {
        //     DB::beginTransaction();
        //     $customer = Customer::create([
        //         'name' => $this->name,
        //         'phone' => $this->phone,
        //         'region_id' => auth()->user()->region_id,
        //         'server_id' => $this->server_id,
        //         'packet_id' => $this->packet_id,
        //         'address' => $this->address,
        //         'coordinate' => $this->coordinate,
        //         'status' => 0,
        //     ]);

        //     $last_id = Order::whereDate('created_at', now())
        //         ->latest()
        //         ->pluck('id')
        //         ->first();

        //     if ($last_id) {
        //         $last_id = str_split($last_id, 9);
        //         $order_id = 'O' . date('Ymd') . (str_pad((int) $last_id[1] + 1, 3, '0', STR_PAD_LEFT));
        //     } else {
        //         $order_id = 'O' . date('Ymd') . '001';
        //     }

        //     Order::create([
        //         'id' => $order_id,
        //         'customer_id' => $customer->id,
        //         'marketer_id' => auth()->user()->id,
        //         'status' => 0,
        //     ]);
        //     DB::commit();
        //     $this->dispatch('success');
        // } catch (\Throwable $th) {
        //     $this->dispatch('error', $th->getMessage());
        //     return;
        // }
    }
    public function render()
    {
        return view('livewire.pages.orders.create');
    }
}
