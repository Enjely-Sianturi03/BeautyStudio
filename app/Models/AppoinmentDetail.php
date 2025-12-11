<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetail extends Model
{
    protected $table = 'vw_appointment_details';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}