@extends('layouts.app')

@push('tittle')
    Barang Masuk
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ route('barang-masuk.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i>List Barang Masuk
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-0">Barang Masuk ke Gudang</h5>
            <hr>
            <p><b><i>Nb: Isi bagian tanggal expired dan jumlah datang saja</i></b></p>

            <form id="formBarangMasuk" method="POST" action="{{ route('barang-masuk.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="po_id" class="form-label">Nomor Purchase Order <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-receipt"></i></span>
                            <select name="po_id" id="po_id" class="select2" onchange="loadDetailPo()" required>
                                <option value="">Pilih Nomor PO</option>
                                @foreach ($purchaseOrders as $po)
                                    <option value="{{ $po->id }}">{{ $po->hpo_nota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mengetahui" class="form-label">Penanggung Jawab <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" name="mengetahui" id="mengetahui" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mt-3" id="tabelBarang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah Datang</th>
                                <th>Expired</th>
                                <th>Jumlah Pesanan</th>
                                <th>Jumlah Sudah datang</th>
                                <th>Harga / PCS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function loadDetailPo() {
            let poId = $('#po_id').val();
            if (!poId) return;

            $.ajax({
                url: '{{ route('barang-masuk.getdetailbarang') }}',
                type: 'GET',
                data: {
                    id: poId
                },
                success: function(response) {
                    if (response.success) {
                        let tbody = $('#tabelBarang tbody');
                        tbody.empty();

                        response.details.forEach(function(detail) {
                            let jumlahDatang = detail.jumlah - detail.jumlah_barangditerima;

                            if (jumlahDatang <= 0) {
                                return;
                            }

                            let row = `
                                <tr>
                                    <td>
                                        <input type="hidden" name="barang_ids[]" value="${detail.barang_id}">
                                        ${detail.nama_barang}
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_datang[]" value="${jumlahDatang}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="date" name="exps[]" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_pesanan[]" value="${detail.jumlah}" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_barangditerima[]" value="${detail.jumlah_barangditerima}" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="hargas[]" value="${detail.harga}" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <button type="button" onclick="hapusRow(this)" class="btn btn-danger btn-sm">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        alert('Gagal mengambil detail PO');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil detail PO');
                }
            });
        }



        function hapusRow(button) {
            let row = button.parentElement.parentElement;
            row.remove();
        }

        function resetForm() {
            $('#po_id').val('').trigger('change');
            $('#tabelBarang tbody').empty();
            $('#formBarangMasuk').trigger('reset');
        }

        $('.btn-secondary').click(function(e) {
            e.preventDefault();
            resetForm();
        });
    </script>
@endpush
