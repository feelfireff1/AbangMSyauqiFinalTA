@extends('layouts.master')

{{-- Link Link --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title')

        <title>Tambah Data | Presensi Teknik Elektro</title>

@endsection

@section('header-table')
    {{-- <button type="button" name="create_record" id="create_record" class="btn btn-primary float-end">Tambah Data</button> --}}
    <h6 class="m-0 font-weight-bold text-primary">Presensi Tabel</h6>
@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mata Kuliah</h1>
</div>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    @foreach ($jadwal as $data)
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{route('absen.index',$data->id)}}">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{$data->hari}}</div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{$data->jam_mulai ." sampai ".$data->jam_selesai}}</div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                           Semester {{$data->semester->name_semester}}</div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                           Kelas {{$data->kelas->name_kelas}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>
@endsection
