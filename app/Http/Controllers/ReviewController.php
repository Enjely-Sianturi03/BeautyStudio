<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan dari pelanggan.
     * Ulasan masuk ke database tetapi akan
     * di-review admin sebelum ditampilkan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        Review::create([
            'name' => $request->name,
            'rating' => $request->rating,
            'message' => $request->message,
            'is_approved' => false, // default: belum disetujui admin
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Menunggu persetujuan admin.');
    }

    /**
     * Menampilkan semua ulasan untuk admin.
     */
    public function index()
    {
        $reviews = Review::latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Admin menyetujui ulasan.
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return back()->with('success', 'Ulasan berhasil disetujui!');
    }

    /**
     * Admin menghapus ulasan.
     */
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
