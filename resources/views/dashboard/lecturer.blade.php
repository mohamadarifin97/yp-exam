<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-sm text-slate-400 mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <a href="{{ route('exams.create') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:opacity-90 active:scale-95" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Create Exam
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path>
                    <rect x="9" y="3" width="6" height="4" rx="1"></rect>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Exams</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalExams }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#f0fdf4;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Active Exams</p>
                <p class="text-2xl font-bold text-slate-800">{{ $activeExams }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fdf4ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Students</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fef3c7;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                    <path d="M8 21h8M12 17v4"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Classes</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalClasses }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">

        {{-- Left col: Recent Exams + Pending Marking --}}
        <div class="col-span-2 flex flex-col gap-4">

            {{-- Ongoing Exams --}}
            @if ($ongoingExams->isNotEmpty())
                <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #bfdbfe;">
                    <div class="px-5 py-3.5 flex items-center gap-2" style="background:#eff6ff;border-bottom:1px solid #bfdbfe;">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <h2 class="text-sm font-bold text-blue-700">Live Now — Ongoing Exams</h2>
                    </div>
                    <div class="divide-y" style="border-color:#f1f5f9;">
                        @foreach ($ongoingExams as $exam)
                            <div class="flex items-center justify-between px-5 py-3.5">
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">{{ $exam->name }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $exam->subject->name }} &middot; ends {{ \Carbon\Carbon::parse($exam->end)->format('H:i') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold text-slate-500">{{ $exam->attempts_count }} taking</span>
                                    <a href="{{ route('exams.marking', $exam) }}" class="text-xs font-semibold px-3 py-1.5 rounded-xl transition-colors hover:opacity-90" style="background:#eff6ff;color:#2563eb;">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Recent Exams --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Recent Exams</h2>
                    <a href="{{ route('exams.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">View all</a>
                </div>
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid #f1f5f9;background:#fafafa;">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Exam</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Subject</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Classes</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Submissions</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentExams as $exam)
                            @php
                                $now = \Carbon\Carbon::now();
                                $start = \Carbon\Carbon::parse($exam->start);
                                $end = \Carbon\Carbon::parse($exam->end);
                                $isOngoing = $now->between($start, $end);
                                $isPast = $end->isPast();
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-slate-700">{{ $exam->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $start->format('d M Y') }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#eff6ff;color:#2563eb;">
                                        {{ $exam->subject->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">
                                    {{ $exam->classes->pluck('name')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-700">
                                    {{ $exam->attempts_count }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if ($isOngoing)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                                            <span class="text-xs font-semibold text-blue-600">Ongoing</span>
                                        </div>
                                    @elseif($isPast)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                            <span class="text-xs font-semibold text-slate-400">Ended</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                            <span class="text-xs font-semibold text-amber-600">Upcoming</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">No exams yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Right col: Pending Marking --}}
        <div class="flex flex-col gap-4">

            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Pending Marking</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Open text answers awaiting marks</p>
                </div>

                @forelse($pendingMarking as $exam)
                    <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f8fafc;">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-700 truncate">{{ $exam->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $exam->subject->name }} &middot; {{ $exam->attempts_count }} submitted</p>
                        </div>
                        <a href="{{ route('exams.marking', $exam) }}" class="flex-shrink-0 ml-3 flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors hover:opacity-90" style="background:#fdf4ff;color:#9333ea;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Mark
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 px-5 text-center">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <p class="text-sm text-slate-400 font-medium">All caught up!</p>
                        <p class="text-xs text-slate-300 mt-0.5">No pending marking</p>
                    </div>
                @endforelse
            </div>

            {{-- Quick links --}}
            <div class="bg-white rounded-2xl p-5 flex flex-col gap-2" style="border:1px solid #e2e8f0;">
                <h2 class="text-sm font-bold text-slate-700 mb-1">Quick Links</h2>
                <a href="{{ route('exams.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors" style="border:1px solid #f1f5f9;">
                    <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:32px;height:32px;background:#eff6ff;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Create New Exam</span>
                </a>
                {{-- <a href="{{ route('classes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors" style="border:1px solid #f1f5f9;">
                    <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:32px;height:32px;background:#fef3c7;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <path d="M8 21h8M12 17v4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Manage Classes</span>
                </a>
                <a href="{{ route('subjects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors" style="border:1px solid #f1f5f9;">
                    <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:32px;height:32px;background:#f0fdf4;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Manage Subjects</span>
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors" style="border:1px solid #f1f5f9;">
                    <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:32px;height:32px;background:#fdf4ff;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Manage Users</span>
                </a> --}}
            </div>

        </div>
    </div>
</x-app-layout>
