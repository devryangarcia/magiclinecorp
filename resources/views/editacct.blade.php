@extends('dash-layout')
@section('title')
  Update User Info
@endsection
@section('page-active')
  Update User Info
@endsection
@section('links')
    
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
@endsection
@section('main-content')
<div class="container">
  <div class="card">
      <div class="card-body register-card-body">
        <h3 class="login-box-msg">Update User Information</h3>
  
        <form action="{{route('storeuserupdate')}}" method="post">
          
          @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-check"></i> {{ Session::get('success') }}
            </div>
          @endif
          @if(Session::get('fail'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-ban"></i>  {{ Session::get('fail') }}
            </div>
          @endif
          <?php
            $id = session()->get('LoggedUser');
              
            $usersInfo = DB::select('select * from users where id = ?',[$id]);
            foreach($usersInfo as $userinfo){
                $fname = $userinfo->fname;
                $lname = $userinfo->lname;
                $username = $userinfo->username;
                $email = $userinfo->email;
                $company = $userinfo->company;
                $role = $userinfo->role;
                $status = $userinfo->status;
                $useravatar = $userinfo->avatar;

            }
            $comps = DB::select('select company from partners');
              $lists = DB::select('select * from access_lists where user_id=?',[$id]);
              foreach ($lists as $list) {
              $list->accesslists;
            }
            $avatars = DB::select('select * from avatars');
          ?>
          @csrf
          <div><label for="">Avatar</label></div>
          <div class="input-group mb-3">
            @foreach ($avatars as $avatar)
              <div class="form-check">
                @if ($avatar->avatar==$useravatar)
                <img src="{{asset('avatars/'.$avatar->avatar)}}" alt="{{$avatar->avatar}}" style="height: 60px; width: 60px;">
                <input type="radio" class="form-check-input" name="avatar" id="avatar" checked value="{{$avatar->avatar}}">
                @else
                <img src="{{asset('avatars/'.$avatar->avatar)}}" alt="{{$avatar->avatar}}" style="height: 60px; width: 60px;">
                <input type="radio" class="form-check-input" name="avatar" id="avatar" value="{{$avatar->avatar}}"> 
                @endif
              </div>
            @endforeach
          </div>
          <div><label for="">First Name:</label></div>
          <div class="input-group mb-3">
              <input type="hidden" class="form-control" name="id" value="<?php echo $id ?>">
              <input type="hidden" class="form-control" name="oldusername" value="<?php echo $username ?>">
              <input type="text" class="form-control" name="fname" placeholder="First name" value="<?php echo $fname ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
          </div>
          <div>
              <span class="text-danger">@error('fname'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Last Name:</label></div>
          <div class="input-group mb-3">
              <input type="text" class="form-control" name="lname" placeholder="Last name" value="<?php echo $lname ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
          </div>
          <div>
              <span class="text-danger">@error('lname'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Username:</label></div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('username'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Email</label></div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('email'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Password:</label></div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" onkeyup="removeSpaces()" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-eye mr-2" id="togglePassword"></i><span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('password'){{ $message }}@enderror</span>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.form-box -->
    </div>
    <!-- /.card -->
</div>
@endsection
@section('scripts')

<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function () {
      $('.select2').select2()
    });
</script>
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
<script>
  function removeSpaces() {
    var passwordField = document.getElementById("password");
    var password = passwordField.value;
    password = password.replace(/\s/g, ''); // remove all spaces
    passwordField.value = password;
  }
  </script>
@endsection