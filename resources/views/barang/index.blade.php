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
                            <th scope="col" class="text-center">HET</th>
                            <th scope="col" class="text-center">Harga Barang</th>
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
        const table = $('#table-barang').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route('barangs.index') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barang_barcode',
                    name: 'barang_barcode'
                },
                {
                    data: 'barang_nama',
                    name: 'barang_nama'
                },
                {
                    data: 'barang_stok',
                    name: 'barang_stok',
                    className: 'text-center'
                },
                {
                    data: 'het',
                    name: 'het',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                        return data;
                    }
                },
                {
                    data: 'barang_harga',
                    name: 'barang_harga',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                        return data;
                    }
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


        $('table').on('click', '.delete-barang', function() {
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
                            url: '{{ route('barangs.destroy', ':id') }}'.replace(':id', id),
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
