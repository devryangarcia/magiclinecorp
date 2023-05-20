@extends('admin-dash-layout')
@section('title')
    Update Company
@endsection
@section('main-content')
<div class="container">
    <div class="card">
        <div class="card-body register-card-body">
          <p class="login-box-msg">Update Company</p>
        <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            $compdata = DB::select('select * from partners where id = ?',[$id]);
            foreach($compdata as $data){
                $id = $data->id;
                $company = $data->company;
                $logo = $data->logo;

            }
        ?>
          <form action="{{route('storecompupdate', $id)}}" method="post" enctype="multipart/form-data">
            @if(Session::get('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-check"></i> {{ Session::get('success') }}<
              </div>
            @endif
            @if(Session::get('fail'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i>  {{ Session::get('fail') }}<
              </div>
            @endif
            @csrf
            @method('PUT')
            <div><label for="current_logo">Logo:</label></div>
            <div class="input-group mb-3">
                <img src="{{asset('storage/company_logos/'.$logo)}}" id="current_logo" alt="<?php echo $logo;?>" style="height: 100px">
            </div>
            <div><label for="company">Company:</label></div>
            <div class="input-group mb-3">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="oldcompany" value="<?php echo $company; ?>">
                <input type="text" class="form-control" id="company" name="company" autofocus placeholder="Enter Company" value="<?php echo $company; ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-briefcase"></span>
                  </div>
                </div>
            </div>
            <div>
                <span class="text-danger">@error('company'){{ $message }}@enderror</span>
            </div>
            <div><label for="logo">New Logo:</label></div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="logo" name="logo" autofocus placeholder="Enter Logo" value="{{ old('logo')}}">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-file"></span>
                  </div>
                </div>
            </div>
            <div>
                <span class="text-danger">@error('logo'){{ $message }}@enderror</span>
            </div>
            
            <div class="row">
              <!-- /.col -->
              <div class="col">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
              </div>
              <!-- /.col -->
            </div>
            <?php } else{ echo "<script>location.replace('/')</script>"; } ?>
          </form>
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
</div>
@endsection