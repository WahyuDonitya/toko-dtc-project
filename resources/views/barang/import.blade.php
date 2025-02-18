@extends('layouts.app')

@push('tittle')
    Import Barang
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Import Excel Barang</h5>
            <hr>
            <form action="{{ route('barang.import') }}" method="post" enctype="multipart/form-data" class="form-data">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">File Excel</label>
                    <input class="form-control" type="file" id="formFile" name="file">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mb-3"><i class="bx bx-import"></i>Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
