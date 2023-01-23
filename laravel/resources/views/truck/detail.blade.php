@section('heading', 'Detail Truck')


@extends('layouts.app')

@section('content')



<br>
<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <label>
          @if ($truck->status == 'Proses Pengajuan')
          <a class="badge badge-danger text-white">Proses Pengajuan</a>
          @elseif($truck->status == 'Sudah Disetujui')
          <a class="badge badge-success text-white">Sudah Disetujui</a>
          @else($truck->status == 'Diblokir')
          <a class="badge badge-danger text-white">Diblokir</a>
          @endif
        <label>
      </h3>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title"> 
        Truck dengan nomor polisi {{ $truck->police_no}}
      </h3>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1">
          <div class="row">
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td> Nama Perusahaan &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->owner_name}} &nbsp;</td>
              </tr>
              <tr>
                <td> Nama PIC &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->pic_nama}} &nbsp;</td>
              </tr>
              <tr>
                <td> Email &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->email}} &nbsp;</td>
              </tr>
              <tr>
                <td> Site Id &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->site_id}} &nbsp;</td>
              </tr>

              <tr>
                <td> Nomor Polisi &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->police_no}} &nbsp;</td>
              </tr>
              <tr>
                <td> Kode Truck &nbsp; </td>
                <td>  : </td>
                <td> 
                  <?php
                  $kalimat = "$truck->police_no";
                  $sub_kalimat = substr($kalimat,-5);
                  echo $sub_kalimat;
                  ?> 
                </td>
              </tr>
              <tr>
                <td> Nomor STNK &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->stnk_no}} &nbsp;</td>
              </tr>
              <tr>
                <td> Nomor Mesin &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->machine_no}} &nbsp;</td>
              </tr>
              <tr>
                <td> Nomor Rangka &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->design_no}} &nbsp;</td>
              </tr>
              <tr>
                <td> Tanggal berlaku STNK &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->get_expired_lisence()}} &nbsp;</td>
                <!-- <td> {{ date('d F Y', strtotime($truck->expired_lisence)) }} &nbsp;</td> -->
              </tr>

              <tr>
                <td> Merk &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->trade_mark}} &nbsp;</td>
              </tr>
              <tr>
                <td> Tahun Pembuatan &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->year_made}} &nbsp;</td>
              </tr>
              <tr>
                <td> Kota &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->state}} &nbsp;</td>
              </tr>

              <tr>
                <td> Berat Head Truck &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->truck_weight}} &nbsp;kg</td>
              </tr>
              <tr>
                <td> Kode Chasis Truck &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->chassis_code}} &nbsp;</td>
              </tr>
              <tr>
                <td> Jenis Chasis Truck &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->jenis_chassis}} &nbsp;</td>
              </tr>
              <tr>
                <td> Berat Chasis Truck &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->chassis_weight}} &nbsp;kg</td>
              </tr>
              <tr>
                <td> Total Berat Truck &nbsp; </td>
                <td>  : </td>
                <td>
                  <?php
                  $berat_truck = "$truck->truck_weight";
                  $kode_parameter_chasis = "$truck->chassis_weight";
                  $total_berat = $berat_truck+$kode_parameter_chasis;
                  echo $total_berat;
                  echo '  kg';
                  ?>
                </td>
              </tr>

              <!-- <tr>
                <td> Nomor Gerbang &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->gate_no}} &nbsp;</td>
              </tr> -->
              <tr>
                <td> Nomor Gerbang &nbsp; </td>
                <td>  : </td>
                @empty ($truck->gate_no)
                <td>  - </td>
                @else
                <td>  {{$truck->gate_no}} </td>
                @endempty
              </tr>
              <tr>
                <td> Bahan Bakar Gas ? &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->bbg_yn}} &nbsp;</td>
              </tr>
              <tr>
                <td> Truck Internal ? &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->otl_yn}} &nbsp;</td>
              </tr>
              <tr>
                <td> RFID &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->id_rfid}} &nbsp;</td>
              </tr>
              <tr>
                <td> Tanggal Pengajuan &nbsp; </td>
                <td>  : </td>
                <td> {{$truck->get_tanggal_pengajuan()}} &nbsp;</td>
              </tr>
              <tr>
                <td> Tanggal Disetujui &nbsp; </td>
                <td>  : </td>
                @empty ($truck->tanggal_setujui)
                <td>  Belum disetujui </td>
                @else
                <td>  {{$truck->get_tanggal_setujui()}} </td>
                @endempty
              </tr>
              <tr>
                <td> Disetujui Oleh &nbsp; </td>
                <td>  : </td>
                @empty ($truck->nama_setujui)
                <td>  Belum disetujui </td>
                @else
                <td>  {{$truck->nama_setujui}} </td>
                @endempty
              </tr>
            </table>
          </div>

          <div class="card card-white">
            <div class="card-header">
              <h4 class="card-title"> Foto Truk </h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <embed type="application/pdf" src="{{$truck->get_foto_truck()}}" width="100%"></embed>
                </div>
                <div class="col-sm-3">
                  <embed type="application/pdf" src="{{$truck->get_foto_kir_truck()}}" width="100%"></embed>
                </div>
                <div class="col-sm-3">
                  <embed type="application/pdf" src="{{$truck->get_foto_chassis()}}" width="100%"></embed>
                </div>
                <div class="col-sm-3">
                  <embed type="application/pdf" src="{{$truck->get_foto_kir_chassis()}}" width="100%"></embed>
                </div>
              </div>
            </div>
          </div>

          
          @if ($truck->status == 'Proses Pengajuan')
          <div class="text-center mt-5 mb-3">
            <a href="{{url('truck')}}/{{$company->id}}/{{$truck->id}}/{{('edit_data')}}" class="btn btn-warning text-white btn-sm">
              <i class="fas fa-pencil-alt"></i>
              Edit Data
            </a>
            <a href="{{url('truck')}}/{{$company->id}}/{{$truck->id}}/{{('edit_file')}}" class="btn btn-warning text-white btn-sm">
              <i class="fas fa-pencil-alt"></i>
              Edit File
            </a>
            <a href="#" class="btn btn-danger text-white btn-sm delete_truck_user" data-id-company="{{ $company->id}}" data-id-truck="{{ $truck->id}}" data-truck="{{ $truck->police_no}}">
              <i class="fas fa-trash"></i>
              Delete 
            </a>
          </div>
          @endif

          @if ($truck->status == 'Sudah Disetujui')
          <div class="text-center mt-5 mb-3">
            <a href="{{url('truck')}}/{{ $truck->id }}/{{('cetak_rfid')}}" class="btn btn-default btn-sm" target="_blank">
              <i class="fas fa-print"></i>
              Cetak ID Card Truk
            </a>
            <a href="{{url('truck')}}/{{ $truck->id }}/{{('cetak_data_truck')}}" class="btn btn-primary btn-sm" target="_blank">
              <i class="fas fa-download"></i>
              Cetak Data Truk 
            </a>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#rfid_rusak">
                <i class='far fa-clock'></i>
                Pengajuan Pergantian RFID rusak
              </button>
            <a href="{{url('truck')}}/{{$company->id}}/{{$truck->id}}/{{('edit_data')}}" class="btn btn-warning text-white btn-sm">
              <i class="fas fa-pencil-alt"></i>
              Edit Data
            </a>
            <a href="{{url('truck')}}/{{$company->id}}/{{$truck->id}}/{{('edit_file')}}" class="btn btn-warning text-white btn-sm">
              <i class="fas fa-pencil-alt"></i>
              Edit File
            </a>
            <a href="#" class="btn btn-danger text-white btn-sm delete_truck_user" data-id-company="{{ $company->id}}" data-id-truck="{{ $truck->id}}" data-truck="{{ $truck->police_no}}">
              <i class="fas fa-trash"></i>
              Delete 
            </a>
            <!-- <a href="{{ url('truck') }}/{{$company->id}}/{{('index')}}" class="btn btn-info btn-sm">
              <i class="fa fa-undo"></i>
              Kembali
            </a> -->
          </div>
          @endif

          @if ($truck->status == 'Diblokir')
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="bg-danger"> DATA INI DIBLOKIR </h1>
                  <br>
                  <p class="bg-danger">Tanggal Diblokir = {{ $truck->get_tanggal_blokir()}}
                  <br>
                  Alasan Diblokir = {{ $truck->alasan_blokir}}
                  <br>
                  Diblokir Oleh= {{ $truck->nama_blokir}}</p>
                  <br>
                </div>
              </div>
            </div>
          </section>
          @endif

        </div>

        <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"> File STNK </h3>
            </div>
            <div class="card-body">
              <p class="text-muted">
                <embed type="application/pdf" src="{{$truck->get_foto_stnk()}}" width="100%" height="500"></embed>
              </p>              
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>

</section>
<!-- /.content -->

<!-- Pengajuan Pergantian RFID rusak -->
<div class="modal fade" id="rfid_rusak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Pengajuan Pergantian RFID Rusak </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <form action="{{url('truck')}}/{{$company->id}}/{{('pergantian_rfid')}}" method="post" role="form" class="form">
          @csrf
            <div class="form-group mt-3">
              <input hidden type="text" name="name" class="form-control" value="{{ $company->owner_name}}" required>
            </div>
            <div class="form-group mt-3">
              <input hidden type="email" class="form-control" name="email" value="{{ $company->email}}" required>
            </div>
            <div class="form-group mt-3">
              <input hidden type="text" class="form-control" name="subject" value="Pergantian RFID Rusak" required>
            </div>
            <div class="form-group mt-3">
              <textarea type="text" class="form-control" name="isi" placeholder="Penyebab Kerusakan" required></textarea>
            </div>
            <div class="form-group mt-3">
              <input type="file" class="form-control" name="file" >
            </div>
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-success btn-sm">
                Kirim Email 
              </button>
            </div>
          </form>

      </div>
    </div>
  </div>
</div>


@endsection

