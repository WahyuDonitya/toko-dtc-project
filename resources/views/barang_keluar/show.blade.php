@extends('layouts.app')

@push('tittle')
    Riwayat Barang Keluar
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Detail Barang Masuk</h4>

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">
                    Informasi Header Barang Keluar
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nota Barang Keluar</label>
                            <div class="form-control-plaintext">
                                {{ $barang_keluar->barangkeluar_nota }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dibuat Oleh</label>
                            <div class="form-control-plaintext">
                                {{ $barang_keluar->user->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Penganggung Jawab</label>
                            <div class="form-control-plaintext">
                                {{ $barang_keluar->penanggung_jawab }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Catatan</label>
                            <div class="form-control-plaintext">
                                {{ $barang_keluar->catatan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Detail Barang Keluar
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="detailBarang" class="table table-bordered table-hover w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Expired Date</th>
                                    <th>Jumlah Barang</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        const table = $('#detailBarang').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('barang-keluar.show', $barang_keluar->id) }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barang',
                    name: 'barang.barang_nama',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'exp_date',
                    name: 'exp_date',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    orderable: true,
                    searchable: false
                },
            ]
        })
    </script>
@endpush
