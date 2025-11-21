<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;

class EmployeeController extends Controller
{
    public function index()
    {
        $todayAppointments = Appointment::whereDate('date', now())->get();
        $lowStockProducts = []; // ambil dari Product::where('stock','<',threshold)->get();

        $adminMessage = 'Cek stok produk sebelum memulai layanan yang membutuhkan material.';

        return view('pegawai.index', compact('todayAppointments','lowStockProducts','adminMessage'));
    }

    public function customers()
    {
        $customers = Customer::paginate(20);
        return view('pegawai.customers.index', compact('customers'));
    }

    public function customerHistory($customer)
    {
        // Bisa terima id atau slug; sesuaikan dengan modelmu
        $cust = Customer::where('id', $customer)->orWhere('slug', $customer)->firstOrFail();
        $history = $cust->appointments()->latest()->get();
        return view('pegawai.customers.history', compact('cust','history'));
    }

    public function reports()
    {
        // implementasi sesuai kebutuhan
        return view('pegawai.reports.index');
    }
}
