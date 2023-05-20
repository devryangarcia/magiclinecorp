@extends('admin-dash-layout')
@section('title')
  Add New User
@endsection
@section('page-active')
  Add New User
@endsection
@section('links')
    
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
@endsection
@section('main-content')
<div class="container">
  <div class="card">
      <div class="card-body register-card-body">
        <h4 class="login-box-msg">Add User Information</h4>
        <?php
              $comps = DB::select('select company from partners where archived is null');
              sort($comps);
              $avatars = DB::select('select * from avatars');
        ?>
        <form action="{{route('saveuser')}}" method="post">
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
          @csrf
          <div><label for="avatar">Avatar</label></div>
          <div class="input-group mb-3">
            @foreach ($avatars as $avatar)
              <div class="form-check">
                <img src="{{asset('avatars/'.$avatar->avatar)}}" alt="{{$avatar->avatar}}" style="height: 60px; width: 60px;">
                <input type="radio" class="form-check-input" name="avatar" id="avatar" value="{{$avatar->avatar}}" {{ old('avatar') == $avatar->avatar ? 'checked' : '' }}>
              </div>
            @endforeach
          </div>
          <div>
              <span class="text-danger">@error('avatar'){{ $message }}@enderror</span>
          </div>
          <div><label for="fname">First Name</label></div>
          <div class="input-group mb-3">
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
          <div><label for="lname">Last Name</label></div>
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
          <div><label for="username">Username</label></div>
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
          <div><label for="email">Email</label></div>
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
          <div><label for="company">Company</label></div>
          <div class="input-group mb-3">
            <select class="form-control" name="company" >
              
              <option value="MAGIC LINE">MAGIC LINE</option>
              @foreach ($comps as $comp)
              <option value="{{$comp->company}}">{{$comp->company}}</option>
              @endforeach
              
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
          <div><label for="password">Password</label></div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-eye mr-2" id="togglePassword"></i><span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('password'){{ $message }}@enderror</span>
          </div>
          <div><label for="role">Role</label></div>
          <div class="input-group mb-3">
              <select class="form-control" name="role" id="role" onchange="checkrole()">
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                  <option value="admin1" {{ old('role') == 'admin1' ? 'selected' : '' }}>Admin 1</option>
                  <option value="admin2" {{ old('role') == 'admin2' ? 'selected' : '' }}>Admin 2</option>
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
          @if (old('role') != 'admin1')
          <div class="form-group" id="access">
            <div><label for="accesslists">Access Lists</label></div>
            <select class="select2" name="accesslists[]" multiple="multiple" data-placeholder="Access Lists" style="width: 100%;">
              @foreach ($comps as $comp)
                <option value="{{$comp->company}}">{{$comp->company}}</option>
              @endforeach
            </select>
          </div>
          @endif
          <div>
            <span class="text-danger">@error('accesslists'){{ $message }}@enderror</span>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block">Add</button>
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
var role = document.getElementById("role");
var access = document.getElementById("access");
function checkrole() {
  if(role.value=='admin1'){
    access.style.display = "none";
  } else{
    access.style.display = "block";
  }
  
}
</script>
@endsection