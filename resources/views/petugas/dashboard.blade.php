@extends('petugas.template')

@section('page-scripts')
@include('petugas.partials.scripts')
@endsection

@section('content')
<div class="content vh-100">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Selamat Datang, {{ $user->name }}! (Role: {{ $user->role }})</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="bi bi-bell text-success" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Pengaduan</p>
                                <p class="card-title" id="total-pengaduan">Loading...
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i>
                        Update now
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection