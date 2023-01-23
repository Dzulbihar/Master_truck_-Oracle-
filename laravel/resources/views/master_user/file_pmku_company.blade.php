@section('heading', 'Data User')

@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<!-- <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>PMKU Perusahaan {{$company->owner_name}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('master_user')}}/{{$user->id}}/{{('detail')}}"> View </a></li>
          <li class="breadcrumb-item active">Form</li>
        </ol>
      </div>
    </div>
  </div>
</section> -->

<br>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-white">
          <div class="card-header">
            <h3 class="card-title"> <b>PMKU Perusahaan {{$company->owner_name}}</b> </h3>
          </div>
          <div class="card-body">
            <strong><i class="fas fa-file-alt mr-1"></i> PMKU Perusahaan </strong>
            <p class="text-muted">
              <embed type="application/pdf" src="{{$company->getfile_pmku_company()}}" width="100%" height="500"></embed>
            </p>
          </div>
        </div>
      </div>
    </div>
      <a href="{{url('master_user')}}/{{$user->id}}/{{('detail')}}" class="btn btn-info btn-sm">Kembali</a>
      <br>
  </div>
</section>


@endsection

