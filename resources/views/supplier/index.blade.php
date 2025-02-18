@extends('layouts.app')

@push('tittle')
    Supplier
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
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-supplier">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Supplier</th>
                            <th scope="col">Telpon Supplier</th>
                            <th scope="col">Supplier Alamat</th>
                            <th scope="col" class="text-center">Tempo (Hari)</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const table = $('#table-supplier').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('supplier.index') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'supplier_nama',
                    name: 'supplier_nama'
                },
                {
                    data: 'supplier_telpon',
                    name: 'supplier_telpon'
                },
                {
                    data: 'supplier_alamat',
                    name: 'supplier_alamat',
                },
                {
                    data: 'supplier_tempo',
                    name: 'supplier_tempo',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ]
        });

        $('table').on('click', '.delete-supplier', function() {
            Swal.fire({
                title: "Konfirmasi Hapus",
                text: "Apakah anda yakin ingin hapus data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    if (id) {
                        $.ajax({
                            url: '{{ route('supplier.destroy', ':id') }}'.replace(':id', id),
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        title: "SUKSES!",
                                        text: response.message,
                                        icon: "success"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "GAGAL!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi kesalahan pada server.",
                                    icon: "error"
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush
