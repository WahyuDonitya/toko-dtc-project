@extends('layouts.app')

@push('tittle')
    Barang Keluar
@endpush


@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ route('barang-keluar.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i>List Barang Keluar
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0">Barang Keluar dari Gudang</h5>
            <hr>
            <p><b><i>Nb: Tanda <span class="text-danger">*)</span> Wajib diisi</i></b></p>

            <form id="formBarangKeluar" method="POST" action="{{ route('barang-keluar.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="form-control"
                                value="{{ old('penanggung_jawab') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="catatan" class="form-label">Catatan </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-note"></i></span>
                            <input type="text" name="catatan" id="catatan" class="form-control"
                                value="{{ old('catatan') }}">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="barang" class="form-label">Barang <span class="text-danger">*</span></label>
                        <select name="barang" id="barang" class="form-control select2"
                            onchange="getDetailBarang(this.value)">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangList as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="jumlah" class="form-label">Jumlah Stok Barang</label>
                        <input type="number" min="1" class="form-control" id="jumlahBarang" name="jumlahBarang"
                            readonly>
                    </div>

                    <div class="col-md-3">
                        <label for="jumlah" class="form-label">Jumlah keluar<span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control" id="jumlah" name="jumlah">
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mt-3" id="btnTambahBarang">
                            <i class="bx bx-plus"></i> Tambah Barang
                        </button>
                    </div>
                </div>

                <hr>

                <h6>Daftar Barang Keluar</h6>
                <table class="table table-bordered" id="tableBarang">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Stok Barang</th>
                            <th>Jumlah Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session('barang'))
                            @foreach (session('barang')['barang_id'] as $index => $barangId)
                                <tr>
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <input type="hidden" name="barang_id[]" value="{{ $barangId }}">
                                        {{ $barang->firstWhere('id', $barangId)->barang_nama ?? '' }}
                                    </td>
                                    <td>
                                        <input type="number" name="stok_barang[]"
                                            value="{{ session('barang')['stok_barang'][$index] }}" class="form-control"
                                            required readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_barang[]"
                                            value="{{ session('barang')['jumlah_barang'][$index] }}" class="form-control"
                                            required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btnHapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <button type="button" class="btn btn-success" id="btnSave" onclick="handleClickSubmit()"><i
                        class="bx bx-save"></i>Simpan Barang
                    Keluar</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function getDetailBarang(id) {
            $.ajax({
                url: '{{ route('barang-masuk.gethargabarang') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(response) {
                    // console.log(response);
                    $('#jumlahBarang').val(response.stok);
                },
                error: function() {
                    alert('Gagal menampilkan jumlah stok, Error!');
                }
            })
        };

        function handleClickSubmit() {
            Swal.fire({
                title: "Konfirmasi Simpan",
                text: "Apakah anda yakin data yang dimasukkan benar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Simpan"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBarangKeluar').submit();
                }
            })
        }

        $(document).ready(function() {
            let rowCount = 0;

            $('#btnTambahBarang').on('click', function() {
                const barangId = $('#barang').val();
                const barangText = $('#barang option:selected').text();
                const jumlah = parseInt($('#jumlah').val());
                const jumlahBarang = parseInt($('#jumlahBarang').val());

                if (!barangId || !jumlah || jumlah <= 0) {
                    alert('Silakan pilih barang dan masukkan jumlah yang valid.');
                    return;
                }

                if (jumlah > jumlahBarang) {
                    alert('Barang keluar melebihi stok yang ada');
                    return;
                }

                // Cegah duplikat
                if ($(`#tableBarang input[name="barang_id[]"][value="${barangId}"]`).length) {
                    alert('Barang sudah ditambahkan.');
                    return;
                }

                rowCount++;

                const row = `
                    <tr>
                        <td>${rowCount}</td>
                        <td>
                            ${barangText}
                            <input type="hidden" name="barang_id[]" value="${barangId}">
                        </td>
                        <td>
                            <input type="number" name="stok_barang[]" class="form-control" value="${jumlahBarang}" min="1" readonly>
                        </td>
                        <td>
                            <input type="number" name="jumlah_barang[]" class="form-control" value="${jumlah}" min="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btnHapus">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#tableBarang tbody').append(row);

                $('#barang').val('').trigger('change');
                $('#jumlah').val('');
            });

            $('#tableBarang tbody').on('change', 'input[name="jumlah_barang[]"]', function() {
                const jumlahInput = $(this);
                const jumlah = parseInt(jumlahInput.val(), 10);
                const stok = parseInt(jumlahInput.closest('tr').find('input[name="stok_barang[]"]').val(),
                    10);

                if (jumlah > stok) {
                    alert('Barang keluar melebihi stok yang ada');
                    jumlahInput.val(stok);
                    return
                }

                if (jumlah <= 0) {
                    alert('Barang keluar harus lebih dari 0! hapus jika tidak perlu');
                    jumlahInput.val(stok);
                    return;
                }
            });

            $('#tableBarang').on('click', '.btnHapus', function() {
                $(this).closest('tr').remove();
                updateRowNumbers();
            });

            function updateRowNumbers() {
                rowCount = 0;
                $('#tableBarang tbody tr').each(function() {
                    rowCount++;
                    $(this).find('td:first').text(rowCount);
                });
            }
        });
    </script>
@endpush
