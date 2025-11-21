<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PegawaiReportController extends Controller
{
    public function index()
    {
        $history = Appointment::where('employee_id', Auth::id())
            ->orderBy('date','desc')
            ->paginate(20);

        return view('pegawai.reports.history', compact('history'));
    }
}
