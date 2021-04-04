@extends('admin.layout')
@section('content')


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0 text-dark">
            <a data-toggle="modal" data-target="#addEmployee" class="btn btn-small bg-gradient-info" >
              <i class="fa fa-plus"></i> Employee Salary Reports
            </a>
            </h1> --}}
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Home</a></li>
              <li class="breadcrumb-item active">Employee Salary Reports</li>
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
                   
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card card-success">
                                <div class="card-header">
                                  <h3 class="card-title">Different Height</h3>
                                </div>
                                <div class="card-body">
                                    <form  method="POST" role="form">
                                     @csrf
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <!-- text input -->
                                          <label>Select Employee</label>
                                          <select name="emp_id" class="form-control">
                                            <option value="">select</option>
                                              @foreach ($employee as $emp)
                                                <option value="{{$emp->id}}">{{$emp->emp_name}}</option>
                                              @endforeach                                          
                                          </select>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Select Estate</label>
                                            <select name="est_id" class="form-control">
                                              <option value="">-select-</option>
                                              @foreach ($estates as $e)
                                                <option value="{{$e->id}}">{{$e->estate_name}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <!-- select -->
                                          <div class="form-group">
                                            <label>From</label>
                                            <input type="date" name="from" class="form-control" >
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>To</label>
                                            <input type="date" name="to" class="form-control" >
                                          </div>
                                        </div>
                                      </div>

                                      <br>
                                      <div class="row">
                                          <div class="form-group">
                                            <button type="submit" formaction="{{ url('/admin/employee-salary-reports') }}" class="btn btn-block bg-gradient-success btn-sm"><i class="fa fa-file-excel-o"></i> Download</button>
                                            <button type="submit" formaction="{{ url('/admin/print-employee-salary-reports') }}" class="btn btn-block bg-gradient-primary btn-sm"><i class="fa fa-file"></i> Print</button>
                                          </div>
                                      </div>
                    
                                    </form>
                                  </div>
                                <!-- /.card-body -->
                              </div>
                        </div>
                        <!-- /.card-body -->
              </div>
          </div>
        </div>
    </section>

 </div>
@endsection