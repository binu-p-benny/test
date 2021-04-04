<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Work;
use App\EmployeeAttendance;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
    public function calender()
    {
        // Set your timezone
date_default_timezone_set('Asia/Tokyo');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Check format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());

// For H3 title
$html_title = date('Y / m', $timestamp);
$month_title = date('F', $timestamp);
// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
// You can also use strtotime!
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));

// Number of days in the month
$day_count = date('t', $timestamp);
 
// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
//$str = date('w', $timestamp);

//echo $str; echo "<br>";

// Create Calendar!!
$weeks = array();
$week = '';
$h_dates = \DB::table('holidays')
->select('holiday_date')
->get();

foreach($h_dates as $hday)
{
    $hds[] = $hday->holiday_date; 
}

//print_r($hds);die;


//holidays
//if()
 
// Add empty cell
$week .= str_repeat('<td></td>', $str);
for ( $day = 1; $day <= $day_count; $day++, $str++) {
     
    $date = $ym . '-' . $day;
    //echo $date; echo "<br>";

    $hday_arr = \DB::table('holidays')
    //  ->select('holiday_title')
      ->where('holiday_date', $date )
      ->get();
//       @$hday_title = $hday_arr->holiday_title;
// print_r(@$date);die;
    if (in_array($date, $hds)) {
        $h_color = "#ed5925";
        $hw_color = "#dee2e6";
       
        $spa = '<p style="font-size: 12px; color:red; margin-bottom: 0px;">'.@$hday_title.'</p>';
      }
     

    $link = '<a style="float:right;" data-toggle="modal" data-target="#exampleModal" class="btnBooking" data-date="'.$date.'"  ><i class="fa fa-clock"></i></a>';
    if ($today == $date) {
        $week .= '<td style=" color: #000000cf; background: #ffff06;" class="today">' . $day.' '.$link;
    } else {
        $week .= '<td style="background: '.@$h_color.';color:'.@$hw_color.';">' . $day . ' '.$link.@$spa;
    }
    $week .= '</td>';
     
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        // Prepare for new week
        $week = '';
    }
    $h_color = "";
    $hw_color = "";
    $spa = "";
   // echo $week; echo "<br>";
  

}
//exit;

        $employee = \DB::table('employees')
        ->join('estates', 'estates.id', 'employees.estate_id')
        ->select('estates.estate_name','employees.*')
        ->get(); 
        
        $works = Work::get();
        return view('admin.calender.calender',compact('weeks','prev','next','html_title','month_title','employee','works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $data = $request->all();
        @$att =  $data['att'];
        @$att_count = count($att);
            foreach(@$att as $key => $val)
            {
                $input['attendance'] = $val;
                $input['att_date'] =  $data['att_date'] ;
                $input['employee_id'] = $data['emp_id'][$key] ;
                if($val == 'P')
                {
                    @$emp_works =  implode("|",$data['emp_works'][$key]);
                    @$half_day = $data['half_day'][$key];
                    @$adv_amount = $data['adv_amount'][$key];
                        $input['works'] =  @$emp_works;
                        $input['half_day'] = @$half_day;
                        $input['adv_amount'] = @$adv_amount;
                        if(@$input['half_day'] == 0)
                        {
                            $input['half_day'] = 0;
                        }
                        if(@$input['adv_amount'] == null)
                        {
                            $input['adv_amount'] = 0;
                        }
                        EmployeeAttendance::create($input);
                }
                else if($val == 'A')
                {
                    $input['paid_leave'] = @$data['paid_leave'][$key];
                    $input['adv_amount'] = 0;
                    $input['half_day'] = 0;
                    EmployeeAttendance::create($input);
                }
                $input = [];
            }
            return redirect()->back()->with('message', 'Attendance added.');
    }

    public function find(Request $request)
    {


        $date = $request->input('date');
        $attendances = \DB::table('employee_attendances')
        ->join('employees', 'employees.id','employee_attendances.employee_id')
        ->join('estates', 'estates.id','employees.estate_id')
        ->where('employee_attendances.att_date', $date)
        ->orderBy('employee_attendances.created_at', 'DESC')
        ->get();

        // echo "<pre>";
      //  print_r($attendances);
        $i = 0;
        $html = "";
        foreach($attendances as $item)
        {
            $i++;
            $estate_name = $item->estate_name;
            $emp_name = $item->emp_name;
            $attendance = $item->attendance;
            $paid_leave = $item->paid_leave;
            $half_day = $item->half_day;
            $emp_id = $item->employee_id;
            $works = explode("|",$item->works);
            $ws = Work::get();
            $adv_amount = $item->adv_amount;
            
                if($attendance == 'P')
                {
                     @$ckd = 'checked';   
                     if($half_day == 1)
                     {
                         @$ckd3 = 'checked';   
 
                     }
                     $w_op = "";
                     foreach ($ws as $w)
                     { 
                        $w_id = $w->id;
                        $w_name = $w->name;
                        if (in_array($w_id, $works)) {
                            @$select = 'selected';
                            @$works_names = @$w_name;

                        }
                      @$w_op  .= '<option '.@$select.' value="'.$w_name.'"></option>';
                      @$select = "";
                     }
                     @$half_day_div = '
                     <span id="replace_one'.$i.'"></span>
                        <span class="remh'.$i.'"><div class="form-group ">
                        <input style="" type="checkbox" '.@$ckd3.' name="half_day['.$i.']" class="half_day" value="1"  id="half_day">
                        <label style="padding-left: 5px;" for="checkboxSuccess3"> Half day</label>
                        </div>
                     </span>';  
                     @$works_div = '
                     <span id="replace_two'.$i.'"></span>
                     <span class="remh'.$i.'">
                     <input value="'.@$works_names.'" name="emp_works['.$i.'][]" list="hereme"  class="form-control" id="emp_works'.$i.'">
                     <datalist  class="limitedNumbChosen" id="hereme" multiple="true">
                     '.@$w_op.'
                     </datalist>
                     </span>';
                     @$adv_amount_div = '
                     <span id="replace_three'.$i.'"></span>
                     <div class="remh'.$i.'">
                        <input type="text" name="adv_amount['.$i.']" value="'.@$adv_amount.'" class="form-control" placeholder="Rs.">
                     </div>';


                }
                else if($attendance == 'A')
                {
                    @$ckd = ''; 
                    if($paid_leave == 1)
                    {
                        @$ckd2 = 'checked';   

                    }
                    @$paid_leave_div = ' 
                    <span id="replace_one'.$i.'"></span>
                    <span class="remp'.$i.'">
                    <div  class="form-group ">
                            <input type="checkbox" value="1" '.@$ckd2.'   name="paid_leave['.$i.']" class="paid_leave"  id="paid_leave'.$i.'">
                            <label style="padding-left: 5px;" for="checkboxSuccess3">
                            Paid Leave
                            </label>
                    </div>
                    </span> 
                    ';  

                }

              

            $html = 
            ' 
            <tr>
            <td>'.$i.'</td>
            <td>'.$estate_name.'</td>
            <td>'.$emp_name.'</td>
            <td>
                <label class="switch"><input type="hidden" value="A" name="att['.$i.']">
                    <input onchange="fuc('.$i.')" '.@$ckd.' value="P" name="att['.$i.']" id="attent'.$i.'" type="checkbox" >
                    <span style="padding-left: 5px;" class="slider">
                         P &nbsp; &nbsp; &nbsp; A &nbsp;&nbsp;
                    </span>
                </label>
                <input type="hidden" value="'.$emp_id.'" name="emp_id['.$i.']">
                <input type="hidden" class="date_h" value="'.$date.'" name="att_date">
            </td>
            <td>
                '.@$paid_leave_div.'
                '.@$half_day_div.'
            </td>
            <td>
                '.@$works_div.'
            </td>
            <td>
                '.@$adv_amount_div.'
            </td>
            
            
            
            </tr>    
            ';
            
            echo $html;
            @$ckd = "";
            @$ckd2 = "";
            @$ckd3 = "";
            @$paid_leave_div = "";
            @$half_day_div = "";
            @$works_div = "";
            @$w_op = "";
            @$adv_amount = "";
            @$adv_amount_div = "";
            @$works_names = "";
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_attendance(Request $request)
    {
    //    echo "<pre>";
    //    print_r($request->all());die;
        $data = $request->all();
        $att_date =  $data['att_date'];
       return view('admin.calender.edit_attendance');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
