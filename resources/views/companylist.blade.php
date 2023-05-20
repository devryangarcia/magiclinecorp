@extends('dash-layout')
@section('title')
    Partners
@endsection
@section('page-active')
  Partners
@endsection
@section('main-content')
<div class="row">
  <div class="container mt-5">
      <h1 class="text-center">PARTNERS</h1>
      <div class="row mt-5 d-flex justify-content-center">
        @foreach($accesslists as $access)
        <?php
        $comps = DB::select('select * from partners where company = ?',[$access]);
        foreach($comps as $comp){
        }
        ?>
        <div class="col-sm-3 col-md-2 col-lg-2">
          <a href="{{url('company/'.strtolower($access))}}">
            <img src="{{asset('storage/company_logos/'.$comp->logo)}}" class="img-fluid mb-2" alt="{{$comp->logo}}"/>
          </a>
          
        </div>
        @endforeach
      </div>
  </div>
  
</div>
@endsection