@extends('layouts.app')

@push('tittle')
    Penerimaan Barang
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Buat Penerimaan Barang</h5>
            <hr>

            <form action="{{ route('penerimaan_toko.store') }}" method="POST">
                @csrf

                {{-- Header Penerimaan --}}
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="po_id" class="form-label">No Penerimaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-receipt"></i></span>
                            <select name="no_penerimaan" id="no_penerimaan" class="select2" required
                                onchange="loadDetailPenerimaan()">
                                <option value="">Pilih Nomor Penerimaan</option>
                                @foreach ($penerimaan as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('no_penerimaan') == $p->id ? 'selected' : '' }}>
                                        {{ $p->barangkeluar_nota }} - {{ $p->penanggung_jawab }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penerima</label>
                        <input type="text" name="penerima" class="form-control" value="{{ old('penerima') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}">
                    </div>
                </div>

                {{-- Detail Barang --}}
                <h6>Detail Barang</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" id="barangTable">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Exp</th>
                                <th>Jumlah Sudah Terima</th>
                                <th>Jumlah Datang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (old('barang_id'))
                                @foreach (old('barang_id') as $i => $barang_id)
                                    <tr>
                                        <td>
                                            {{ old('barang_nama')[$i] ?? '-' }}
                                            <input type="hidden" name="barang_id[]" value="{{ $barang_id }}">
                                        </td>
                                        <td>
                                            {{ old('barang_nama')[$i] ?? '-' }}
                                            <input type="hidden" name="barang_nama[]"
                                                value="{{ old('barang_nama')[$i] ?? '' }}">
                                        </td>
                                        <td class="text-end">
                                            {{ old('qty')[$i] ?? 0 }}
                                            <input type="hidden" name="qty[]" value="{{ old('qty')[$i] ?? 0 }}">
                                        </td>
                                        <td class="text-end">
                                            {{ old('exp')[$i] ?? '' }}
                                            <input type="hidden" name="exp[]" value="{{ old('exp')[$i] ?? '' }}">
                                        </td>
                                        <td class="text-end">
                                            {{ old('jumlah_terima')[$i] ?? 0 }}
                                            <input type="hidden" name="jumlah_terima[]"
                                                value="{{ old('jumlah_terima')[$i] ?? 0 }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm jumlah-datang"
                                                name="jumlah_datang[]" value="{{ old('jumlah_datang')[$i] ?? 0 }}"
                                                min="0" style="width: 100px;">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger btn-hapus">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>


                <hr>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('penerimaan_toko.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function updateEvents() {
            document.querySelectorAll('.qty, .harga').forEach(input => {
                input.addEventListener('input', function() {
                    let row = this.closest('tr');
                    let qty = parseFloat(row.querySelector('.qty').value) || 0;
                    let harga = parseFloat(row.querySelector('.harga').value) || 0;
                    row.querySelector('.total').value = qty * harga;
                });
            });

            document.querySelectorAll('.removeRow').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });
        }


        function loadDetailPenerimaan() {
            const no_penerimaan = $('#no_penerimaan').val();

            if (!no_penerimaan) return;

            $.ajax({
                url: '{{ route('penerimaan_toko.getdetail') }}',
                method: 'GET',
                data: {
                    id: no_penerimaan
                },
                success: function(response) {
                    console.log('response:', response);

                    if (!response.success || !response.details || response.details.length === 0) {
                        $('#barangTable tbody').html(`
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data barang</td>
                            </tr>
                        `);
                        return;
                    }

                    let rows = '';

                    response.details.forEach((item, index) => {
                        const kode = item.barang?.barang_barcode || '-';
                        const nama = item.barang?.barang_nama || '-';
                        const qty = item.jumlah || 0;
                        const jumlahTerima = item.jumlah_terima || 0;
                        const exp = item.exp_date || '';
                        const jumlahDatang = qty - jumlahTerima;

                        rows += `
                            <tr data-index="${index}">
                                <td>
                                    ${kode}
                                    <input type="hidden" name="barang_id[]" value="${item.barang?.id || ''}">
                                    <input type="hidden" name="dbarang_keluarid[]" value="${item.id || ''}">
                                </td>
                                <td>
                                    ${nama}
                                    <input type="hidden" name="barang_nama[]" value="${nama}">
                                </td>
                                <td class="text-end">
                                    ${qty}
                                    <input type="hidden" name="qty[]" value="${qty}">
                                </td>
                                <td class="text-end">
                                    ${exp}
                                    <input type="hidden" name="exp[]" value="${exp}">
                                </td>
                                <td class="text-end">
                                    ${jumlahTerima}
                                    <input type="hidden" name="jumlah_terima[]" value="${jumlahTerima}">
                                </td>
                                <td>
                                    <input type="number" 
                                        class="form-control form-control-sm jumlah-datang" 
                                        value="${jumlahDatang}" 
                                        min="0"
                                        style="width: 100px;" 
                                        name="jumlah_datang[]">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger btn-hapus">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    $('#barangTable tbody').html(rows);

                    // Event hapus baris
                    $('#barangTable').on('click', '.btn-hapus', function() {
                        $(this).closest('tr').remove();
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
