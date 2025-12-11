<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardStats extends Model
{
    protected $table = 'vw_dashboard_stats';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}