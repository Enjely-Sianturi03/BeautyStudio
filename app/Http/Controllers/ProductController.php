<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(20);
        return view('pegawai.products.index', compact('products'));
    }

    public function requestRestock(Request $request)
    {
        $name = $request->input('product');
        // buat notifikasi atau simpan ke tabel restock_requests
        // contoh singkat:
        // RestockRequest::create(['product_name'=>$name, 'requested_by'=>auth()->id()]);
        return redirect()->back()->with('success','Permintaan restock dikirim ke admin.');
    }
}
