@extends('layouts.app')

@push('title')
    Detail PO
@endpush

@section('content')
    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
        <div class="ms-auto">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Detail PO</h4>
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Informasi Header PO</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nomor Nota:</strong> {{ $hpo->hpo_nota }}</p>
                            <p><strong>Supplier:</strong> {{ $hpo->supplier->supplier_nama ?? '-' }}</p>
                            <p><strong>Detail Supplier:</strong> {{ $hpo->hpo_supplierdetail }}</p>
                            <p><strong>Sales:</strong> {{ $hpo->hpo_sales }}</p>
                            <p><strong>Nomor HP Sales:</strong> {{ $hpo->hpo_sales_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jatuh Tempo:</strong>
                                {{ \Carbon\Carbon::parse($hpo->hpo_jatuhtempo)->format('d-m-Y') }}</p>
                            <p><strong>Total Pembelian:</strong> Rp
                                {{ number_format($hpo->hpo_jumlahpembelian, 0, ',', '.') }}</p>
                            <p><strong>Total Dibayar:</strong> Rp {{ number_format($hpo->hpo_jumlahdibayar, 0, ',', '.') }}
                            </p>
                            <p><strong>Sisa Pembayaran:</strong> Rp
                                {{ number_format($hpo->hpo_jumlahbelumdibayar, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong>
                                @if ($hpo->isLunas == 1)
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs" id="poDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="barang-tab" data-bs-toggle="tab" data-bs-target="#barang"
                        type="button" role="tab" aria-controls="barang" aria-selected="true">
                        Detail Barang
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran"
                        type="button" role="tab" aria-controls="pembayaran" aria-selected="false">
                        Riwayat Pembayaran
                    </button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="poDetailTabsContent">
                <div class="tab-pane fade show active" id="barang" role="tabpanel" aria-labelledby="barang-tab">
                    <div class="table-responsive">
                        <table id="detailPoTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Jumlah Dikirim</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Status Penerimaan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
                    <div class="table-responsive">
                        @if ($hpo->isLunas == 0)
                            <div class="mb-3 text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPembayaran">
                                    Tambah Pembayaran
                                </button>
                            </div>
                        @endif
                        <table id="paymentHistoryTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pembayaran -->
    <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formPembayaran" action="{{ route('purchase-order.store.po-payment') }}" method="POST">
                @csrf
                <input type="hidden" name="po_id" value="{{ $hpo->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPembayaranLabel">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><b><i>Nb: Tanda <span class="text-danger">*)</span> Wajib diisi</i></b></p>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Pembayaran <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Pembayaran <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran <span
                                    class="text-danger">*</span></label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Giro">Giro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit-pembayaran">Simpan Pembayaran</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#detailPoTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchase-order.show', $hpo->id) }}",
                    data: function(d) {
                        d.type = 'details';
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'barang_id',
                        name: 'barang.barang_nama'
                    },
                    {
                        data: 'dpo_jumlahbarang',
                        render: data => data + ' pcs'
                    },
                    {
                        data: 'dpo_jumlahbarang_terima',
                        render: data => data + ' pcs'
                    },
                    {
                        data: 'dpo_harga',
                        name: 'dpo_harga'
                    },
                    {
                        data: 'dpo_totalharga',
                        name: 'dpo_totalharga'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ],
            });

            $('#paymentHistoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchase-order.show', $hpo->id) }}",
                    data: function(d) {
                        d.type = 'payments';
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'jumlah_bayar',
                        name: 'jumlah_bayar'
                    },
                    {
                        data: 'metode_pembayaran',
                        name: 'metode_pembayaran'
                    },
                    {
                        data: 'keterangan',
                        render: data => data || '-'
                    },
                ],
                order: [
                    [1, 'desc']
                ]
            });

            $('#submit-pembayaran').click(function() {
                Swal.fire({
                    title: "Konfirmasi Simpan",
                    text: "Apakah data yang anda masukkan sudah benar?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Simpan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formPembayaran').submit();
                    }
                });
            });
        });
    </script>
@endpush
