@extends('layouts.app')

@push('tittle')
    Barang Masuk
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

            {{-- Informasi Header Barang Masuk --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">
                    Informasi Header Barang Masuk
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nota Barang Masuk</label>
                            <div class="form-control-plaintext">
                                {{ $hbarang_masuk->barangmasuk_nota }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nomor PO</label>
                            <div class="form-control-plaintext">
                                {{ $hbarang_masuk->Po->hpo_nota }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Supplier</label>
                            <div class="form-control-plaintext">
                                {{ $hbarang_masuk->Po->supplier->supplier_nama }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sales</label>
                            <div class="form-control-plaintext">
                                {{ $hbarang_masuk->Po->hpo_sales }} / {{ $hbarang_masuk->Po->hpo_sales_phone ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Karyawan Mengetahui</label>
                            <div class="form-control-plaintext">
                                {{ $hbarang_masuk->mengetahui ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Barang Masuk --}}
            <div class="card border shadow-sm">
                <div class="card-header bg-light fw-bold">
                    Detail Barang Masuk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="detailBarang" class="table table-bordered table-hover w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Expired Date</th>
                                    <th>Jumlah Datang</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
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
        $(document).ready(function() {
            $('#detailBarang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('barang-masuk.show', $hbarang_masuk->id) }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barang_nama',
                        name: 'barang.barang_nama',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'exp_formated',
                        name: 'exp',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'barangmasuk_jumlah',
                        name: 'barangmasuk_jumlah',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'barangmasuk_harga_formated',
                        name: 'barangmasuk_harga',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'sub_total',
                        name: 'sub_total',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush
