@extends('layouts.app')

@push('tittle')
    Barang Masuk
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ route('supplier.create') }}" class="btn btn-primary px-5 mb-1"><i class="bx bx-plus"></i>Add
                Supplier</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>List Supplier</h5>
            <hr>
            
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
