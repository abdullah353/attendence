<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $fillable = array('name', 'device_id', 'department');

    public function checkins()
    {
        return $this->hasMany('App\Checkin');
    }
}
