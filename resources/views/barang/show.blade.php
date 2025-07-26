@extends('layouts.app')

@push('tittle')
    Detail Barang
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Detail barang</h5>
            <hr>

            <p><strong>Informasi Header Barang</strong></p>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Barang:</strong> {{ $barang->barang_nama }}</p>
                    <p><strong>HET:</strong> Rp {{ number_format($barang->het, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Barang:</strong> {{ $barang->barang_nama }}</p>
                    <p><strong>Nama Barang:</strong> Rp {{ number_format($barang->barang_harga, 0, ',', '.') }}</p>
                    {{-- <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($hpo->hpo_jatuhtempo)->format('d-m-Y') }}</p> --}}
                    </p>
                </div>
            </div>

            <hr>
            <p><strong>Detail Barang</strong></p>
            <div class="table-responsive">
                <table id="detailBarang" class="table table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Exp Date</th>
                            <th>Batch</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
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
                    url: "{{ route('barangs.show', $barang->id) }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'exp_date_formatted',
                        name: 'exp_date'
                    },
                    {
                        data: 'batch',
                        name: 'batch',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        })
    </script>
@endpush
