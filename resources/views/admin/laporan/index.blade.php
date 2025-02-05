@extends('admin.template')

@section('title', 'Data Laporan')

@section('page-scripts')
@include('admin.laporan.partials.scripts')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Data Laporan</h4>
                </div>
                <div class="card-body">
                    @include('admin.laporan.partials.table')
                </div>
            </div>
        </div>
    </div>
</div>


@endsection