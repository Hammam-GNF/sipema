@extends('admin.template')

@section('title', 'Data Tindak Lanjut')

@section('page-scripts')
@include('admin.pengaduan.tindakLanjut.partials.scripts')
@endsection

@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Tindak Lanjut</h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-database-add"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    @include('admin.pengaduan.tindakLanjut.partials.table')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection