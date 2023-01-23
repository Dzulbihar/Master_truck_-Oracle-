<head>
  <title> Dashboard - Master Truck </title>
  <link rel="shortcut icon" href="{{asset('cetak/logo_tpks.png')}}">
</head>

@extends('layouts.app')

@section('content')


@if(session('sukses'))
<div class="alert alert-success" role="alert">
  {{session('sukses')}}
</div>
@endif

<br>

<div class="main">
  <div class="main-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="p-3 mb-2 bg-white">
            <div class="metric">

              <div class="col-md-12">
                <span class="title"> 
                  <h2 align="center">
                    Dashboard
                  </h2>
                </span>
              </div>

              @if(auth()->user()->status == 'Tidak Aktif')
                <br><br><br>
                <h4 class="text-white  bg-danger" align="center">
                  <b>
                    Akun belum disetujui
                  </b>
                  <br>
                  @empty ($company->contact && $company->nib_company && $company->file_nib_company && $company->npwp_company && $company->file_npwp_company && $company->pmku_company && $company->file_pmku_company && $company->statement_form)
                    <br>
                    Silakan lengkapi data profil untuk meminta persetujuan Admin
                    <br>
                    <a href="
                    @if(auth()->user()->role == 'user')
                    {{url('profilperusahaan')}}
                    @else
                    {{url('profilsayaadmin')}}
                    @endif" class="nav-link">
                      <p class="badge badge-info text-white"> Lengkapi profil </p>  
                    </a>
                  @else
                    <br>
                    Data profil Anda sudah lengkap, silakan klik tombol ajukan persetujuan untuk mengaktifkan akun Anda
                    <br>
                    <a href="{{url('approver_admin')}}">
                      <p class="badge badge-info text-white"> Ajukan Persetujuan </p>  
                    </a>
                  @endempty

                </h4>
              @endif

              @if(auth()->user()->status == 'Blokir')
                <br><br><br>
                <h4 class="text-white  bg-danger" align="center">
                  <b>
                    Akun Anda diblokir
                  </b>
                  <br>
                  Silakan hubungi Admin untuk informasi lebih lanjut
                </h4>
                <h4 class="text-white  bg-danger" align="center">
                  <b>
                    Alasan Diblokir
                  </b>
                  <br>
                  {{ Auth::user()->alasan_blokir }} 
                </h4>
              @endif

              @if(auth()->user()->role == 'user' && auth()->user()->status == 'Aktif')
                <br><br><br>
                <h4 class="text-success  bg-white" align="center">
                  <b>
                    Akun sudah disetujui
                  </b>
                </h4>
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(auth()->user()->role == 'user' && auth()->user()->status == 'Aktif')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Total RFID Truck -->
      <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-info text-white elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <a href="{{url('truck')}}/{{$company->id}}/{{('index')}}" class="btn btn-sm btn-block btn-white btn-outline-info"  target="_blank">
              <b> Daftar RFID Truck </b> 
            </a>
          </div>
        </div>
      </div>
      <!-- Total Driver -->
      <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-warning elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <a href="{{url('driver')}}/{{$company->id}}/{{('index')}}" class="btn btn-sm btn-block btn-white btn-outline-warning"  target="_blank"> 
              <b> Daftar Driver </b> 
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endif

@if(auth()->user()->role == 'admin')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Total RFID Truck -->
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info text-white elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <a href="{{ url('master_truck')}}" class="btn btn-sm btn-block btn-white btn-outline-info"  target="_blank"> <b>Total</b> RFID Truck = {{totalTruck()}}
            </a>
            <span class="info-box-text"><b>Pengajuan</b> RFID Truck = {{pengajuanTruck()}}</span>
            <span class="info-box-text"><b>Sudah Disetujui</b> RFID Truck = {{disetujuiTruck()}}</span>
            <span class="info-box-text"><b>Diblokir</b> RFID Truck =  {{diblokirTruck()}}</span>
          </div>
        </div>
      </div>
      <!-- Total Driver -->
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-warning elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <a href="{{ url('master_driver')}}" class="btn btn-sm btn-block btn-white btn-outline-warning"  target="_blank"> <b>Total</b> Driver = {{totalDriver()}}
            </a>
            <span class="info-box-text"><b>Pengajuan</b> Driver = {{pengajuanDriver()}}</span>
            <span class="info-box-text"><b>Sudah Disetujui</b> Driver = {{disetujuiDriver()}}</span>
            <span class="info-box-text"><b>Diblokir</b> Driver =  {{diblokirDriver()}}</span>
          </div>
        </div>
      </div>
      <!-- Total RFID User -->
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="fa fa-user-circle"></i>
          </span>
          <div class="info-box-content">
            <a href="{{ url('master_user')}}" class="btn btn-sm btn-block btn-white btn-outline-success"  target="_blank"> <b>Total</b> User = {{totalUser()}}
            </a>
            <span class="info-box-text"><b>Akun Aktif</b> User = {{totalUserAKtif()}}</span>
            <span class="info-box-text"><b>Akun Belum Aktif</b> User = {{totalUserTidakAKtif()}}</span>
            <span class="info-box-text"><b>Akun Blokir</b> User =  {{totalUserBlokir()}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Truck -->
<!-- <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <h3 class="info-box-text" align="center"><b>Total</b> RFID Truck = {{totalTruck()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_truck')}}" class="btn btn-sm btn-block btn-white btn-outline-info" target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section> -->
<!-- <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Pengajuan</b> RFID Truck</span>
            <h3 class="info-box-number"> {{pengajuanTruck()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_truck')}}/{{ ('pengajuan_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-info"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Sudah Disetujui</b> RFID Truck</span>
            <h3 class="info-box-number"> {{disetujuiTruck()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_truck')}}/{{ ('sudah_disetujui_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-info"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-truck nav-icon"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Blokir</b> RFID Truck</span>
            <h3 class="info-box-number"> {{diblokirTruck()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_truck')}}/{{ ('sudah_disetujui_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-info"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section> -->

<!-- Driver -->
<!-- <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <h3 class="info-box-text" align="center"><b>Total</b> RFID Driver = {{totalDriver()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_driver')}}" class="btn btn-sm btn-block btn-white btn-outline-success"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Pengajuan</b> RFID Driver</span>
            <h3 class="info-box-number"> {{pengajuanDriver()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_driver')}}/{{ ('pengajuan_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-success"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Sudah Disetujui</b> RFID Driver</span>
            <h3 class="info-box-number"> {{disetujuiDriver()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_driver')}}/{{ ('sudah_disetujui_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-success"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="ion ion-person"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Diblokir</b> RFID Driver</span>
            <h3 class="info-box-number"> {{diblokirDriver()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_driver')}}/{{ ('sudah_disetujui_RFID')}}" class="btn btn-sm btn-block btn-white btn-outline-success"  target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section> -->

<!-- User -->
<!-- <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-user-circle"></i>
          </span>
          <div class="info-box-content">
            <h3 class="info-box-text" align="center"><b>Total</b> User = {{totalUser()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_user')}}" class="btn btn-sm btn-block btn-white btn-outline-info" target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-user-circle"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Akun Aktif</b> User</span>
            <h3 class="info-box-number"> {{totalUserAKtif()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_user')}}" class="btn btn-sm btn-block btn-white btn-outline-info" target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-user-circle"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Akun Belum Aktif</b> User</span>
            <h3 class="info-box-number"> {{totalUserTidakAKtif()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_user')}}" class="btn btn-sm btn-block btn-white btn-outline-info" target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
      <div class="col-12 col-sm-4 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fa fa-user-circle"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text"><b>Akun Belum Aktif</b> User</span>
            <h3 class="info-box-number"> {{totalUserBlokir()}}</h3>
          </div>
          <span>
            <a href="{{ url('master_user')}}" class="btn btn-sm btn-block btn-white btn-outline-info" target="_blank">
              <i class="fa fa-eye"></i> View
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</section> -->

@endif


@stop




