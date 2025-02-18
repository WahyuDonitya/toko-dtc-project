@extends('layouts.app')

@push('tittle')
    User Create
@endpush

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Form User Registration</h5>
            <hr>
            <form class="row g-3" method="POST" action="{{ route('users.store') }}" id="usersForm">
                @csrf
                <div class="col-md-12">
                    <label for="input25" class="form-label">Nama Panjang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" class="form-control" id="input25"
                            placeholder="Ex : Nancy Endah Mustika Diningsih" name="fullname" value="{{ old('fullname') }}">
                    </div>
                    @error('fullname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input27" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                        <input type="email" class="form-control" id="input27" placeholder="Ex : nancy@gmail.com"
                            name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input26" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" class="form-control" id="input26" placeholder="Ex : nancy" name="user_name"
                            value="{{ old('user_name') }}">
                    </div>
                    @error('user_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input28" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                        <input type="password" class="form-control" id="input28" placeholder="Password" name="password">
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input28" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                        <input type="password" class="form-control" id="input28" placeholder="Password Confirmation"
                            name="password_confirmation">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection


@push('js')
    <script>
        function handleClickSubmit() {
            Swal.fire({
                title: "Apakah data yang dimasukkan sudah benar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Simpan"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('usersForm').submit();
                }
            });
        }
    </script>
@endpush
