@extends('layouts.app')

@push('tittle')
    Barang Masuk
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Barang Masuk</h5>
            <hr>
            <p><b><i>Nb: Tanda <span class="text-danger">*)</span> Wajib diisi</i></b></p>
            <form action="{{ route('barang-masuk.store') }}" method="post" class="row g-3" id="barangMasuk">
                @csrf
                <div class="col-md-6">
                    <label for="input27" class="form-label">Supplier <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bxs-truck"></i></span>
                        <select name="supplier" id="supplier" class="select2">
                            <option value="">Pilih supplier</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}"
                                    {{ session('old_supplier') == $s->id ? 'selected' : '' }}>
                                    {{ $s->supplier_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('supplier')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input27" class="form-label">Detail Supplier</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-detail"></i></span>
                        <input type="text" class="form-control" id="detail_supplier"
                            placeholder="Ex : Pabrik, Rekanan, dll" name="detail_supplier"
                            value="{{ old('detail_supplier') }}">
                    </div>
                    @error('detail_supplier')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input25" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                        <select name="barang" id="barang" class="select2" onchange="getHarga()">
                            <option value="0">Pilih barang</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}" data-id="{{ $b->id }}">{{ $b->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="input27" class="form-label">Jumlah barang masuk (PCS) <span
                            class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-layer"></i></span>
                        <input type="number" class="form-control" id="jumlah_barang_masuk" placeholder="Ex : 20"
                            name="jumlah_barang_masuk" value="{{ old('jumlah_barang_masuk') }}">
                    </div>
                    @error('jumlah_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="input27" class="form-label">Harga Jual Saat ini</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                            value="{{ old('harga_jual') }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="input27" class="form-label">Harga barang masuk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-money"></i></span>
                        <input type="number" class="form-control" id="harga_barang" placeholder="Ex : 2000000"
                            name="harga_barang" value="{{ old('harga_barang') }}">
                    </div>
                    @error('harga_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-success px-4" onclick="tambahBarang()"><i class="bx bx-plus"></i>
                        Tambah</button>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered mt-3" id="tabelBarang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('barang_masuk'))
                                @foreach (session('barang_masuk')['barang_ids'] as $index => $barangId)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="barang_ids[]" value="{{ $barangId }}">
                                            {{ $barang->firstWhere('id', $barangId)->barang_nama ?? '' }}
                                        </td>
                                        <td>
                                            <input type="number" name="jumlahs[]"
                                                value="{{ session('barang_masuk')['jumlahs'][$index] }}"
                                                class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" name="hargas[]"
                                                value="{{ session('barang_masuk')['hargas'][$index] }}"
                                                class="form-control" required>
                                        </td>
                                        <td>
                                            <button type="button" onclick="hapusRow(this)"
                                                class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <button type="button" onclick="handleClickSubmit()" class="btn btn-primary px-4"><i
                            class="bx bx-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function getHarga() {
            var selectedOption = $('#barang option:selected');
            var barangId = selectedOption.data('id');

            if (barangId) {
                $.ajax({
                    url: '{{ route('barang-masuk.gethargabarang') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: barangId
                    },
                    success: function(response) {
                        if (response.success == true) {
                            $('#harga_jual').val(response.harga);
                        } else {
                            alert('Gagal menampilkan harga jual');
                        }
                    },
                    error: function() {
                        alert('Gagal menampilkan harga jual, Error!');
                    }
                });
            }
        }

        function tambahBarang() {
            let barang = document.getElementById('barang');
            let jumlah = document.getElementById('jumlah_barang_masuk').value;
            let harga = document.getElementById('harga_barang').value;
            let namaBarang = barang.options[barang.selectedIndex].text;
            let barangId = barang.value;

            if (!barangId || !jumlah || !harga) {
                alert('Mohon isi semua bidang!');
                return;
            }

            if (jumlah <= 0 || harga <= 0) {
                alert('Jumlah barang masuk atau Harga Barang Masuk harus Lebih dari 0');
                return;
            }

            let table = document.getElementById('tabelBarang').getElementsByTagName('tbody')[0];
            let row = table.insertRow();
            row.innerHTML = `
                <td>
                    <input type="hidden" name="barang_ids[]" value="${barangId}">
                    ${namaBarang}
                </td>
                <td>
                    <input type="number" name="jumlahs[]" value="${jumlah}" class="form-control" required>
                </td>
                <td>
                    <input type="number" name="hargas[]" value="${harga}" class="form-control" required>
                </td>
                <td>
                    <button type="button" onclick="hapusRow(this)" class="btn btn-danger btn-sm">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            `;

            $("#barang").select2("val", "0");
            $('#jumlah_barang_masuk').val("0");
            $('#harga_barang').val("0");
            $('#harga_jual').val("0");
        }

        function hapusRow(button) {
            let row = button.parentElement.parentElement;
            row.remove();
        }

        function handleClickSubmit() {
            if (window.confirm('Apakah data yang dimasukkan sudah benar?')) {
                document.getElementById('barangMasuk').submit();
            }
        }
    </script>
@endpush
