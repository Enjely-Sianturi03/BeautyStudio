<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyRevenue extends Model
{
    protected $table = 'vw_monthly_revenue';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}