@extends('dash-layout')
<?php
if(isset($_GET['comp']) && isset($_GET['categ'])){
  $comp = ucwords($_GET['comp']);
  $categ = $_GET['categ'];
  if($categ=='busttorso'){
    $choice = "Bust & Torso";
  } else{
    $choice = ucwords($categ);
  }
  
?>
@section('title')
    {{ucwords($comp)}} | {{ucwords($choice)}}
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
        <h3 class="card-title"><?php echo $comp.' | '.$choice;?> </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Reference Name</th>
            <th>Company</th>
            <th>Information</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
        $products = DB::table('products')
          ->where('company', 'like', $comp)
          ->where('category', 'like', $choice)
          ->get();
        foreach ($products as $product) { 
          $delimiter = ",";
          $image_array = explode($delimiter, $product->images);
          $first_image = $image_array[0];
        ?>
        <tr>
          <td><img src="{{asset('storage/product_images/'.$first_image)}}" alt="<?php echo $product->images;?>" style="height: 100px"></td>
          <td><?php echo $product->po; ?></td>
          <td><?php echo $product->refname; ?></td>
          <td><?php echo $product->company; ?></td>
          <td><?php echo $product->information; ?></td>
          <td>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $product->id; ?>">
              <i class="fas fa-eye"></i> View
            </button>
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
                    @foreach(explode($delimiter, $product->images) as $image)
                    <img src="{{asset('storage/product_images/'.$image)}}" alt="<?php echo $image;?>" class="mt-2" style="height: 300px; width: 250px;">
                    @endforeach
                  </div>
                  <div class="col-6">
                    <p><strong>PO:</strong> <?php echo $product->po; ?></p>
                    <p><strong>Refname:</strong> <?php echo $product->refname; ?></p>
                    <p><strong>Company:</strong> <?php echo $product->company; ?></p>
                    <p><strong>Info:</strong> <?php echo $product->information; ?></p>
                    <!-- Add additional product information here -->
                  </div>
                </div>
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
            <th>Reference Name</th>
            <th>Company</th>
            <th>Information</th>
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
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
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
<?php
}
else {
  echo "<script>location.replace('/')</script>";
}
?>