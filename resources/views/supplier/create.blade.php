@extends('layouts.app')

@push('tittle')
    Tambah Supplier
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier' }}</h5>
            <hr>

            <p><b>NB : <span class="text-danger">*)</span> Wajib diisi</b></p>

            @if (isset($supplier))
                <form action="{{ route('supplier.update', $supplier->id) }}" method="post" class="row g-3" id="barangForm">
                    @method('PUT')
                @else
                    <form action="{{ route('supplier.store') }}" method="post" class="row g-3" id="barangForm">
            @endif

            @csrf

            <div class="col-md-6">
                <label for="input25" class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25" placeholder="Ex : PT. Paragon"
                        name="supplier_nama" value="{{ old('supplier_nama', $supplier->supplier_nama ?? '') }}">
                </div>
                @error('supplier_nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="input25" class="form-label">Telpon Supplier <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25" placeholder="Ex : 0818100224"
                        name="supplier_telpon" value="{{ old('supplier_telpon', $supplier->supplier_telpon ?? '') }}">
                </div>
                @error('supplier_telpon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label for="input25" class="form-label">Alamat Supplier <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25"
                        placeholder="Ex : Jl. Tunjungan nomor 4 (Depan Gramedia)" name="supplier_alamat"
                        value="{{ old('supplier_alamat', $supplier->supplier_alamat ?? '') }}">
                </div>
                @error('supplier_alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="input25" class="form-label">Nama Sales</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25" placeholder="Ex : Rahmat" name="sales_nama"
                        value="{{ old('sales_nama', $supplier->sales_nama ?? '') }}">
                </div>
                @error('sales_nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input25" class="form-label">Telpon Sales</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="text" class="form-control" id="input25" placeholder="Ex : 0818100224"
                        name="sales_telpon" value="{{ old('sales_telpon', $supplier->sales_telpon ?? '') }}">
                </div>
                @error('sales_telpon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input25" class="form-label">Tempo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-box"></i></span>
                    <input type="number" class="form-control" id="input25" placeholder="Ex : 4" name="supplier_tempo"
                        value="{{ old('supplier_tempo', $supplier->supplier_tempo ?? '') }}">
                    <span class="input-group-text">Hari</span>
                </div>
                @error('supplier_tempo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <div class="d-md-flex d-grid align-items-center gap-3">
                    @if (isset($supplier))
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
            Swal.fire({
                title: "Apakah data yang dimasukkan sudah benar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Simpan"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('barangForm').submit();
                }
            });
        }
    </script>
@endpush
