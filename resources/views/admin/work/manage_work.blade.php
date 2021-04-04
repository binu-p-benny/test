@extends('admin.layout')
@section('content')
{{-- add employee modal --}}
<div class="modal fade bd-example-modal-lg" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-primary">
        <h5 class="modal-title" id="exampleModalLabel">Add Work</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <!-- form start -->
          <form role="form" method="POST" action="{{ url('admin/add-work') }}">
            @csrf
            <div class="card-body">
              <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Work Title</label>
                  <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Title">
                </div>
              </div>
            </div>
          </div>
            <!-- /.card-body -->

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>



 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
            <a data-toggle="modal" data-target="#addEmployee" class="btn btn-small bg-gradient-info" >
              <i class="fa fa-plus"></i> Add Work
            </a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Home</a></li>
              <li class="breadcrumb-item active">Work</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Work List</h3>
                    </div>
                    <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th width="70%">Work Title</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($works as $item)
                          <tr>
                            <td>  {{ $item->name }} </td>
                            <td> 
                                  {{-- <a class="btn btn-app">
                                    <i class="fas fa-edit"></i> Edit
                                  </a> --}}
                                <a href="{{ url('/admin/remove-work/'.$item->id)}}" class="btn btn-app">
                                    <i  class="fas fa-trash"></i> Delete
                                  </a>
                            </td>
                          </tr> 
                          @endforeach
                     
                    
                      </tbody>
                  
                    </table>
                  </div>
                  <!-- /.card-body -->
              </div>
              </div>
          </div>
        </div>
    </section>

 </div>
@endsection