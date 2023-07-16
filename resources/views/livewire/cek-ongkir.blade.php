<div>
    {{-- Form --}}
    <div class="card mt-5 mx-5 p-5">
        <h3>Cek Ongkir Dari Kota DI Yogyakarta</h3>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                <label for="province" class="form-label">Provinsi</label>
                <select id="province" wire:model="province" class="form-select @error('province') is-invalid @enderror">
                <option>Choose one...</option>
                @foreach ($refProvinces as $prov)
                    <option value="{{$prov['province_id']}}">{{$prov['province']}}</option>
                @endforeach
                </select>
                @error('province')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                <label wire:loading wire:target="province" for="destination" class="form-label">Loading..</label>
                <label wire:loading.remove wire:target="province" for="destination" class="form-label">Kota/Kabupaten</label>
                <select id="destination"  wire:model="destination" class="form-select @error('destination') is-invalid @enderror">
                    <option selected>Choose One..</option>
                    @if ($refCities != null)
                        @foreach ($refCities as $city)
                            <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                        @endforeach
                    @endif
                </select>
                @error('destination')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                <label for="weight">Berat (gram)</label>
                <input class="form-control @error('weight') is-invalid @enderror" type="number" wire:model="weight" placeholder="berat barang">
                @error('weight')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                <label for="courier">Kurir</label>
                <select id="courier"  wire:model="courier" class="form-select @error('courier') is-invalid @enderror">
                    <option selected>Semua Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS</option>
                    <option value="tiki">TIKI</option>
                </select>
                @error('courier')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-primary" wire:click="cekOngkir" wire:target="cekOngkir" wire:loading.attr="disabled">
                <div wire:loading wire:target="cekOngkir">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </div>
                <div wire:loading.remove wire:target="cekOngkir">Cek Ongkir</div>
            </button>
        </div>
    </div>
    {{-- end Form --}}

    <div class="card m-5 p-5">
        <h3>Daftar Layanan Ekspedisi</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Deskripsi</th>
                        <th>Biaya (Rp)</th>
                        <th>Estimasi (hari)</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($availableOngkir)
                        @foreach ($availableOngkir as $ongkir)
                            @foreach ($ongkir['costs'] as $costs)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$costs['service']}}</td>
                                <td>{{$costs['description']}}</td>
                                @foreach ($costs['cost'] as $cost)
                                    <td>Rp.{{$cost['value']}}</td>
                                    <td>{{$cost['etd']}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center">Data Belum Ada</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
