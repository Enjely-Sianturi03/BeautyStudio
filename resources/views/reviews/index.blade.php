@extends('layouts.app')

@section('title', 'Manage Reviews')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold mb-6 text-pink-600">Customer Reviews Management</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden border">

        <table class="w-full text-left">
            <thead class="bg-pink-600 text-white">
                <tr>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Rating</th>
                    <th class="py-3 px-4">Message</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                    <tr class="border-b hover:bg-pink-50">
                        <td class="py-3 px-4 font-semibold">{{ $review->name }}</td>

                        <td class="py-3 px-4">
                            {{-- Rating stars --}}
                            <div class="flex text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                        </td>

                        <td class="py-3 px-4 text-gray-700">{{ $review->message }}</td>

                        <td class="py-3 px-4">
                            @if($review->is_approved)
                                <span class="bg-green-200 text-green-700 px-3 py-1 rounded-full text-sm">Approved</span>
                            @else
                                <span class="bg-yellow-200 text-yellow-700 px-3 py-1 rounded-full text-sm">Pending</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 flex gap-3">

                            {{-- Approve Button --}}
                            @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            {{-- Delete Button --}}
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button 
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                    onclick="return confirm('Are you sure want to delete this review?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-600">
                            No reviews available.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
