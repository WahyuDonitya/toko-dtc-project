@extends('layouts.app')

@push('tittle')
    Barang
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ route('barangs.create') }}" class="btn btn-primary px-5 mb-1"><i class="bx bx-plus"></i>Add
                Barang</a>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5>List Barang</h5>
            <hr>
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-barang">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Barcode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col" class="text-center">Stok Barang Keseluruhan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $b)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $b->barang_barcode }}</td>
                                <td>{{ $b->barang_nama }}</td>
                                <td class="text-center">{{ $b->barang_stok }}</td>
                                <td class="text-center">
                                    <a href="{{ route('barangs.show', $b->id) }}" class="btn btn-sm btn-primary"
                                        title="Lihat Detail">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('barangs.edit', $b->id) }}" class="btn btn-sm btn-success"
                                        title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="{{ route('barangs.destroy', $b->id) }}" class="btn btn-sm btn-danger"
                                        title="Delete" data-confirm-delete="true">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#table-barang').DataTable();
    </script>
@endpush
