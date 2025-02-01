@extends('layouts.app')

@push('tittle')
    Barang Masuk
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Barang Masuk</h5>
            <hr>
            <p><b><i>Nb: Tanda <span class="text-danger">*)</span> Wajib diisi</i></b></p>
            <form action="" method="post" class="row g-3" id="barangMasuk">
                @csrf
                <div class="col-md-12">
                    <label for="input25" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                        <select name="barang" id="barang" class="select2">
                            <option value="">Pilih barang</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="input27" class="form-label">Jumlah barang masuk (PCS) <span
                            class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-layer"></i></span>
                        <input type="number" class="form-control" id="input27" placeholder="Ex : 20" name="jumlah_barang"
                            value="{{ old('jumlah_barang_masuk') }}">
                    </div>
                    @error('jumlah_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="input27" class="form-label">Harga Jual Saat ini</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                        <input type="text" class="form-control" id="input27" name="jumlah_barang"
                            value="{{ old('jumlah_barang') }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="input27" class="form-label">Harga barang masuk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-money"></i></span>
                        <input type="number" class="form-control" id="input27" placeholder="Ex : 2000000"
                            name="harga_barang" value="{{ old('harga_barang') }}">
                    </div>
                    @error('harga_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input27" class="form-label">Supplier <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bxs-truck"></i></span>
                        <select name="supplier" id="supplier" class="select2">
                            <option value="">Pilih supplier</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('supplier')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input27" class="form-label">Detail Supplier</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-detail"></i></span>
                        <input type="text" class="form-control" id="input27" placeholder="Ex : Pabrik, Rekanan, dll"
                            name="detail_supplier" value="{{ old('detail_supplier') }}">
                    </div>
                    @error('detail_supplier')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4"><i
                                class="bx bx-save"></i>Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function handleClickSubmit() {
            if (window.confirm('Apakah data yang dimasukkan sudah benar?')) {
                document.getElementById('barangMasuk').submit();
            }
        }
    </script>
@endpush
