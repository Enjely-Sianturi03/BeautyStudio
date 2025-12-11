@extends('layouts.admin')
@section('title','Riwayat Pembatalan')
@section('page','Riwayat Pembatalan & Penghapusan')

@section('content')
<div class="bg-white shadow rounded p-6 mb-8 border-l-4 border-pink-400">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-pink-200">
        <div class="flex items-center">
            <div class="bg-pink-500 text-white rounded-lg p-3 mr-4 shadow-md">
                <i class="fas fa-trash-restore-alt text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-pink-700">Riwayat Pembatalan & Penghapusan Data</h2>
                <p class="text-gray-600 text-sm mt-1">Log aktivitas pembatalan, penghapusan data, layanan, atau user</p>
            </div>
        </div>
        <button onclick="refreshTable()" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition duration-150 shadow-md flex items-center">
            <i class="fas fa-sync-alt mr-2"></i> Refresh
        </button>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse" id="dataTable">
            <thead class="bg-pink-200">
                <tr>
                    <th class="py-3 px-4 text-left text-pink-800 font-semibold">
                        <i class="far fa-clock mr-2"></i>Waktu
                    </th>
                    <th class="py-3 px-4 text-left text-pink-800 font-semibold">
                        <i class="far fa-user mr-2"></i>Dilakukan Oleh
                    </th>
                    <th class="py-3 px-4 text-left text-pink-800 font-semibold">
                        <i class="fas fa-user-tag mr-2"></i>Peran
                    </th>
                    <th class="py-3 px-4 text-left text-pink-800 font-semibold">
                        <i class="fas fa-ban mr-2"></i>Aksi
                    </th>
                    <th class="py-3 px-4 text-left text-pink-800 font-semibold">
                        <i class="fas fa-info-circle mr-2"></i>Detail Keterangan
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr class="border-b hover:bg-pink-50 transition duration-150">
                    <td class="py-3 px-4">
                        <div class="flex flex-col space-y-1">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($log->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                            </span>
                            <span class="text-sm font-bold text-pink-700 bg-pink-100 px-2 py-1 rounded inline-block">
                                <i class="far fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB
                            </span>
                        </div>
                    </td>
                    
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-br from-pink-400 to-pink-600 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold mr-3 shadow-md">
                                {{ strtoupper(substr($log->user_name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800">{{ $log->user_name }}</span>
                        </div>
                    </td>
                    
                    <td class="py-3 px-4">
                        @php
                            $badge_class = '';
                            $icon = '';
                            if ($log->user_role == 'admin') {
                                $badge_class = 'bg-red-500';
                                $icon = 'fa-user-shield';
                            } elseif ($log->user_role == 'owner') {
                                $badge_class = 'bg-yellow-500';
                                $icon = 'fa-crown';
                            } elseif ($log->user_role == 'pegawai') {
                                $badge_class = 'bg-blue-500';
                                $icon = 'fa-user-tie';
                            } else {
                                $badge_class = 'bg-gray-500';
                                $icon = 'fa-user';
                            }
                        @endphp
                        <span class="{{ $badge_class }} text-white px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center shadow-md">
                            <i class="fas {{ $icon }} mr-1"></i>
                            {{ ucfirst($log->user_role) }}
                        </span>
                    </td>
                    
                    <td class="py-3 px-4">
                        @php
                            $activity_badge = '';
                            $activity_icon = '';
                            $activity = strtolower($log->activity_type);
                            
                            if (str_contains($activity, 'cancel')) {
                                $activity_badge = 'bg-orange-500';
                                $activity_icon = 'fa-times-circle';
                            } elseif (str_contains($activity, 'delete')) {
                                $activity_badge = 'bg-red-600';
                                $activity_icon = 'fa-trash-alt';
                            } else {
                                $activity_badge = 'bg-gray-500';
                                $activity_icon = 'fa-info';
                            }
                        @endphp
                        <span class="{{ $activity_badge }} text-white px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center shadow-md">
                            <i class="fas {{ $activity_icon }} mr-1"></i>
                            {{ ucwords(str_replace('_', ' ', $log->activity_type)) }}
                        </span>
                    </td>
                    
                    <td class="py-3 px-4">
                        <div class="bg-gray-50 border-l-4 border-pink-400 px-3 py-2 rounded text-gray-700 text-sm">
                            {{ $log->description }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-green-100 rounded-full p-6 mb-4">
                                <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada riwayat pembatalan/penghapusan</h3>
                            <p class="text-gray-500">Semua data dalam keadaan baik dan aman</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer / Pagination -->
    @if($logs->count() > 0)
    <div class="mt-6 pt-4 border-t border-pink-200">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1 text-pink-500"></i>
                Menampilkan <span class="font-bold text-pink-700">{{ $logs->firstItem() }}</span> sampai 
                <span class="font-bold text-pink-700">{{ $logs->lastItem() }}</span> dari 
                <span class="font-bold text-pink-700">{{ $logs->total() }}</span> aktivitas
            </div>
            <div class="pagination-wrapper">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
/* Pagination Styling untuk Tailwind */
.pagination-wrapper nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-wrapper .pagination {
    display: flex;
    list-style: none;
    gap: 0.25rem;
    margin: 0;
    padding: 0;
}

.pagination-wrapper .page-item {
    display: inline-block;
}

.pagination-wrapper .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0.75rem;
    min-width: 2.5rem;
    height: 2.5rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    color: #6b7280;
    text-decoration: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.15s ease;
}

.pagination-wrapper .page-link:hover {
    background-color: #fce7f3;
    border-color: #ec4899;
    color: #ec4899;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #ec4899;
    border-color: #ec4899;
    color: white;
    font-weight: 600;
}

.pagination-wrapper .page-item.disabled .page-link {
    background-color: #f3f4f6;
    border-color: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination-wrapper .page-item.disabled .page-link:hover {
    background-color: #f3f4f6;
    border-color: #e5e7eb;
    color: #9ca3af;
}

/* Previous & Next buttons */
.pagination-wrapper .page-item:first-child .page-link,
.pagination-wrapper .page-item:last-child .page-link {
    font-weight: 600;
}

/* Animasi untuk refresh button */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}

/* Hover effects */
table tbody tr {
    transition: all 0.15s ease;
}

table tbody tr:hover {
    transform: translateX(4px);
}

/* Shadow hover untuk badges */
.bg-red-500:hover,
.bg-yellow-500:hover,
.bg-blue-500:hover,
.bg-orange-500:hover,
.bg-red-600:hover,
.bg-gray-500:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Avatar circle hover */
.bg-gradient-to-br:hover {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

/* Responsive table scroll */
@media (max-width: 768px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
    }
    
    table {
        min-width: 800px;
    }
    
    .pagination-wrapper .page-link {
        padding: 0.375rem 0.5rem;
        min-width: 2rem;
        height: 2rem;
        font-size: 0.75rem;
    }
}

/* Custom scrollbar untuk table */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #ec4899;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #db2777;
}
</style>

<script>
function refreshTable() {
    // Animasi loading pada button refresh
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    icon.classList.add('fa-spin');
    
    setTimeout(() => {
        location.reload();
    }, 500);
}
</script>
@endsection