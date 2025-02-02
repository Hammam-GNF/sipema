@extends('layouts.template')

@section('title', 'Data Pengaduan')

@section('page-scripts')
@include('pengaduan.partials.scripts')
@endsection

@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Pengaduan</h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-database-add"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    @include('pengaduan.partials.table')
                </div>
            </div>
        </div>
    </div>
</div>

@include('pengaduan.modals.create')
@include('pengaduan.modals.edit')
@endsection