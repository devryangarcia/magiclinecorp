@extends('admin-dash-layout')
@section('title')
Admin | Dashboard
@endsection
@section('page-header')
Dashboard
@endsection
@section('page-active')
Dashboard
@endsection
@section('links')
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{asset('plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endsection
@section('main-content')
@php
    $users = DB::table('users')->whereNull('archived')->get();
    //$products = DB::table('products')->select('company')->groupBy('company')->get();
    $products = DB::table('products')->whereNull('archived')->get();
    $latestproducts = DB::table('products')->whereNull('archived')->orderBy('id', 'desc')->take(5)->get();
    $partners = DB::table('partners')->whereNull('archived')->get();
@endphp
<div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo count($products); ?></h3>

            <p>All Company Products</p>
          </div>
          <div class="icon">
            <i class="fas fa-shopping-bag"></i>
          </div>
          <a href="{{route('partneredcompany')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <!-- ./col -->
    <div class="col-lg-3 col-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo count($partners); ?></h3>

                <p>Partnered Companies</p>
            </div>
            <div class="icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <a href="{{route('partners')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-warning">
        <div class="inner">
            <h3><?php echo count($users); ?></h3>

            <p>Members</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <a href="{{route('users')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-3 connectedSortable">
      <!-- PRODUCT LIST -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Recently Added Products</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2">
            @foreach ($latestproducts as $latestprod)
            <?php  
                $image_array = [];
                foreach (explode(",",$latestprod->images) as $value) {
                    $image_array[] = $value;
                }
                sort($image_array);
                $first_image = $image_array[0];
            ?>
            <li class="item">
                <div class="product-img">
                  <img src="{{asset('storage/product_images/'.$first_image)}}" alt="Product Image" class="img-size-50">
                </div>
                <div class="product-info">
                  <a href="#" data-toggle="modal" data-target="#myModal<?php echo $latestprod->id; ?>" class="product-title">{{$latestprod->itemref}}
                    <!--<span class="badge badge-warning float-right">$1800</span></a>-->
                  <span class="product-description">
                    {{$latestprod->company}}
                  </span>
                </div>
              </li>
              <!-- /.item -->
              <!-- Modal -->
        <div class="modal fade" id="myModal<?php echo $latestprod->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Product Information</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                              <?php
                                $productimages = $latestprod->images;
                                $imageNames = [];
                                foreach (explode(",",$productimages) as $value) {
                                  $imageNames[] = $value;
                                }
                                // Sort the array of image names
                                sort($imageNames);
  
                                // Loop through the sorted array and output the image names
                                foreach ($imageNames as $i => $image) { 
                              ?>
                                @if ($i==0)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="active"></li>
                                @else
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                                @endif
                              <?php } ?>
                            </ol>
                            <div class="carousel-inner">
                              <?php foreach ($imageNames as $i => $image) { ?>
                              @if ($i==0)
                              <div id="zoom" class="carousel-item active magnify">
                                <img class="d-block w-100 magnifier" src="{{asset('storage/product_images/'.$image)}}" alt="{{$image}}">
                              </div>
                              @else
                              <div id="zoom" class="carousel-item magnify">
                                <img class="d-block w-100 magnifier" src="{{asset('storage/product_images/'.$image)}}" alt="{{$image}}">
                              </div> 
                              @endif
                              <?php } ?>
                            </div>
                            <a class="carousel-control-prev text-dark" href="#carouselExampleIndicators" role="button" data-slide="prev">
                              <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-left"></i>
                              </span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next text-dark" href="#carouselExampleIndicators" role="button" data-slide="next">
                              <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-right"></i>
                              </span>
                              <span class="sr-only">Next</span>
                            </a>
                          </div>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                      <p><strong>PO:</strong> <?php echo $latestprod->po; ?></p>
                      <p><strong>Item Reference:</strong> <?php echo $latestprod->itemref; ?></p>
                      <p><strong>Company:</strong> <?php echo $latestprod->company; ?></p>
                      <p><strong>Description:</strong> <?php echo $latestprod->description; ?></p>
                      <!-- Add additional product information here -->
                      @if (!empty($latestprod->file))
                      <a href="{{asset('storage/product_files/'.$latestprod->file)}}" class="btn btn-primary" download="{{$latestprod->file}}"><i class="fa fa-download"></i> Download</a> 
                      @endif
                    </div>
                  </div>
                </div><!-- 
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
              </div>
            </div>
          </div>
          
            @endforeach
            
            
          </ul>
        </div>
        <!-- /.card-body --><!--
        <div class="card-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Products</a>
        </div> -->
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
      
    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-3 connectedSortable">

    </section>
    <section class="col-lg-3 connectedSortable">

    </section>
    <section class="col-lg-3 connectedSortable">

    </section>
    <!-- right col -->
  </div>
  <!-- /.row (main row) -->
@endsection
@section('scripts')
<!-- Ekko Lightbox -->
<script src="{{asset('/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
    $(function () {
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });
  
      $('.filter-container').filterizr({gutterPixels: 3});
      $('.btn[data-filter]').on('click', function() {
        $('.btn[data-filter]').removeClass('active');
        $(this).addClass('active');
      });
    })
  </script>
@endsection