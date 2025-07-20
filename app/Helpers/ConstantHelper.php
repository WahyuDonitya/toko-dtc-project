<?php

namespace App\Helpers;

class ConstantHelper
{
    // status lunas
    const IS_LUNAS_BELUM = 0;
    const IS_LUNAS_SUDAH = 1;

    // status penerimaan PO
    const STATUS_PENERIMAAN_BELUMDITERIMA = 0;
    const STATUS_PENERIMAAN_DITERIMASEBAGIAN = 1;
    const STATUS_PENERIMAAN_SUDAHTUNTAS = 2;

    // status detail PO
    const STATUS_DETAIL_PO_BELUM_DITERIMA = 0;
    const STATUS_DETAIL_PO_BELUM_TUNTAS = 1;
    const STATUS_DETAIL_PO_SUDAH_TUNTAS = 2;

    // status detail barang
    const STATUS_DETAIL_BARANG_ADA = 0;
    const STATUS_DETAIL_BARANG_HABIS = 1;
    const STATUS_DETAIL_BARANG_EXP = 2;
}
