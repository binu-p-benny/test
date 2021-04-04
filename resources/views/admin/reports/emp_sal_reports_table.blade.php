@php
    if(session()->has('emp_id') && session()->has('from') && session()->has('to'))
    {
        $e_id = session()->get('emp_id');
        $e_from = session()->get('from');
        $e_to = session()->get('to');

        session()->forget('emp_id');
        session()->forget('from');
        session()->forget('to');
    }
    else {
        
    }

     $emp_data = \DB::table('employees')
        ->where('id', $e_id)
        ->first();

        $emp_basic = $emp_data->emp_basic;
        $emp_da = $emp_data->emp_da;
        $daily_salary = $emp_basic + $emp_da;

        $p_count = \DB::table('employee_attendances')
        ->where('attendance', 'P')
        ->where('employee_id', $e_id)
        ->whereBetween('att_date', [$e_from,$e_to])
        ->count();

//echo $p_count;die;


        $emp_att = \DB::table('employee_attendances')
        ->where('employee_id', $e_id)
        ->whereBetween('att_date', [$e_from,$e_to])
        ->orderBy('att_date')
        ->get();

        $adv_sakary_sum = \DB::table('employee_attendances')
        ->where('employee_id', $e_id)
        ->whereBetween('att_date', [$e_from,$e_to])
        ->sum('adv_amount');

        $total_salary_sum = ($daily_salary * $p_count);
        $balance_salary_sum = ($daily_salary * $p_count) - $adv_sakary_sum;
@endphp


<table>
    <thead>
        {{-- <tr>
            <td> <b>Name </b></td>
        </tr> --}}
    </thead>
    <tbody>
        {{-- <tr>
            <td> {{ $emp_data->emp_name }}</td>
        </tr> --}}
        <tr>
            <td> <h3>Attendance</h3> </td>
        </tr>
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
                {{$adv_sakary_sum}}
            </td>
            <td>
                {{$balance_salary_sum}}
            </td>
        </tr>
    </tbody>
</table>

{{-- 
<table>
    <thead>
        <tr>
            <td> <b>Name </b></td>
        </tr>
        
    </thead>

    <tbody>
        <tr>
            <td> {{ $emp_data->emp_name }}</td>
        </tr>
        <tr>
            <table >
                <tr>
                    <td> Attendance</td>
                </tr>
                <tr>
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
                        Advance Amount
                    </td>
                    <td>
                        Balance Amount
                    </td>
                </tr>
                <tr>
                    @foreach ($emp_att as $item)
                     <td> <b> {{ $item->attendance}} </b> </td> 
                    @endforeach
                    <td>
                        {{$total_salary_sum}}
                    </td>
                    <td>
                        {{$adv_sakary_sum}}
                    </td>
                    <td>
                        {{$balance_salary_sum}}
                    </td>
                </tr>
            </table>
        </tr>
    </tbody>
</table> --}}