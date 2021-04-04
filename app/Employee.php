<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'emp_name',
        'emp_status',
        'emp_basic',
        'emp_da',
        'day_amount',
        'estate_id',
        'emp_phone',
        'emp_guardian',
        'emp_work_nature',
        'employees',
        'emp_doj'
    ];

    protected $hidden = [
    '_token',
    ];
}
