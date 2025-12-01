<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tip;
use Illuminate\Support\Facades\Storage;

class TipsArtikelController extends Controller
{
    // LIST
    public function index()
    {
        $tips = Tip::orderBy('id', 'DESC')->paginate(10);
        return view('admin.tipsartikel.index', compact('tips'));
    }

    // CREATE PAGE
    public function create()
    {
        return view('admin.tipsartikel.create');
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'category'  => 'required|string|max:100',
            'type'      => 'required|in:article,video',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|string',
            'link'      => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('tips', 'public');
        }

        Tip::create($validated);

        return redirect()->route('admin.tipsartikel.index')
                         ->with('ok', 'Tips/Artikel berhasil ditambahkan!');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $tip = Tip::findOrFail($id);
        return view('admin.tipsartikel.edit', compact('tip'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $tip = Tip::findOrFail($id);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'category'  => 'required|string|max:100',
            'type'      => 'required|in:article,video',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|string',
            'link'      => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($tip->thumbnail && Storage::disk('public')->exists($tip->thumbnail)) {
                Storage::disk('public')->delete($tip->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('tips', 'public');
        }

        $tip->update($validated);

        return redirect()->route('admin.tipsartikel.index')
                         ->with('ok', 'Tips/Artikel berhasil diperbarui!');
    }

    // DELETE
    public function destroy($id)
    {
        $tip = Tip::findOrFail($id);

        if ($tip->thumbnail && Storage::disk('public')->exists($tip->thumbnail)) {
            Storage::disk('public')->delete($tip->thumbnail);
        }

        $tip->delete();

        return redirect()->route('admin.tipsartikel.index')
                         ->with('ok', 'Tips/Artikel berhasil dihapus!');
    }
}
