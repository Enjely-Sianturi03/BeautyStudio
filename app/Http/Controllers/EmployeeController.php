<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Product;

class EmployeeController extends Controller
{
    public function index()
    {
        // Ambil jadwal hari ini jika tabel appointments tersedia
        if (Schema::hasTable('appointments')) {
            try {
                $todayAppointments = Appointment::whereDate('date', now())
                    ->where(function($q) {
                        // jika ada kolom employee_id, filter untuk pegawai yang login
                        if (Schema::hasColumn('appointments', 'employee_id')) {
                            $q->where('employee_id', Auth::id());
                        }
                    })
                    ->orderBy('time')
                    ->get();
            } catch (\Throwable $e) {
                // fallback kosong jika query gagal
                $todayAppointments = collect([]);
            }
        } else {
            $todayAppointments = collect([]);
        }

        // Ambil produk dengan stok rendah jika tabel products tersedia
        if (Schema::hasTable('products')) {
            try {
                $lowStockProducts = Product::where('stock', '<=', 3)->orderBy('stock','asc')->get();
            } catch (\Throwable $e) {
                $lowStockProducts = collect([]);
            }
        } else {
            $lowStockProducts = collect([]);
        }

        $adminMessage = 'Cek stok produk sebelum memulai layanan yang membutuhkan material.';

        return view('pegawai.index', compact('todayAppointments','lowStockProducts','adminMessage'));
    }

    public function customers(Request $request)
    {
        // jika tabel customers ada, ambil data dengan pagination
        if (Schema::hasTable('customers')) {
            try {
                // optional: support search query ?q=
                $q = $request->get('q');
                $query = Customer::query();

                if ($q) {
                    $query->where(function($sub) use ($q) {
                        $sub->where('name', 'like', "%{$q}%")
                            ->orWhere('phone', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
                }

                $customers = $query->orderBy('name')->paginate(20);
            } catch (\Throwable $e) {
                $customers = new LengthAwarePaginator([], 0, 20, 1, [
                    'path' => $request->url(),
                    'pageName' => 'page'
                ]);
            }
        } else {
            $customers = new LengthAwarePaginator([], 0, 20, 1, [
                'path' => $request->url(),
                'pageName' => 'page'
            ]);
        }

        return view('pegawai.customers.index', compact('customers'));
    }

    public function customerHistory($customer)
    {
        // Pastikan tabel customers & appointments ada
        if (! Schema::hasTable('customers')) {
            abort(404, 'Tabel customers belum tersedia.');
        }

        // Cari customer (id atau slug)
        $cust = Customer::where('id', $customer)->orWhere('slug', $customer)->firstOrFail();

        // Ambil history jika relasi appointments tersedia
        if (Schema::hasTable('appointments')) {
            try {
                // Jika model Customer punya relasi appointments, pakai itu,
                // jika tidak, coba ambil dari tabel appointments berdasarkan customer_id
                if (method_exists($cust, 'appointments')) {
                    $history = $cust->appointments()->latest()->paginate(20);
                } else {
                    $history = Appointment::where('customer_id', $cust->id)->latest()->paginate(20);
                }
            } catch (\Throwable $e) {
                $history = new LengthAwarePaginator([], 0, 20, 1, [
                    'path' => request()->url(),
                    'pageName' => 'page'
                ]);
            }
        } else {
            $history = new LengthAwarePaginator([], 0, 20, 1, [
                'path' => request()->url(),
                'pageName' => 'page'
            ]);
        }

        return view('pegawai.customers.history', compact('cust','history'));
    }

    public function reports(Request $request)
    {
        // Kembalikan riwayat layanan (paginated) untuk pegawai yang login
        try {
            if (Schema::hasTable('appointments')) {
                $history = Appointment::where(function($q) {
                        if (Schema::hasColumn('appointments', 'employee_id')) {
                            $q->where('employee_id', Auth::id());
                        }
                    })
                    ->orderBy('date','desc')
                    ->orderBy('time','desc')
                    ->paginate(20);
            } else {
                // fallback paginator kosong
                $history = new LengthAwarePaginator([], 0, 20, 1, [
                    'path' => $request->url(),
                    'pageName' => 'page'
                ]);
            }
        } catch (\Throwable $e) {
            $history = new LengthAwarePaginator([], 0, 20, 1, [
                'path' => $request->url(),
                'pageName' => 'page'
            ]);
        }

        return view('pegawai.reports.index', compact('history'));
    }
}
