@extends('admin-dash-layout')
@section('title')
    Product Trash
@endsection
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/partnerproduct/'.$company)}}">{{strtoupper($company)}}</a></li>
@endsection
@section('page-active')
    Product Trash
@endsection
@section('links')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('main-content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        @if(Session::get('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-check"></i> {{ Session::get('success') }}
          </div>
        @endif
        @if(Session::get('deleted'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i>  {{ Session::get('deleted') }}
          </div>
        @endif
        <div class="row">
          <div class="col-md-1">
            <h3 class="card-title">Trash</h3>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Item Reference</th>
            <th>Category</th>
            <th>Type</th>
            <th>Added By</th>
            <th>Updated By</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php 
              $products=DB::table('products')->where('archived','=',1)->get();
              $checkrole = DB::table('users')->where('id','=',session()->get('LoggedUser'))->get();
              foreach ($checkrole as $check) {
                $userrole = $check->role;
              }
              foreach ($products as $product) { 
                $delimiter = ",";
                $image_array = [];
                foreach (explode(",",$product->images) as $value) {
                    $image_array[] = $value;
                }
                sort($image_array);
                $first_image = $image_array[0];
              ?>
              <tr>
                <td><img src="{{asset('storage/product_images/'.$first_image)}}" alt="<?php echo $first_image;?>" style="height: 100px"></td>
                <td><?php echo $product->po; ?></td>
                <td><?php echo $product->itemref; ?></td>
                <td><?php echo $product->category; ?></td>
                <td><?php echo $product->type; ?></td>
                <td><?php echo $product->addedby; ?></td>
                <td><?php echo $product->updatedby; ?></td>
                <td class="d-flex">
                  <button type="button" class="btn btn-light mr-2" data-toggle="modal" data-target="#myModal<?php echo $product->id; ?>">
                    <i class="fas fa-eye"></i> View
                  </button>
                  <form action="{{route('restoreproduct')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <button class="btn btn-light mr-2"><i class="fa fa-check"></i> Restore</button>
                </form>
                  
                  @if ($userrole=='admin1')
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#myModal2<?php echo $product->id; ?>">
                    <i class="fas fa-trash"></i> Permanently Delete
                  </button>  
                  @endif
                </td>
              </tr>
        
              <!-- Modal -->
              <div class="modal fade" id="myModal<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <div class="col-6">
                          <?php
                            $productimages = $product->images;
                            $imageNames = [];
                            foreach (explode(",",$productimages) as $value) {
                              $imageNames[] = $value;
                            }
                            // Sort the array of image names
                            sort($imageNames);
      
                            // Loop through the sorted array and output the image names
                            foreach ($imageNames as $i => $image) { ?> 
                              @if ($i==0)
                              <img src="{{asset('storage/product_images/'.$image)}}" alt="<?php echo $image;?>" class="mt-2 border img-fluid h-25">
                              @else
                              <img src="{{asset('storage/product_images/'.$image)}}" alt="<?php echo $image;?>" class="mt-2 border img-fluid w-50">
                              @endif
                            <?php }
                          ?>
                        </div>
                        <div class="col-6">
                          <p><strong>PO:</strong> <?php echo $product->po; ?></p>
                          <p><strong>Item Reference:</strong> <?php echo $product->itemref; ?></p>
                          <p><strong>Company:</strong> <?php echo $product->company; ?></p>
                          <p><strong>Description:</strong> <?php echo $product->description; ?></p>
                          <!-- Add additional product information here -->
                          @if (!empty($product->file))
                          <a href="{{asset('storage/product_files/'.$product->file)}}" class="btn btn-primary" download="{{$product->file}}"><i class="fa fa-download"></i> Download</a> 
                          @endif
                          
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="myModal2<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-m" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-warning">
                      <h4 class="modal-title" id="myModalLabel"><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h5> Are you sure to delete this product permanently?</h5>
                      <form action="{{route('deleteproduct')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}">
                        <input type="hidden" name="company" value="{{$product->company}}">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Permanently Delete</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          
          </tbody>
          <tfoot>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Item Reference</th>
            <th>Category</th>
            <th>Type</th>
            <th>Added By</th>
            <th>Updated By</th>
            <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection
@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('/plugins/datatables/jquery.dataTables.min2.js')}}"></script>
<script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
@endsection
