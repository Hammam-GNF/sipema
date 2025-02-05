@extends('admin.template')

@section('title', 'Data Petugas')

@section('page-scripts')
@include('admin.petugas.partials.scripts')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Petugas</h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-database-add"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    @include('admin.petugas.partials.table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.petugas.modals.create')
@include('admin.petugas.modals.edit')
@endsection