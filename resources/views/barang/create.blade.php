@extends('layouts.app')

@push('tittle')
    {{ isset($barang) ? 'Edit Barang' : 'Tambah Barang' }}
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ isset($barang) ? 'Edit Barang' : 'Tambah Barang' }}</h5>
            <hr>
            @if (isset($barang))
                <form action="{{ route('barangs.update', $barang->id) }}" method="post" class="row g-3" id="barangForm">
                    @method('PUT')
                @else
                    <form action="{{ route('barangs.store') }}" method="post" class="row g-3" id="barangForm">
            @endif

            @csrf
            <div class="col-md-12">
                <label for="input25" class="form-label">Nama Barang</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25" placeholder="Ex : Marina Handbody 200ml"
                        name="barang_nama" value="{{ old('barang_nama', $barang->barang_nama ?? '') }}">
                </div>
                @error('barang_nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="input27" class="form-label">Barcode Barang</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                    <input type="text" class="form-control" id="input27" placeholder="Ex : 03282102"
                        name="barang_barcode" value="{{ old('barang_barcode', $barang->barang_barcode ?? '') }}">
                </div>
                @error('barang_barcode')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <div class="d-md-flex d-grid align-items-center gap-3">
                    @if (isset($barang))
                        <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4"><i
                                class="bx bx-edit"></i>Update</button>
                    @else
                        <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4"><i
                                class="bx bx-save"></i>Simpan</button>
                    @endif

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
                document.getElementById('barangForm').submit();
            }
        }
    </script>
@endpush
