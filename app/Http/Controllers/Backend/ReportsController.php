<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\EmployeeAttendanceExport;
use App\Exports\FullEmployeeAttendanceExport;
use App\Employee;
use App\Estate;
use Maatwebsite\Excel\Facades\Excel;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emp_sal_reports()
    {
        $estates = Estate::get();
        $employee = \DB::table('employees')->get(); 
        return view('admin.reports.emp_sal_reports',compact('estates','employee'));
    }

    public function str_emp_sal_reports(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());


        $data = $request->all();

        if($data['emp_id'] != null && $data['from'] != null  && $data['to'] != null )
        {
            session()->put('emp_id', $data['emp_id']);
            session()->put('from', $data['from']);
            session()->put('to', $data['to']);
           // return view('admin.reports.emp_sal_reports_table'); 
            return Excel::download(new EmployeeAttendanceExport, 'emp_report.xlsx');
        }
        else if($data['emp_id'] == null && $data['from'] != null  && $data['to'] != null )
        {
            session()->put('from', $data['from']);
            session()->put('to', $data['to']);
            //return view('admin.reports.full_emp_sal_reports_table'); 
            return Excel::download(new FullEmployeeAttendanceExport, 'full_emp_report.xlsx');

        }
        else
        {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print_emp_sal_reports(Request $request)
    {
        $data = $request->all();

        if($data['emp_id'] != null && $data['from'] != null  && $data['to'] != null )
        {
            session()->put('emp_id', $data['emp_id']);
            session()->put('from', $data['from']);
            session()->put('to', $data['to']);
            session()->put('est_id', $data['est_id']);
            return view('admin.reports.print_emp_sal_reports_table'); 
        }
        else if($data['emp_id'] == null && $data['from'] != null  && $data['to'] != null )
        {
            session()->put('from', $data['from']);
            session()->put('to', $data['to']);
            session()->put('est_id', $data['est_id']);
            return view('admin.reports.print_full_emp_sal_reports_table'); 
        }
        else
        {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
