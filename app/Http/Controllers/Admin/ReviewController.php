<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return back()->with('success', 'Review berhasil disetujui!');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Review berhasil dihapus.');
    }
}
