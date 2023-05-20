@extends('admin-dash-gen')
@section('title')
Admin | Dashboard
@endsection
@section('page-header')
Dashboard
@endsection
@section('page-active')
Dashboard
@endsection
@section('main-content')
@php
    $checks = DB::table('users')->where('id','=',session()->get('LoggedUser'))->get();
    foreach ($checks as $check) {
      $userrole = $check->role;
    }
    if($userrole=='admin1'){
      echo "<script>location.replace('/admin/dashboard')</script>";
    }
    $lists = [];
    $accesslists = DB::table('access_lists')->where('user_id','=',session()->get('LoggedUser'))->get();
    //$products = DB::table('products')->get();
    foreach ($accesslists as $key => $access) {
      foreach (explode(',',$access->accesslists) as $key => $list) {
        $lists[] = $list;
      }
    }
@endphp 
<div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-6 col-sm-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?php echo count($lists); ?></h3>

          <p>All Company Products</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-bag"></i>
        </div>
        <a href="{{route('adminaccesslists')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
  </div>
    
    
</div>
@endsection