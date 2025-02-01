@extends('layouts.app')

@push('tittle')
    Pengguna
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ route('users.create') }}" class="btn btn-primary px-5 mb-1"><i class="bx bx-user-plus mr-1"></i>Add
                User</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>List dan Akses Pengguna</h5>
            <hr>
            <div class="table-responsive">
                <table class="table mb-5 table-striped w-100" id="table-users">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Panjang</th>
                            <th scope="col">Email</th>
                            <th scope="col">Username</th>
                            <th scope="col">Tanggal Daftar</th>
                            <th scope="col" class="text-center">Module Barang</th>
                            <th scope="col" class="text-center">Module Supplier</th>
                            <th scope="col" class="text-center">Module Setting Akses Pengguna</th>
                            <th scope="col" class="text-center">Module Barang Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataUser as $data)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->user_name }}</td>
                                <td>{{ $data->created_at->format('d-m-Y H:i:s') }}</td>
                                <td align="center">
                                    <input type="checkbox" class="permission-checkbox" data-user-id="{{ $data->id }}"
                                        data-permission="module_barang" {{ $data->can('module_barang') ? 'checked' : '' }}>
                                </td>
                                <td align="center">
                                    <input type="checkbox" class="permission-checkbox" data-user-id="{{ $data->id }}"
                                        data-permission="module_supplier"
                                        {{ $data->can('module_supplier') ? 'checked' : '' }}>
                                </td>
                                <td align="center">
                                    <input type="checkbox" class="permission-checkbox" data-user-id="{{ $data->id }}"
                                        data-permission="module_settinguserprivilage"
                                        {{ $data->can('module_settinguserprivilage') ? 'checked' : '' }}>
                                </td>
                                <td align="center">
                                    <input type="checkbox" class="permission-checkbox" data-user-id="{{ $data->id }}"
                                        data-permission="module_barangmasuk"
                                        {{ $data->can('module_barangmasuk') ? 'checked' : '' }}>
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
        $('#table-users').DataTable();
        $(document).ready(function() {
            $('.permission-checkbox').on('change', function() {
                var userId = $(this).data('user-id');
                var permission = $(this).data('permission');
                var isChecked = $(this).is(':checked');

                $.ajax({
                    url: '{{ route('users.updatepermission') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        permission: permission,
                        is_checked: isChecked
                    },
                    success: function(response) {
                        alert('Permission updated successfully!');
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating permission.');
                    }
                });
            });


        });
    </script>
@endpush
