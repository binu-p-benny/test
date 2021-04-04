@php
    if( session()->has('from') && session()->has('to') && session()->has('est_id'))
    {
        if(!session()->has('emp_id'))
        {
        $e_from = session()->get('from');
        $e_to = session()->get('to');
        $est_id = session()->get('est_id');

        session()->forget('from');
        session()->forget('to');
        session()->forget('est_id');
        }
      
    }
    else {
        return redirect()->back();
    }

        $employee = \DB::table('employees')
        ->where('estate_id', $est_id)
        ->select('id')
        ->orderBy('id')
        ->get();

        $estate_data = \DB::table('estates')
        ->where('id', $est_id)
        ->orderBy('id')
        ->first();

        // foreach ($employee as $e) 
        // {
        //   $eid = $e->id;
        // }
        $total_p_count = 0;
            $sal_total = 0;
            $total_emp_pf = 0;
            $total_emp_balance_salary_sum = 0;
            $ad_data = 0;
            $total_adv_amount = 0;
@endphp
<style>
    table {
  width: 100%;
  border-collapse: collapse;
 
}
table, th, td {
  border: 1px solid black;
  text-align: center;
}
</style>
<center style="line-height: 2px;">
    <h4>{{$estate_data->estate_name}}</h4>
    <h5>{{$estate_data->estate_address}}</h5>
</center>
<center >
    @php
        $newDate_from = date("d-m-Y", strtotime($e_from));
        $newDate_to = date("d-m-Y", strtotime($e_to));
        
    @endphp
    <h5>checkroll from <b>"{{$newDate_from}}"</b> to <b>"{{$newDate_to}}"</b></h5>
</center>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Total Days</th>
            <th>Total Wage</th>
            <th>Weekly Advance</th>
            <th>Total Recovery</th>
            <th>Balanace</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($employee as $e)
          @php
            $eid = $e->id;

            $emp_data = \DB::table('employees')
            ->where('id', $eid)
            ->first();

            $emp_basic = $emp_data->emp_basic;
            $emp_da = $emp_data->emp_da;
            $daily_salary = $emp_basic + $emp_da;

            $p_count = \DB::table('employee_attendances')
            ->where('attendance', 'P')
            ->where('employee_id', $eid)
            ->whereBetween('att_date', [$e_from,$e_to])
            ->count();
           
            $emp_att = \DB::table('employee_attendances')
            ->where('employee_id', $eid)
            ->whereBetween('att_date', [$e_from,$e_to])
            ->orderBy('att_date')
            ->get();

            $adv_sakary_sum = \DB::table('employee_attendances')
            ->where('employee_id', $eid)
            ->whereBetween('att_date', [$e_from,$e_to])
            ->sum('adv_amount');

            $adv_sakary = \DB::table('employee_attendances')
            ->where('employee_id', $eid)
            ->where('adv_amount', '!=', 0)
            ->whereBetween('att_date', [$e_from,$e_to])
            ->get();

            // echo "<pre>";
            //     print_r($adv_sakary);die;

        $emp_pf = 0;
            if ($emp_data->emp_status == 'pda') {
                $total_salary_sum = ($daily_salary * $p_count);
                $emp_pf = ($total_salary_sum * 10)/100;
                $ba_sal = $total_salary_sum - $adv_sakary_sum;
                $balance_salary_sum = $ba_sal - $emp_pf;            
            }
            else if ($emp_data->emp_status == 'pma') {
                $total_salary_sum = $emp_basic + $emp_da;
                $emp_pf = ($total_salary_sum * 10)/100;
                $ba_sal = $total_salary_sum - $adv_sakary_sum;
                $balance_salary_sum = $ba_sal - $emp_pf;
            }
            else if ($emp_data->emp_status == 'lda') {
                $total_salary_sum = ($emp_data->day_amount * $p_count);
                $balance_salary_sum = $total_salary_sum - $adv_sakary_sum;
            }
            else {
                break;
            }

            
          //  $balance_salary_sum = $total_salary_sum - $adv_sakary_sum;
          @endphp
            <tr>
                <td><b> {{ $emp_data->emp_name }} </b></td>
                <td><b> {{ $p_count }} </b></td>
                <td><b> {{ $total_salary_sum }} </b></td>
                <td>
                   <table style=" border: none !important;" >
                    <tr style=" border: none !important;">
                       @foreach ($adv_sakary as $as)
                       @php
                            $newDate01 = date("d, M", strtotime($as->att_date));
                       @endphp
                           <td  >{{$loop->iteration}}({{$newDate01}})  <br> {{$as->adv_amount}} </td>
                     @php
                         $ad_data =  $ad_data + $as->adv_amount;
                     @endphp
                           @endforeach
                    </tr>
                   </table>
                </td>
                <td><b> {{ $emp_pf }} </b></td>
                <td><b> {{ $balance_salary_sum }} </b></td>
              
            </tr>
         
           

          @php

            $total_p_count = $total_p_count + $p_count;
            $sal_total = $sal_total + $total_salary_sum; 
            $total_emp_pf = $total_emp_pf + $emp_pf;
            $total_emp_balance_salary_sum = $total_emp_balance_salary_sum + $balance_salary_sum;
            
            $emp_pf = "";
              $emp_data = "";
              $emp_basic = "";
              $emp_da = "";
              $daily_salary = "";
              $p_count = "";
              $emp_att = "";
              $total_salary_sum = "";
              $adv_sakary_sum = "";
              $balance_salary_sum = "";
          @endphp
        @endforeach
        <tr>
            <td>Total</td>
            <td><b> {{ $total_p_count }} </b></td>
            <td><b> {{ $sal_total }} </b></td>
            <td>
                   @foreach ($adv_sakary as $as)
                       @php
                            $total_adv_amount = $total_adv_amount + $as->adv_amount;
                       @endphp
                   @endforeach
              <b>{{$ad_data}}</b> 
            </td>
            <td><b> {{ $total_emp_pf }} </b></td>
            <td><b> {{ $total_emp_balance_salary_sum }} </b></td>
          
        </tr>
    </tbody>
</table>

