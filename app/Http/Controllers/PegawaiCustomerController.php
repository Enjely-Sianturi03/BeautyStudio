<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class PegawaiCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name')->paginate(20);
        return view('pegawai.customers.index', compact('customers'));
    }

    public function history($customer)
    {
        $cust = Customer::findOrFail($customer);

        $history = $cust->appointments()->latest()->get();

        return view('pegawai.customers.history', compact('cust','history'));
    }
}
