@php
    if( session()->has('from') && session()->has('to'))
    {
        if(!session()->has('emp_id'))
        {
        $e_from = session()->get('from');
        $e_to = session()->get('to');

        session()->forget('from');
        session()->forget('to');
        }
      
    }
    else {
        return redirect()->back();
    }

        $employee = \DB::table('employees')
        ->select('id')
        ->orderBy('id')
        ->get();

        // foreach ($employee as $e) 
        // {
        //   $eid = $e->id;
        // }

     
@endphp


<table>
    <tbody>
        <tr>
            <td> <h3>Attendance</h3> </td>
        </tr>
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
                    @foreach ($emp_att as $item)
                        @php
                            $changeDate = date("d-m-Y", strtotime($item->att_date));
                        @endphp
                        <td> {{ $changeDate }} </td>
                    @endforeach
                <td>
                    Total Salary Amount
                </td>
                <td>
                    P. F(10%)
                </td>
                <td>
                    Advance Amount
                </td>
                <td>
                    Balance Amount
                </td>
            </tr>
            <tr>
                <td></td>
                @foreach ($emp_att as $item)
                <td> <b> {{ $item->attendance}} </b> </td> 
                @endforeach
                <td>
                    {{$total_salary_sum}}
                </td>
                <td>
                    {{@$emp_pf}}
                </td>
                <td>
                    {{$adv_sakary_sum}}
                </td>
                <td>
                    {{$balance_salary_sum}}
                </td>
            </tr>

            <tr>
                @foreach ($emp_att as $item)
                
                  @php
                    $adv_amt =   $item->adv_amount
                  @endphp
                   @if ($adv_amt == 0) 
                      @php
                       $adv_amt = "";   
                      @endphp 
                @else
                @php
                    $adv_amt =   $item->adv_amount;
                @endphp
                    @endif
                <td><b>{{ @$adv_amt }}</b>   </td> 
                @php
                 @$adv_amt = "";
                @endphp
                @endforeach
            </tr>

          @php
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
    
    </tbody>
</table>

