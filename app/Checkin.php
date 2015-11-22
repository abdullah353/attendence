<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('day', 'checkin', 'start', 'end', 'employee_id');

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
