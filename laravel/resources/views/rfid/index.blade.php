
@section('heading', 'RFID')

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
            <h3 class="card-title"> RFID </h3>      
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Aksi</th>
                  <th>Nama Perusahaan</th>
                  <th>RFID</th>
                </tr>
              </thead>
              <tbody>
                <!-- Variabel php untuk nomor-->    
                <?php
                $nomer = 1;
                ?>
                <!-- ambil data di database-->
                @foreach($trucks as $truck)
                <tr>
                  <th>{{$nomer++}}</th>
                  <td>
                    <a href="{{url('rfid')}}/{{$truck->id}}/{{('detail')}}" class="btn btn-info btn-sm">
                      <i class="fa fa-folder-o"></i>
                      Detail
                    </a>
                    <a href="{{url('rfid')}}/{{$truck->id}}/{{('edit')}}" class="btn btn-warning text-white btn-sm">
                      <i class="fa fa-edit"></i>
                      Edit
                    </a>
                  </td>
                  <td>{{$truck->owner_name}}</td>
                  <td>{{$truck->id_rfid}}</td>

                </tr>
                @endforeach 
              </tbody>
            </table>
            <a href="{{url('rfid')}}/{{('add')}}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i>
                Tambah Data
              </a>
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
