@extends('admin.layout')
@section('content')
<style>
  .today{
    color: #000000cf;
    background: #ffff06;
  }
  .sd{
  
    color: #f81212fc;
  }
  th:nth-of-type(1), td:nth-of-type(1) {
    color: #f81212fc;
}
        th:nth-of-type(7), td:nth-of-type(7) {
          color: #f81212fc;
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  padding-top:5px;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input + .slider {
  background-color: #ff0000b3;
}


input:checked + .slider {
  background-color: #008000bf;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
.limitedNumbChosen, .limitedNumbSelect2{
  width: 180px;
}
</style>

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Calender</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Home</a></li>
              <li class="breadcrumb-item active">Calender</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
                    {{-- <div class="col-lg-3 col-6">
                    </div>
                    <div class="col-lg-3 col-6">
                    </div>
                    <div class="col-lg-3 col-6">
                    </div>
                    <div class="col-lg-3 col-6">
                    </div> --}}
           
                  <h3>{{$month_title }}</h3>
                    <h3 style="    margin-inline-start: auto;"><a href="?ym=<?php echo $prev; ?>">&lt;</a>
                         <?php echo $html_title; ?> 
                         <a href="?ym=<?php echo $next; ?>">&gt;</a>
                    </h3>
                    <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th>SUN</th>
                            <th>MON</th>
                            <th>TUE</th>
                            <th>WED</th>
                            <th>THU</th>
                            <th>FRI</th>
                            <th>SAT</th>
                        </tr>
                            @php
                            foreach ($weeks as $week) {
                                echo $week; 
                            }
                            @endphp
                        </tbody>
                    </table>
          </div>
        </div>
      </section>
  </div>
  <!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Attendance - <input type="text" class="date_h" readonly name="att_date"> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Attendance Table</h3>
  
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
  
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
              <form action=" {{ url('/add/attendance')}}" method="POST">
                  @csrf
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" style="font-size: 15px; line-height: 25px;" >
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Estate</th>
                          <th>Emp. Name</th>
                          <th>Attendance</th>
                          <th>Time/Leave Type</th>
                          <th>Work Types</th>
                          <th>Advance</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyz">
                      @foreach ($employee as $item)
                          <tr>
                            <td> {{ $loop->iteration}}</td>
                            <td> {{ $item->estate_name}}</td>
                            <td> {{ $item->emp_name}}</td>
                            <td> 
                              <label class="switch">
                                <input type="hidden" value="A" name="att[{{$loop->iteration}}]">
                              <input onchange="fuc({{$loop->iteration}})" value="P" name="att[{{$loop->iteration}}]" id="attent{{$loop->iteration}}" type="checkbox" >
                                <span style="padding-left: 5px;" class="slider">&nbsp;&nbsp;P 
                                  &nbsp; &nbsp; &nbsp;
                                    A &nbsp;&nbsp;&nbsp;</span>
                              </label>
                              <input type="hidden" value="{{$item->id}}" name="emp_id[{{$loop->iteration}}]">
                              <input type="hidden" class="date_h"  name="att_date">
                            </td>
                            <td>
                              <span id="replace_one{{$loop->iteration}}"></span>
                               <span class="remp{{$loop->iteration}}">
                                <div  class="form-group ">
                                      <input type="checkbox" value="1"  name="paid_leave[{{$loop->iteration}}]" class="paid_leave"  id="paid_leave{{$loop->iteration}}">
                                      <label style="padding-left: 5px;" for="checkboxSuccess3">
                                        Paid Leave
                                      </label>
                                </div>
                              </span> 
                            </td>
                            <td>
                              <span id="replace_two{{$loop->iteration}}"></span>
                            </td>
                            <td>
                              <span id="replace_three{{$loop->iteration}}"></span>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="saveme" type="submit" class="btn btn-primary">Save</button>
       <span id="here3"></span><button id="editme" formaction="/edit-attendance" class="btn btn-primary">Edit</button>
          
          
        </div>
      </form>
      </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@if(session()->has('message'))  
<div class="modal fade" id="tallModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"><div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">{{ session()->get('message')  }}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    </div>
  </div>
</div>
@endif

<script>
$(document).ready(function() {
$('#tallModal').modal('show');
});
</script> 

<script>
        $(document).on("click", ".btnBooking", function () {
        var date = $(this).data('date');
        $(".date_h").val(date);

       // alert(date);
        $.ajax({
                type:'POST',
                header:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('ajaxRequest.date') }}",
                data:{"_token": "{{ csrf_token() }}",
                date:date
                },
                success:function(data){
                  if (!$.trim(data)){   
                    $("#saveme").show();
                    $("#editme").hide();

                  $('#tbodyz').replaceWith('<tbody id="tbodyz">@foreach ($employee as $item)<tr><td> {{ $loop->iteration}}</td><td> {{ $item->estate_name}}</td><td> {{ $item->emp_name}}</td><td> <label class="switch"><input type="hidden" value="A" name="att[{{$loop->iteration}}]"><input onchange="fuc({{$loop->iteration}})" value="P" name="att[{{$loop->iteration}}]" id="attent{{$loop->iteration}}" type="checkbox" ><span style="padding-left: 5px;" class="slider">&nbsp;&nbsp;P &nbsp; &nbsp; &nbsp;A &nbsp;&nbsp;&nbsp;</span></label><input type="hidden" value="{{$item->id}}" name="emp_id[{{$loop->iteration}}]"><input type="hidden" class="date_h" value="'+date+'"  name="att_date"></td><td><span id="replace_one{{$loop->iteration}}"></span><span class="remp{{$loop->iteration}}"><div  class="form-group "><input type="checkbox" value="1"  name="paid_leave[{{$loop->iteration}}]" class="paid_leave"  id="paid_leave{{$loop->iteration}}"><label style="padding-left: 5px;" for="checkboxSuccess3">Paid Leave</label></div></span></td><td><span id="replace_two{{$loop->iteration}}"></span></td><td><span id="replace_three{{$loop->iteration}}"></span></td></tr>@endforeach</tbody>');  
                     // alert("nothing");
                  }
                  else{   
                    $("#tbodyz").empty();
                    $("#saveme").hide();
                    $("#editme").show();

                    // $("#here3").replaceWith('<span id="here3"></span><a id="editme" href="/edit-attendance/'+date+'" class="btn btn-primary">Edit</a>');
                      $("#save").hide();
                      $("#tbodyz").append(data);
                      console.log(data);
                  }
                    // $('#countryList').fadeIn();  
                    // $('#countryList').html(data);
                  
                }
            });
  
});

