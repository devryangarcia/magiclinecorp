<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lockscreen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <img src="{{asset('images/MAGICLINE-2.png')}}" class="w-75" alt="Magic Line Logo">
      </div>
      @if(Session::get('fail'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i>  {{ Session::get('fail') }}
      </div>
      @endif
      <!-- User name -->
      <div class="lockscreen-name">{{$user->fname}} {{$user->lname}}</div>
    
      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="{{asset('avatars/'.$user->avatar)}}" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->
    
        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="post" action="{{route('unlock')}}">
          <div class="input-group">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" autofocus>
            
            <div class="input-group-append">
              
              <button type="button" class="btn">
                <i class="fas fa-eye" id="togglePassword"></i>
              </button>
              <button type="submit" class="btn">
                <i class="fas fa-arrow-right text-muted"></i>
              </button>
            </div>
          </div>
        </form>
        <!-- /.lockscreen credentials -->
    
      </div>
      <!-- /.lockscreen-item -->
      <div class="help-block text-center">
        <div>
            <span class="text-danger">@error('password'){{ $message }}@enderror</span>
        </div>
        Enter your password to retrieve your session
      </div>
      <div class="text-center">
        <a href="{{url('logout')}}">Or sign in as a different user</a>
      </div>
    </div>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
  });
</script>
</body>
</html>
