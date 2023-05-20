<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Magic Line</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{route('save')}}" method="post">
        @if(Session::get('success'))
             <div class="alert alert-success">
                {{ Session::get('success') }}
             </div>
        @endif

        @if(Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif
        @csrf
        <div class="input-group mb-3">
          <input type="hidden" class="form-control" name="avatar" placeholder="Avatar" value="avatar 1.png">
            <input type="text" class="form-control" name="fname" placeholder="First name" value="{{old('fname')}}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div>
            <span class="text-danger">@error('fname'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="lname" placeholder="Last name" value="{{old('lname')}}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div>
            <span class="text-danger">@error('lname'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" value="{{old('username')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('username'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('email'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" id="company" name="company">
              <option value="MAGIC LINE">MAGIC LINE</option><!--
              <option value="admin2">Admin 2</option>
              <option value="user">User</option>-->
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-building"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('company'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('password'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
            <select class="form-control" id="role" name="role">
                <option value="admin1">Admin 1</option><!--
                <option value="admin2">Admin 2</option>
                <option value="user">User</option>-->
            </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-tag"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('role'){{ $message }}@enderror</span>
        </div>
        <div class="input-group mb-3">
            <select class="form-control" id="accesslists" name="accesslists[]">
                <option value="ALL">ALL</option>
            </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-tag"></span>
            </div>
          </div>
        </div>
        <div>
            <span class="text-danger">@error('accesslists'){{ $message }}@enderror</span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
