@section('heading', 'Tambah Driver')

@extends('layouts.app')

@section('content')



{{-- menampilkan error validasi --}}
@if (count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif


<br>
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-white">
					<div class="card-header">
						<h3 class="card-title"> <b>Tambah Data Driver</b>  </h3>
					</div>
					<!-- form start -->
					<form action="{{url('driver')}}/{{$company->id}}/{{('adddriver')}}" method="POST" enctype="multipart/form-data" >
						{{csrf_field()}}

						<div class="card-body">

				            <!-- site_id 
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Site id </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="site_id" type="text" class="form-control" name="site_id" value="INTPKS" placeholder="boleh kosong" autocomplete="off">
				              </div>
				            </div>-->

				            <!-- name -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Nama </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('name')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- nik -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> NIK </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="nik" type="number" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{old('nik')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('nik')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- birthday -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Tanggal Lahir </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{old('birthday')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('birthday')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- gender -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Jenis Kelamin </label>
				              </div>
				              <div class="col-md-9">
				                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}">
				                  <option disabled>-- Pilih --</option>
				                  <option> Laki-laki </option>
				                  <option> Perempuan </option>
				                </select>
				                @error('gender')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- addr -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Alamat </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="addr" type="text" class="form-control @error('addr') is-invalid @enderror" name="addr" value="{{old('addr')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus >
				                @error('addr')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- (null) phone hidden 
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Phone </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="phone" type="hidden" class="form-control" name="phone" value="{{old('phone')}}" placeholder="boleh kosong">
				              </div>
				            </div>-->

				            <!-- (null) fax hidden
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Fax </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="fax" type="hidden" class="form-control" name="fax" value="{{old('fax')}}" placeholder="boleh kosong" autocomplete="off">
				              </div>
				            </div> -->

				            <!-- (null) mobile hidden 
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Mobile </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="mobile" type="hidden" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="boleh kosong" autocomplete="off">
				              </div>
				            </div>-->

				            <!-- hp1 -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> HP (WA) (+62) </label>
				              </div>
				              <div class="col-md-9">
				                <input name="hp1" id="hp1" type="text" class="form-control @error('hp1') is-invalid @enderror" data-inputmask="'mask': ['+9999999999999']" data-mask value="{{ old('hp1') }}" required autocomplete="off" autofocus>
				                @error('hp1')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				                <span class="text-success"> Aktif What'Apps </span> |
				                <span class="text-success"> +6289xxxxxxxxx</span>
				              </div>
				            </div>

				            <!-- (null) hp2 hidden 
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> HP 2 </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="hp2" type="hidden" class="form-control" name="hp2" value="{{old('hp2')}}" placeholder="boleh kosong" autocomplete="off">
				              </div>
				            </div>-->

				            <!-- (null) id_license hidden
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Id License </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="id_license" type="hidden" class="form-control" name="id_license" value="{{old('id_license')}}" placeholder="boleh kosong" autocomplete="off">
				              </div>
				            </div> -->

				            <!-- drive_license -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Nomor SIM </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="drive_license" type="text" class="form-control @error('drive_license') is-invalid @enderror" name="drive_license" value="{{old('drive_license')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('drive_license')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- valid_date = tanggal berlaku = tgl pembuatan SIM  -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Tanggal berlaku SIM </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="valid_date" type="date" class="form-control @error('valid_date') is-invalid @enderror" name="valid_date" value="{{old('valid_date')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('valid_date')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				              </div>
				            </div>

				            <!-- (null) display_cust hidden 
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Display Cust </label>
				              </div>
				              <div class="col-md-9">
				                <select type="hidden" id="display_cust" class="form-control" name="display_cust" value="{{ old('display_cust') }}">
				                  <option disabled>-- Select Y / N --</option>
				                  <option selected> Y </option>
				                  <option> N </option>
				                </select>
				              </div>
				            </div>-->

				            <!-- (null) done hidden
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Done </label>
				              </div>
				              <div class="col-md-9">
				                <select type="hidden" id="done" class="form-control" name="done" value="{{ old('done') }}">
				                  <option disabled>-- Select Y / N --</option>
				                  <option> Y </option>
				                  <option selected> N </option>
				                </select>
				              </div>
				            </div>-->

				            <!-- done_date = tanggal selesai -->
				            <!-- <div class="form-group row">
				              <div class="col-md-3">
				                <label> Tanggal selesai SIM </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="done_date" type="date" class="form-control" name="done_date" value="{{old('done_date')}}" placeholder="wajib di isi ..." autocomplete="off" required>
				              </div>
				            </div> -->

				            <!-- ins_date = tanggal masuk hidden (hari ini) -->
				            <!-- <div class="form-group row">
				              <div class="col-md-3">
				                <label> Ins Date </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="ins_date" type="hidden" class="form-control" name="ins_date" value="<?php echo date("d/m/Y"); ?>">
				              </div>
				            </div> -->

				            <!-- remaks -->
				            <!-- <div class="form-group row">
				              <div class="col-md-3">
				                <label> Keterangan </label>
				              </div>
				              <div class="col-md-9">
				                <textarea class="form-control" id="remaks" rows="3"></textarea>
				              </div>
				            </div> -->

				            <!-- id_rfid -->
				            <!--     
				              <div class="form-group row">
				                <div class="col-md-3">
				                  <label> RFID </label>
				                </div>
				                <div class="col-md-9">
				                  <input  id="id_rfid" type="text" class="form-control" name="id_rfid" value="{{old('id_rfid')}}" placeholder="boleh kosong">
				                </div>
				              </div>
				            -->

				            <!-- statement_form -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Surat pengantar dari perusahaan trucking (jpg,pdf) </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="statement_form" type="file" class="form-control @error('statement_form') is-invalid @enderror" name="statement_form" value="{{old('statement_form')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('statement_form')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				                <span class="text-danger">ukuran maksimal 4 mb</span>
				              </div>
				            </div>

				            <!-- file_sim -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Upload SIM (jpg,pdf) </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="file_sim" type="file" class="form-control @error('file_sim') is-invalid @enderror" name="file_sim" value="{{old('file_sim')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('file_sim')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				                <span class="text-danger">ukuran maksimal 4 mb</span>
				              </div>
				            </div>

				            <!-- file_ktp -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Upload KTP (jpg,pdf) </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="file_ktp" type="file" class="form-control @error('file_ktp') is-invalid @enderror" name="file_ktp" value="{{old('file_ktp')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('file_ktp')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				                <span class="text-danger">ukuran maksimal 4 mb</span>
				              </div>
				            </div>

				            <!-- file_foto -->
				            <div class="form-group row">
				              <div class="col-md-3">
				                <label> Upload Foto (jpg,png) </label>
				              </div>
				              <div class="col-md-9">
				                <input  id="file_foto" type="file" class="form-control @error('file_foto') is-invalid @enderror" name="file_foto" value="{{old('file_foto')}}" placeholder="wajib di isi ..." required autocomplete="off" autofocus>
				                @error('file_foto')
				                <span class="invalid-feedback" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				                @enderror
				                <span class="text-danger">Pas foto terbaru dengan latar belakang warna merah</span> |
				                <span class="text-danger">ukuran maksimal 4 mb</span>
				              </div>
				            </div>

							<!-- Tombol --> 
							<div class="form-group row">
								<div class="col-md-12">
									<br>
									<button type="submit" class="btn btn-primary btn-sm">
										Simpan
									</button>
									<a href="{{url('driver')}}/{{$company->id}}/{{('index')}}" class="btn btn-default btn-sm float-sm-right">
										Kembali
									</a>
								</div>
							</div>

						</div>
					</form> 
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->




@stop