</script>
<script>
    function fuc(id)
    {
      if ($('#attent'+id).prop('checked')) {
       
                  $('.remh'+id).remove();
                  $('.remp'+id).remove();
                  $('#replace_one'+id).replaceWith('<span id="replace_one'+id+'"></span><span class="remh'+id+'"><div class="form-group "><input style="" type="checkbox" name="half_day['+id+']" class="half_day" value="1" id="half_day"><label style="padding-left: 5px;" for="checkboxSuccess3"> Half day</label></div></span>');
                  $('#replace_two'+id).replaceWith('<span id="replace_two'+id+'"></span><span class="remh'+id+'"><input name="emp_works['+id+'][]" list="hereme"  class="form-control" id="emp_works'+id+'"><datalist  class="limitedNumbChosen" id="hereme" >@foreach ($works as $item)<option value="{{$item->name}}"></option>@endforeach</datalist></span> ');      
                  $('#replace_three'+id).replaceWith('<span id="replace_three'+id+'"></span><div class="remh'+id+'"><input type="text" name="adv_amount['+id+']" class="form-control" placeholder="Rs."></div>');      
     
        }
        else
        {
          //alert("hw");
                $('.remh'+id).empty();
                  $('.remp'+id).remove()
                  $('#replace_one'+id).replaceWith('<span id="replace_one'+id+'"></span><span class="remp'+id+'"><div class="form-group "><input type="checkbox" name="paid_leave['+id+']" value="1" class="paid_leave"  id="paid_leave'+id+'"><label style="padding-left: 5px;" for="checkboxSuccess3"> Paid Leave</label></div></span>');      
                 }
    }
</script>


@endsection