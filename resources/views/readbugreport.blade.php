@extends('admin-dash-layout')
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/reportedbugs')}}">Reported Bugs</a></li>
@endsection
@section('page-active')
Reported Bugs
@endsection
@section('main-content')
<div class="row">
    <div class="col-md-3">
      <a href="{{url('admin/reportedbugs')}}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>
      <?php
            $reportedbugs = DB::select('select * from bug_reports where archived is null');
            $trashes = DB::select('select * from bug_reports where archived = 1');
        ?>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Folders</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item active">
              <a href="{{url('admin/reportedbugs')}}" class="nav-link">
                <i class="fas fa-inbox"></i> Inbox
                <span class="badge bg-primary float-right">{{count($reportedbugs)}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-trash-alt"></i> Trash
                <span class="badge bg-danger float-right">{{count($trashes)}}</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  <div class="col-md-9">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Read Report</h3>

        <!-- <div class="card-tools">
          <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
          <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
        </div> -->
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
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <div class="mailbox-read-info">
          <h5>{{$report->title}}</h5>
          <h6>From: {{$reportsender->email}}
            @if ($report->status=='open')
            <span class="mailbox-read-time float-right">{{$report->created_at}}</span></h6>
            @else
            <span class="mailbox-read-time float-right">{{$report->updated_at}}</span></h6>
            @endif
        </div>
        <!-- /.mailbox-read-info -->
        <!-- /.mailbox-controls -->
        <div class="mailbox-read-message">
          {{$report->description}}
        </div>
        <!-- /.mailbox-read-message -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer bg-white">
        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
          @if ($report->attachment)
              
          
          <?php 
            $filename = $report->attachment;
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            //echo $file_extension;
          ?>
          @if ($file_extension=='jpg' || $file_extension=='png')
              
          <li>
            <span class="mailbox-attachment-icon has-img" style="overflow: hidden;">
              <img src="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" alt="Attachment">
            </span>

            <div class="mailbox-attachment-info">
              <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="mailbox-attachment-name"><i class="fas fa-camera"></i> {{$report->attachment}}</a>
                  <span class="mailbox-attachment-size clearfix mt-1">
                    <!--<span>2.67 MB</span>-->
                    <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="btn btn-default btn-sm float-right" download="{{$report->attachment}}"><i class="fas fa-cloud-download-alt"></i></a>
                  </span>
            </div>
          </li>
          @elseif($file_extension=='pdf')
          <li>
            <span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>

            <div class="mailbox-attachment-info">
              <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> {{$report->attachment}}</a>
                  <span class="mailbox-attachment-size clearfix mt-1">
                    <!--<span>1,245 KB</span>-->
                    <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="btn btn-default btn-sm float-right" download="{{$report->attachment}}"><i class="fas fa-cloud-download-alt"></i></a>
                  </span>
            </div>
          </li>
          @elseif($file_extension=='docx'||$file_extension=='doc')
          
          <li>
            <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

            <div class="mailbox-attachment-info">
              <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> {{$report->attachment}}</a>
                  <span class="mailbox-attachment-size clearfix mt-1">
                    <!--<span>1,245 KB</span>-->
                    <a href="{{asset('storage/bugreport_attachments/'.$report->attachment)}}" class="btn btn-default btn-sm float-right" download="{{$report->attachment}}"><i class="fas fa-cloud-download-alt"></i></a>
                  </span>
            </div>
          </li>
          @endif
          @endif
        </ul>
      </div>
      
      <!-- /.card-footer -->
      <div class="card-footer">
        <div class="float-right">
          <form action="{{route('updatereport')}}" method="post" class="d-flex">
            @csrf
            <div class="input-group">
              <div> <label for="">Status:</label> </div>
              <input type="hidden" name="report_id" value="{{$report->id}}">
              <input type="hidden" name="title" value="{{$report->title}}">
              <select name="status" class="form-control ml-2" id="status">
                <option value="open" <?php echo $currentstatus = ($report->status=='open') ? 'selected' : '' ; ?> >Open</option>
                <option value="closed" <?php echo $currentstatus = ($report->status=='closed') ? 'selected' : '' ; ?> >
                  Closed
                </option>
              </select>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
          </form>
        </div>
        <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
        <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection