<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LatestCustomer extends Model
{
    protected $table = 'vw_latest_customers';
    public $timestamps = false;
    protected $guarded = [];
}