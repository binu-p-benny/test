<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    //holiday_title
    protected $table = 'holidays';

    protected $fillable = [
        'holiday_title',
        'holiday_date'
    ];

    protected $hidden = [
    '_token',
    ];
}
