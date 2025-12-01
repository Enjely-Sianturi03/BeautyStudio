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
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        // Simpan ulasan (read-only untuk user, is_approved default false)
        Review::create([
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_approved' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Ulasan Anda berhasil dikirim! Menunggu persetujuan admin.');
    }

    /**
     * Menampilkan semua ulasan untuk admin.
     * Bisa juga filter yang sudah disetujui.
     */
    public function index(Request $request)
    {
        // Opsional filter: tampilkan semua atau hanya yang approved
        $reviews = Review::query()
            ->when($request->has('approved'), function($query) use ($request) {
                $query->where('is_approved', $request->approved);
            })
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Admin menyetujui ulasan.
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Ulasan berhasil disetujui!');
    }

    /**
     * Admin menghapus ulasan.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
