@extends('layouts.app')

@push('tittle')
    Barang Masuk
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0">Riwayat Barang Masuk</h5>
            <hr>
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-barang-masuk">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nota Barang Masuk</th>
                            <th scope="col">Nomor PO</th>
                            <th scope="col">Tanggung Jawab</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Nomor sales</th>
                            <th scope="col">Tanggal Buat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const table = $('#table-barang-masuk').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('barang-masuk.index') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barangmasuk_nota',
                    name: 'barangmasuk_nota'
                },
                {
                    data: 'hpo_nota',
                    name: 'Po.hpo_nota'
                },
                {
                    data: 'mengetahui',
                    name: 'mengetahui'
                },
                {
                    data: 'supplier',
                    name: 'Po.Supplier.nama_supplier'
                },
                {
                    data: 'sales',
                    name: 'Po.hpo_sales'
                },
                {
                    data: 'nomor_sales',
                    name: 'Po.hpo_sales_phone'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);

                $(row).css('cursor', 'pointer');
            }
        });

        let lastClick = 0;
        $('#table-barang-masuk tbody').on('click', 'tr', function() {
            const now = new Date().getTime();
            const doubleClickThreshold = 500;

            if (now - lastClick < doubleClickThreshold) {
                const id = $(this).data('id');
                if (id) {
                    window.location.href = '{{ route('barang-masuk.show', '') }}/' + id;
                }
            }
            lastClick = now;
        });
    </script>
@endpush
