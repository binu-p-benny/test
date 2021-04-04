<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $table = 'estates';

    protected $fillable = [
        'estate_name',
        'estate_address'
    ];

    protected $hidden = [
    '_token',
    ];
}
