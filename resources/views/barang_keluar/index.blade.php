@extends('layouts.app')

@push('tittle')
    Riwayat Barang Keluar
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0">Riwayat Barang Keluar</h5>
            <hr>
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-barang-keluar">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nota Barang Keluar</th>
                            <th scope="col">Penanggung Jawab</th>
                            <th scope="col">Dibuat Oleh</th>
                            <th scope="col">Catatan</th>
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
        const table = $('#table-barang-keluar').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('barang-keluar.index') }}'
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'barangkeluar_nota',
                name: 'barangkeluar_nota',
                orderable: false,
                searchable: true
            }, {
                data: 'penanggung_jawab',
                name: 'penanggung_jawab',
                orderable: false,
                searchable: true
            }, {
                data: 'pembuat',
                name: 'user.name',
                orderable: true,
                searchable: true
            }, {
                data: 'catatan',
                name: 'catatan',
                orderable: false,
                searchable: true
            }, {
                data: 'created_at_format',
                name: 'created_at',
                orderable: true,
                searchable: false
            }, {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false
            }],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);

                $(row).css('cursor', 'pointer');
            }
        });

        let lastClick = 0;
        $('#table-barang-keluar tbody').on('click', 'tr', function() {
            const now = new Date().getTime();
            const doubleClickThreshold = 500;

            if (now - lastClick < doubleClickThreshold) {
                const id = $(this).data('id');
                if (id) {
                    window.location.href = '{{ route('barang-keluar.show', '') }}/' + id;
                }
            }
            lastClick = now;
        });
    </script>
@endpush
