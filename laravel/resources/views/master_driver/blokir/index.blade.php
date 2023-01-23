<head>
  <title> Blokir - Master Truck </title>
  <link rel="shortcut icon" href="{{asset('cetak/logo_tpks.png')}}">
</head>

@extends('layouts.app')

@section('content')


<br>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> <b>Daftar Blokir Driver</b> </h3>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Sopir</th>
                  <th>Nomor Polisi Truk</th>
                  <th>Bentuk Pelanggaran</th>
                </tr>
              </thead>
              <tbody>
                <!-- Variabel php untuk nomor-->    
                <?php
                  $nomer = 1;
                ?>
                <!-- ambil data di database-->
                @foreach($violations as $violation)
                <tr>
                  <th>{{$nomer++}}</th>
                  <td>{{$violation->nama_driver}}</td>
                  <td>{{$violation->police_no}}</td>
                  <td>{{$violation->bentuk_pelanggaran}}</td>
                </tr>
                @endforeach  
              </tbody>
            </table>

            <!-- Button trigger modal -->
            <div>
              <a href="{{url('master_driver')}}" class="btn btn-info btn-sm">
                Kembali
              </a>
            </div>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->


</section>
<!-- /.content -->





@endsection

