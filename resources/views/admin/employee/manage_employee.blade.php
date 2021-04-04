@extends('admin.layout')
@section('content')



{{-- add employee modal --}}
<div class="modal fade bd-example-modal-lg" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-primary">
        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <!-- form start -->
          <form role="form" method="POST" action="{{ url('admin/add-employee') }}">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Employee Status</label>
                    <select onchange="empStatus(this.value)" name="emp_status" id="" class="form-control">
                     <option value="">-select-</option>
                      <option value="pda">Permanent - Day(amount)</option> 
                      <option value="pma">Permanent - Monthly(amount)</option> 
                      <option value="lda">Local - Day(amount)</option> 
                    </select>  
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee ID</label>
                    <input type="text" name="emp_id" class="form-control" id="exampleInputEmail1" placeholder="ID">
                    </div>
                </div>

             
              <div class="col-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Estate</label>
                  <select required type="text" name="estate_id" class="form-control" id="exampleInputEmail1" >
                    <option value="">-select-</option>
                    @foreach ($estates as $item)
                      <option value="{{$item->id}}" >{{$item->estate_name}}</option>
                    @endforeach
                  </select>
                  </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" name="emp_name" class="form-control" id="exampleInputEmail1" placeholder="Name">
                </div>
              
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Phone</label>
                  <input type="text" name="emp_phone" class="form-control" id="exampleInputPassword1" placeholder="Phone">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Father/Husband Name</label>
                  <input type="text" name="emp_guardian" class="form-control" id="exampleInputPassword1" placeholder="Father/Husbad name">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Date of Join</label>
                  <input type="date" name="emp_doj" class="form-control" id="exampleInputPassword1" placeholder="dd/mm/yyyy">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nature of Work</label>
                  <input type="text" name="emp_work_nature" class="form-control" id="exampleInputPassword1" placeholder="Nature of work">
                </div>
              </div>

              <div id="replace">
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





<script>
  function empStatus(status)
  {
     
     if(status == 'pda')
     {
      $('.dump').remove()
      $('#replace').replaceWith('<div id="replace"></div><div class="col-6 dump"><div class="form-group"><label for="exampleInputPassword1">Basic Amount(per Day)</label><input type="text" name="emp_basic" class="form-control" id="exampleInputPassword1" placeholder="Rs."></div></div><div class="col-6 dump"><div class="form-group"><label for="exampleInputPassword1">DA(per Day)</label><input type="text" name="emp_da" class="form-control" id="exampleInputPassword1" placeholder="Rs."></div></div>');
     }
     else if(status == 'pma')
     {
      // alert('hi');
        $('.dump').remove()
        $('#replace').replaceWith('<div id="replace"></div><div class="col-6 dump"><div class="form-group"><label for="exampleInputPassword1">Basic Amount(Monthly)</label><input type="text" name="emp_basic" class="form-control" id="exampleInputPassword1" placeholder="Rs."></div></div><div class="col-6 dump"><div class="form-group"><label for="exampleInputPassword1">DA(Monthly)</label><input type="text" name="emp_da" class="form-control" id="exampleInputPassword1" placeholder="Rs."></div></div><div>');
     }
     else if(status == 'lda')
     {
        $('.dump').remove()
        $('#replace').replaceWith('<div id="replace"></div><div class="col-6 dump"><div class="form-group"><label for="exampleInputPassword1">Amount</label><input type="text" name="day_amount" class="form-control" id="exampleInputPassword1" placeholder="Rs."></div></div>');
     }
     else
     {
        $('.dump').remove()
     }
  }
</script>


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
            <a data-toggle="modal" data-target="#addEmployee" class="btn btn-small bg-gradient-info" >
              <i class="fa fa-plus"></i> Add Employee
            </a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
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
                      <h3 class="card-title">Employee List</h3>
                    </div>
                    <!-- /.card-header -->
                <div class="card-body">
                    <table style="font-size: 0.8rem;" id="example1" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>Name</th>
                        <th>Estate</th>
                        <th>Phone</th>
                        <th>Guardian</th>
                        <th>Work Nature</th>
                        <th>Date of Join</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>

                       @foreach ($employee as $item)
                        <tr>
                          <td>  {{ $item->emp_name }} </td>
                          <td>  {{ $item->estate_name }} </td>
                          <td>  {{ $item->emp_phone }} </td>
                          <td>  {{ $item->emp_guardian }} </td>
                          <td>  {{ $item->emp_work_nature }} </td>
                          <td>  {{ $item->emp_doj }} </td>
                          <td> 
                                <a class="btn btn-app">
                                  <i class="fas fa-edit"></i> Edit
                                </a>
                               <a href="{{ url('/admin/remove-employee/'.$item->id)}}" class="btn btn-app">
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