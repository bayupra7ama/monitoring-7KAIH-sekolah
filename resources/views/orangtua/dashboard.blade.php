@extends('layouts.orangtua')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8">

        <div class="flex-1 mb-4">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b-2 border-red-400 w-max pb-1">Dashboard</h2>

            <div class="bg-white rounded-3xl p-8 shadow-sm mb-6 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Pantau Perkembangan Karakter</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Pilih profil anak di sebelah kanan untuk melihat statistik dan materi pembelajaran khusus untuk
                        kelas mereka.
                    </p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
                    <svg class="w-32 h-32 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                        </path>
                    </svg>
                </div>
            </div>

            @foreach ($children as $index => $child)
                @php
                    // Filter Materi & Hitung Statistik
                    $materiAnak = $materis->filter(function ($m) use ($child) {
                        return $child->class && $m->guru_id == $child->class->teacher_id;
                    });
                    $totalMateri = $materiAnak->count();
                    $sudahDiterapkan = $materiAnak
                        ->filter(function ($m) use ($child) {
                            return $m->feedbacks
                                ->where('student_id', $child->id)
                                ->where('sudah_diterapkan', true)
                                ->isNotEmpty();
                        })
                        ->count();
                    $jumlahFeedback = $materiAnak
                        ->filter(function ($m) use ($child) {
                            return $m->feedbacks
                                ->where('student_id', $child->id)
                                ->whereNotNull('isi_feedback')
                                ->isNotEmpty();
                        })
                        ->count();
                @endphp

                <div id="stats-child-{{ $index }}"
                    class="child-stats grid grid-cols-1 md:grid-cols-3 gap-4 {{ $index == 0 ? '' : 'hidden' }}">
                    <div
                        class="bg-[#6C5CE7] rounded-3xl p-6 text-white shadow-lg shadow-indigo-200 flex flex-col justify-center h-32">
                        <span class="text-4xl font-bold mb-1">{{ $totalMateri }}</span>
                        <span class="text-xs font-medium opacity-80 uppercase tracking-wide">Total Materi</span>
                    </div>
                    <div
                        class="bg-white rounded-3xl p-6 text-gray-800 shadow-sm border border-gray-100 flex flex-col justify-center h-32">
                        <span class="text-4xl font-bold mb-1 text-green-600">{{ $sudahDiterapkan }}</span>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Materi Diterapkan</span>
                    </div>
                    <div
                        class="bg-white rounded-3xl p-6 text-gray-800 shadow-sm border border-gray-100 flex flex-col justify-center h-32">
                        <span class="text-4xl font-bold mb-1 text-orange-500">{{ $jumlahFeedback }}</span>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Umpan Balik</span>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="w-full lg:w-80">

            <div class="bg-white rounded-2xl p-4 shadow-sm mb-6 border border-gray-100 relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase mb-3">Pilih Profil Anak</p>
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    @foreach ($children as $index => $child)
                        @php
                            // 1. Notif Materi (Yang lama)
                            $materiKhusus = $materis->filter(function ($m) use ($child) {
                                return $child->class && $m->guru_id == $child->class->teacher_id;
                            });
                            $notifMateri = $materiKhusus
                                ->filter(function ($m) use ($child) {
                                    $isDone = $m->feedbacks
                                        ->where('student_id', $child->id)
                                        ->where('sudah_diterapkan', true)
                                        ->isNotEmpty();
                                    return !$isDone;
                                })
                                ->count();

                            // 2. Notif Jurnal (YANG BARU)
                            // Cek apakah ada jurnal hari ini (created_at/tanggal hari ini)
                            // Kita pakai query sederhana langsung ke Model Jurnal biar cepat
                            $sudahIsiJurnal = \App\Models\Jurnal::where('student_id', $child->id)
                                ->whereDate('tanggal', \Carbon\Carbon::today())
                                ->exists();

                            // Jika SUDAH isi, notif 0. Jika BELUM, notif 1.
                            $notifJurnal = $sudahIsiJurnal ? 0 : 1;

                            // Total Notif
                            $totalNotif = $notifMateri + $notifJurnal;
                        @endphp

                        <button onclick="switchChild({{ $index }})" id="btn-child-{{ $index }}"
                            class="child-btn relative flex items-center gap-2 px-3 py-2 rounded-lg border transition-all w-full shrink-0 group
                            {{ $index == 0 ? 'bg-indigo-50 border-indigo-200 ring-2 ring-indigo-100' : 'border-gray-100 hover:bg-gray-50' }}">

                            <div
                                class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold shrink-0">
                                {{ substr($child->name, 0, 1) }}
                            </div>

                            <span
                                class="text-sm font-semibold text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis max-w-[80px]">
                                {{ explode(' ', $child->name)[0] }}
                            </span>

                            {{-- BADGE MERAH --}}
                            @if ($totalNotif > 0)
                                <span
                                    class="ml-auto bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-sm animate-pulse">
                                    {{ $totalNotif }}
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach ($children as $index => $child)
                <div id="card-child-{{ $index }}"
                    class="child-card bg-white rounded-3xl p-6 shadow-sm text-center {{ $index == 0 ? '' : 'hidden' }}">

                    <div
                        class="h-20 w-20 mx-auto bg-red-100 rounded-full flex items-center justify-center text-red-500 text-3xl font-bold mb-4">
                        {{ substr($child->name, 0, 1) }}
                    </div>

                    <h3 class="font-bold text-lg text-gray-800">{{ $child->name }}</h3>
                    <p class="text-sm text-gray-400 mb-6">Kelas {{ $child->class->name ?? '-' }}</p>

                    <div class="text-left border-t border-gray-100 pt-4">
                        <p class="font-bold text-gray-700 mb-3 text-xs uppercase tracking-wide">Materi Baru Tersedia</p>
                        @php
                            $materiKhusus = $materis
                                ->filter(function ($m) use ($child) {
                                    return $child->class && $m->guru_id == $child->class->teacher_id;
                                })
                                ->take(3);
                        @endphp

                        @forelse($materiKhusus as $materi)
                            <a href="{{ route('orangtua.materi.show', $materi->id) }}" class="block">
                                <div
                                    class="bg-gray-50 rounded-xl p-3 mb-2 flex items-center gap-3 border border-gray-100 hover:bg-indigo-50 hover:border-indigo-200 transition-all cursor-pointer group">
                                    <div
                                        class="h-8 w-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center shrink-0 group-hover:bg-teal-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden flex-1">
                                        <p class="text-xs font-bold text-gray-700 truncate group-hover:text-indigo-700">
                                            {{ $materi->judul }}</p>
                                        @if ($materi->feedbacks->where('student_id', $child->id)->where('sudah_diterapkan', true)->isNotEmpty())
                                            <p class="text-[9px] text-green-600 flex items-center mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Sudah Diterapkan
                                            </p>
                                        @else
                                            <p class="text-[9px] text-gray-400 mt-1">Belum dikerjakan</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-400 text-xs">Tidak ada materi baru.</p>
                            </div>
                        @endforelse

                        @if ($materiKhusus->count() > 0)
                            <a href="{{ route('orangtua.anak.materi', $child->id) }}"
                                class="block w-full mt-3 py-2 text-xs font-bold text-center text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                Lihat Semua Materi
                            </a>
                        @endif
                    </div>
                    <div class="mt-2">
                        @php
                            $isJurnalToday = \App\Models\Jurnal::where('student_id', $child->id)
                                ->whereDate('tanggal', \Carbon\Carbon::today())
                                ->exists();
                        @endphp

                        <a href="{{ route('orangtua.jurnal.index', $child->id) }}"
                            class="block w-full py-2 text-xs font-bold text-center rounded-lg transition-colors border {{ $isJurnalToday ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200 animate-pulse' }}">
                            @if ($isJurnalToday)
                                ✅ Jurnal Hari Ini Terisi
                            @else
                                📝 Isi Jurnal Hari Ini
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        function switchChild(index) {
            // Ganti Kartu Profil
            document.querySelectorAll('.child-card').forEach(el => el.classList.add('hidden'));
            document.getElementById('card-child-' + index).classList.remove('hidden');

            // Ganti Statistik
            document.querySelectorAll('.child-stats').forEach(el => el.classList.add('hidden'));
            document.getElementById('stats-child-' + index).classList.remove('hidden');

            // Update Tombol Aktif
            document.querySelectorAll('.child-btn').forEach(el => {
                el.classList.remove('bg-indigo-50', 'border-indigo-200', 'ring-2', 'ring-indigo-100');
                el.classList.add('border-gray-100');
            });
            const activeBtn = document.getElementById('btn-child-' + index);
            activeBtn.classList.remove('border-gray-100');
            activeBtn.classList.add('bg-indigo-50', 'border-indigo-200', 'ring-2', 'ring-indigo-100');
        }
    </script>
@endsection
