<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Master Truck </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Truck </b>Master</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">
          Masuk untuk memulai sesi Anda
        </p>



        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="input-group mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-12">
              <button type="submit" class="btn-sm btn-primary btn-block"> Login </button>
            </div>

<!--                 <div class="col-8">
                  <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                </div> -->
                
                <!-- /.col -->
              </div>

              <div class="row">

                <div class="col-8">
                  <a href="{{ route('password.request') }}" >
                   <!--  I forgot my password -->
                    Lupa Password
                  </a>
                </div>
                <div class="col-8">
                  <a href="{{url('/daftar')}}">
                    Buat Akun Baru
                  </a>
                </div>

              </div>

            </form> 



          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.login-box -->

      <!-- jQuery -->
      <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
      <!-- Bootstrap 4 -->
      <script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- AdminLTE App -->
      <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
    </body>
    </html>
