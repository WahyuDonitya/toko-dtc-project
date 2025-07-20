@extends('layouts.app')

@push('tittle')
    List Purchase Order
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>List Purchase Order</h5>
            <hr>
            <p><b><i>Double Click data untuk melihat detail</i></b></p>
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-po">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nota PO</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Supplier Detail</th>
                            <th scope="col">Informasi Sales</th>
                            <th scope="col" class="text-center">Jumlah Pembelian</th>
                            <th scope="col" class="text-center">Jumlah Dibayar</th>
                            <th scope="col" class="text-center">Jumlah Sisa</th>
                            <th scope="col">Jatuh Tempo</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Status Penerimaan</th>
                            <th scope="col">Dibuat Oleh</th>
                            <th scope="col">Dibuat Pada</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const table = $('#table-po').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('purchase-order.index') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'hpo_nota',
                    name: 'hpo_nota'
                },
                {
                    data: 'supplier.supplier_nama',
                    name: 'supplier_nama',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'hpo_supplierdetail',
                    name: 'hpo_supplierdetail'
                },
                {
                    data: 'sales_info',
                    name: 'hpo_sales',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'hpo_jumlahpembelian',
                    name: 'hpo_jumlahpembelian',
                    className: 'text-center',
                    orderable: true,
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                        return data;
                    }
                },
                {
                    data: 'hpo_jumlahdibayar',
                    name: 'hpo_jumlahdibayar',
                    className: 'text-center',
                    orderable: true,
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                        return data;
                    }
                },
                {
                    data: 'hpo_jumlahbelumdibayar',
                    name: 'hpo_jumlahbelumdibayar',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                        return data;
                    }
                },
                {
                    data: 'hpo_jatuhtempo_formatted',
                    name: 'hpo_jatuhtempo',

                },
                {
                    data: 'is_lunas_badge',
                    name: 'is_lunas_badge',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'is_penerimaan_badge',
                    name: 'is_penerimaan_badge',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'created_by_nama',
                    name: 'created_by',
                    // className: 'text-center'
                },
                {
                    data: 'created_at_formatted',
                    name: 'created_at',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);

                $(row).css('cursor', 'pointer');
            }
        });

        let lastClick = 0;
        $('#table-po tbody').on('click', 'tr', function() {
            const now = new Date().getTime();
            const doubleClickThreshold = 500;

            if (now - lastClick < doubleClickThreshold) {
                const id = $(this).data('id');
                if (id) {
                    window.location.href = '{{ route('purchase-order.show', '') }}/' + id;
                }
            }
            lastClick = now;
        });
    </script>
@endpush
