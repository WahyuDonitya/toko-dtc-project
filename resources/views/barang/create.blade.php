@extends('layouts.app')

@push('tittle')
    Tambah Barang
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Form Penambahan Barang</h5>
            <hr>
            <form action="{{ route('barangs.store') }}" method="post" class="row g-3" id="barangForm">
                @csrf
                <div class="col-md-12">
                    <label for="input25" class="form-label">Nama Barang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-box"></i></span>
                        <input type="text" class="form-control" id="input25" placeholder="Ex : Marina Handbody 200ml"
                            name="barang_nama" value="{{ old('barang_nama') }}">
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
                            name="barang_barcode" value="{{ old('barang_barcode') }}">
                    </div>
                    @error('barang_barcode')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function handleClickSubmit() {
            if (window.confirm('Are you sure to submit this data?')) {
                document.getElementById('barangForm').submit();
            }
        }
    </script>
@endpush
