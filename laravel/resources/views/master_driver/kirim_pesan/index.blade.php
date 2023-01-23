<head>
  <title> Jadwal Ujian - Master Truck </title>
  <link rel="shortcut icon" href="{{asset('cetak/logo_tpks.png')}}">
</head>

@extends('layouts.app')

@section('content')


<br>
<!-- Main content -->
<section class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-12">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"> <b>Kirim Jadwal Ujian untuk {{$driver->name}}</b> </h3>
					</div>
					<form action="{{url('kirim_pesan')}}/pesan" method="POST" enctype="multipart/form-data" >
						{{csrf_field()}}
						<div class="card-body">
							<div class="form-group row">
								<label class="col-sm-2"> Pesan </label>
								<div class="col-sm-10">
									<input name="pesan" class="form-control" id="pesan" aria-describedby="emailHelp"
									@foreach($ujian as $ka)
									value="{{$ka->pesan}}"
									@endforeach
									>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2"> Pada Tanggal : </label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="tanggal"  name="tanggal">
								</div>
							</div>
						</div>

						<input type="hidden" name="noWa" value="{{$driver->hp1}}">

						<div class="card-footer">
							<button type="submit" name="submit" class="btn btn-primary btn-sm"> Send </button>
							<a href="{{url('master_driver')}}" class="btn btn-default btn-sm float-right">Kembali</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"> <b>Sosialisasi Materi Ujian untuk {{$driver->name}}</b> </h3>
					</div>
					<form action="{{url('kirim_pesan')}}/file" method="POST" enctype="multipart/form-data" >
						{{csrf_field()}}

						<input type="hidden" name="noWa" value="{{$driver->hp1}}">

						<div class="card-footer">
							<button type="submit" name="submit" class="btn btn-primary btn-sm" align="center"> Kirim Dokumen ke WhatsApp </button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</section>





@endsection