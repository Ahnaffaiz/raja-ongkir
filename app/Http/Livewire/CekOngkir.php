<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CekOngkir extends Component
{
    public $weight, $origin, $destination, $province, $courier;
    public $refProvinces, $refCities, $availableOngkir;

    //api key
    public $key = "8ead3b20b3b1bbd3f9ac7363ad3bb193";
    public $provinceApi = "https://api.rajaongkir.com/starter/province";
    public $cityApi = "https://api.rajaongkir.com/starter/city";
    public $costApi = "https://api.rajaongkir.com/starter/cost";

    protected $rules = [
        'weight' => 'required',
        'origin' => 'required',
        'destination' => 'required',
        'province' => 'required',
        'courier' => 'required',
    ];

    public function mount()
    {
        $response = Http::get($this->cityApi,[
            'key' => $this->key,
            'province' => 5,
        ]);
        $this->origin = $this->searchYogyaCity('DI Yogyakarta',$response->json()['rajaongkir']['results']);

        $this->getProvince();
    }

    public function updatedProvince()
    {
        $this->getCity($this->province);
    }
    
    public function render()
    {
        return view('livewire.cek-ongkir');
    }

    public function getProvince()
    {
        $response = Http::get($this->provinceApi,[
            'key' => $this->key
        ]);
        
        $this->refProvinces = $response->json()['rajaongkir']['results'];
    }

    public function getCity($id_province)
    {
        $response = Http::get($this->cityApi,[
            'key' => $this->key,
            'province' => $id_province
        ]);
        
        $this->refCities = $response->json()['rajaongkir']['results'];
    }

    public function cekOngkir()
    {
        $this->validate($this->rules);

        $response = Http::post($this->costApi,[
            'key' => $this->key,
            'weight' => $this->weight,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'courier' => $this->courier,
        ]);
        
        $this->availableOngkir = $response->json()['rajaongkir']['results'];
    }

    function searchYogyaCity($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['province'] === $id) {
                return $val['city_id'];
            }
        }
        return null;
    }
}
