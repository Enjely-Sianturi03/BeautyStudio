<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodayAppointment extends Model
{
    protected $table = 'vw_today_appointments';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}