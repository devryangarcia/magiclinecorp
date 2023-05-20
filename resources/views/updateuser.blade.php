@extends('admin-dash-layout')
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
        <p class="login-box-msg">Update User Information</p>
  
        <form action="{{route('userupdate')}}" method="post">
          @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-check"></i> {{ Session::get('success') }}<
            </div>
          @endif
          @if(Session::get('fail'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-ban"></i>  {{ Session::get('fail') }}
            </div>
          @endif
          <?php
          $isDisabled = 'disabled';
          $loggeduser_id = session()->get('LoggedUser');
          $loggedinfos = DB::select('select * from users where id = ?', [$loggeduser_id]);
            foreach($users as $user){
              $id = $user->id;
              $fname = $user->fname;
              $lname = $user->lname;
              $username = $user->username;
              $email = $user->email;
              $company = $user->company;
              $role = $user->role;
              $status = $user->status;
              $useravatar = $user->avatar;

            }
          foreach ($loggedinfos as $loggedinfo) {
            $loggedrole = $loggedinfo->role;
            $isDisabled = ($loggedrole==$role) ?'' : 'disabled' ;
          }
            $comps = DB::select('select company from partners');
            $lists = DB::select('select * from access_lists where user_id=?',[$id]);
            foreach ($lists as $list) {
              $list->accesslists;
            }
            $avatars = DB::select('select * from avatars');
          ?>
          @csrf
          <div><label for="">Avatar:</label></div>
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
              <input type="hidden" class="form-control" name="oldusername" value="<?php echo $username ?>" >
              <input type="text" class="form-control" name="fname" placeholder="First name" value="<?php echo $fname ?>" <?php if($role=='owner'){ echo $isDisabled;} ?> >
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
              <input type="text" class="form-control" name="lname" placeholder="Last name" value="<?php echo $lname ?>" <?php if($role=='owner'){ echo $isDisabled;} ?> >
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
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username ?>" <?php if($role=='owner'){ echo $isDisabled;} ?> >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('username'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Email:</label></div>
          <div class="input-group mb-3" >
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>" <?php if($role=='owner'){ echo $isDisabled;} ?> >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('email'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Company:</label></div>
          <div class="input-group mb-3">
            @php
            $comps = DB::select('select company from partners');
            @endphp
            <select class="form-control" name="company" <?php if($role=='owner'){ echo $isDisabled;} ?> >
              @if ($company=='MAGIC LINE')
              <option value="MAGIC LINE" selected class="bg-primary text-white">MAGIC LINE</option>
              @else
              <option value="MAGIC LINE">MAGIC LINE</option>
              @endif
              
              @foreach ($comps as $comp)
              @if ($comp->company==$company)
              <option value="{{$comp->company}}" selected class="bg-primary text-white">{{$comp->company}}</option>
              @else
              <option value="{{$comp->company}}">{{$comp->company}}</option>
              @endif
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
          <div><label for="">Password:</label></div>
          <div class="input-group mb-3" >
            <input type="password" name="password" id="password" onkeyup="removeSpaces()" class="form-control" placeholder="Password" <?php if($role=='owner'){ echo $isDisabled;} ?> >
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-eye mr-2" id="togglePassword"></i><span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div>
              <span class="text-danger">@error('password'){{ $message }}@enderror</span>
          </div>
          <div><label for="">Role:</label></div>
          <div class="input-group mb-3">
            
              <select class="form-control" id="role" name="role" <?php if($role=='owner'){ echo $isDisabled;} ?> onchange="checkrole()">
                @if ($role=='owner'){
                  <option value="owner" selected>Owner</option>
                }

                  @elseif ($role=='admin1'){
                    <option value="user">User</option>
                    <option value="admin1" selected>Admin 1</option>
                    <option value="admin2">Admin 2</option>
                  }
                  @elseif ($role=='admin2'){
                    <option value="user">User</option>
                    <option value="admin1">Admin 1</option>
                    <option value="admin2" selected>Admin 2</option>
                  }
                  @else
                    <option value="user" selected>User</option>
                    <option value="admin1">Admin 1</option>
                    <option value="admin2">Admin 2</option>
                  @endif
                  
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
          <div><label for="">Status:</label></div>
          <div class="input-group mb-3">
              <select class="form-control" id="status" name="status" <?php if($role=='owner'){ echo $isDisabled;} ?> >
                @if ($role=='owner')
                <option value="activated" selected>Activated</option>
                @else
                @if ($status=='activated'){
                    <option value="activated" selected>Activated</option>
                    <option value="deactivated">Deactivated</option>
                }
                @else
                  <option value="activated">Activated</option>
                  <option value="deactivated" selected>Deactivated</option>
                @endif
                @endif
                  
              </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-check"></span>
              </div>
            </div>
          </div>
          <div>
            <span class="text-danger">@error('status'){{ $message }}@enderror</span>
          </div>
          @if (old('role') != 'admin1')
          <div class="form-group" id="access" style="<?php if($role=='admin1' || $role=='owner'){ echo 'display: none;';} ?>">
            <div><label for="">Acces Lists:</label></div>
            <select class="select2" name="accesslists[]" multiple="multiple" data-placeholder="Access Lists" style="width: 100%;">
              @php
                if(count($lists)){
                  foreach ($comps as $item1) {
                    $matched = false;
                    foreach (explode(',',$list->accesslists) as $item2) {
                      if ($item1->company === $item2) {
                        echo '<option value="'.$item1->company.'" selected>'.$item1->company. '</option>';
                        $matched = true;
                        break;
                      }
                    }
                    if (!$matched) {
                      echo '<option value="'.$item1->company.'">'.$item1->company. '</option>';
                    }
                  }
                }
              @endphp
            </select>
          </div>
          <div>
            <span class="text-danger">@error('accesslists'){{ $message }}@enderror</span>
          </div>
          @endif
          <div class="row">
            <!-- /.col -->
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block" <?php if($role=='owner'){ echo $isDisabled;} ?> >Update</button>
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