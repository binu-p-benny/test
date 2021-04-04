<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    protected $table = 'employee_attendances';

    protected $fillable = [
        'att_date',
        'employee_id',
        'attendance',
        'half_day',
        'paid_leave',
        'works',
        'adv_amount'
    ];

    protected $hidden = [
    '_token',
    ];
}
