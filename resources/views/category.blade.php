@extends('dash-layout')

<?php
  if(isset($_GET['comp']) && isset($_GET['categ'])){
  $comp = $_GET['comp'];
  $categ = $_GET['categ'];
  if($categ=='busttorso'){
    $choice='Bust & Torso';
  } else {
    $choice=$categ;
  }
?>
@section('title')
<?php echo ucwords($comp).' | '.ucwords($choice); ?>
@endsection
@section('main-content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="container mt-5">
            <h1 class="text-center"><?php echo ucwords($choice);?></h1>
            <div class="row mt-5 d-flex justify-content-center">
              <div class="col-4">
                  <a href="{{url('/category/type?categ='.$categ.'&comp='.$comp.'&type=standard')}}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                  <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample"/>
                  </a>
                  <h3 class="text-center">STANDARD</h3>
              </div>
                <div class="col-4">
                    <a href="{{url('/category/type?categ='.$categ.'&comp='.$comp.'&type=special')}}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                    <img src="https://via.placeholder.com/300/000000?text=1" class="img-fluid mb-2" alt="white sample"/>
                    </a>
                    <h3 class="text-center">SPECIAL</h3>
                </div>
            </div>
        </div>
        
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

@endsection

<?php
}
else {
  echo "<script>location.replace('/')</script>";
}
?>