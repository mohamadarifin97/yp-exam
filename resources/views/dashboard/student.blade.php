<x-app-layout>{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800">My Exams</h1>
        <p class="text-sm text-slate-400 mt-0.5">Exams available for your class</p>
    </div>
    <div class="flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white" style="border:1px solid #e2e8f0;">
        @php
            $av = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48'];
            $c  = explode('|', $av[$user->id % count($av)]);
            $in = strtoupper(substr($user->name,0,1).(strpos($user->name,' ') ? substr($user->name,strpos($user->name,' ')+1,1) : ''));
        @endphp
        <div class="flex items-center justify-center rounded-full font-bold text-xs flex-shrink-0"
             style="width:34px;height:34px;background:{{ $c[0] }};color:{{ $c[1] }};">
            {{ $in }}
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-700 leading-tight">{{ $user->name }}</p>
            <p class="text-xs text-slate-400 leading-tight">{{ $user->kelas->name ?? 'No Class' }}</p>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
        <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Exams</p>
            <p class="text-2xl font-bold text-slate-800">{{ $exams->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
        <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#f0fdf4;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Completed</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $exams->filter(fn($e) => $e->attempts->where('user_id', $user->id)->where('submitted_at', '!=', null)->count())->count() }}
            </p>
        </div>
    </div>
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
        <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fef3c7;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Upcoming</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $exams->filter(fn($e) => \Carbon\Carbon::parse($e->start)->isFuture())->count() }}
            </p>
        </div>
    </div>
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
        <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fff1f2;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Missed</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $exams->filter(function($e) use ($user) {
                    $isPast      = \Carbon\Carbon::parse($e->end)->isPast();
                    $isAttempted = $e->attempts->where('user_id', $user->id)->where('submitted_at', '!=', null)->count();
                    return $isPast && !$isAttempted;
                })->count() }}
            </p>
        </div>
    </div>
</div>

{{-- Exam Table --}}
<div class="bg-white rounded-2xl" style="border:1px solid #e2e8f0;">
    <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid #f1f5f9;">
        <h2 class="text-sm font-bold text-slate-700">Available Exams</h2>
        @if($user->kelas)
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#eff6ff;color:#2563eb;">
                {{ $user->kelas->name }}
            </span>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid #f1f5f9;background:#fafafa;">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Exam</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Subject</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Duration</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Start</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">End</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                @php
                    $now         = \Carbon\Carbon::now();
                    $start       = \Carbon\Carbon::parse($exam->start);
                    $end         = \Carbon\Carbon::parse($exam->end);
                    $attempt     = $exam->attempts->where('user_id', $user->id)->first();
                    $isCompleted = $attempt && $attempt->submitted_at;
                    $isOngoing   = $now->between($start, $end);
                    $isUpcoming  = $start->isFuture();
                    $isMissed    = $end->isPast() && !$isCompleted;
                @endphp
                <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                    <td class="px-6 py-4 text-sm text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-700">{{ $exam->name }}</p>
                        @if($exam->description)
                            <p class="text-xs text-slate-400 mt-0.5 truncate" style="max-width:180px;">{{ $exam->description }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#eff6ff;color:#2563eb;">
                            {{ $exam->subject->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        <div class="flex items-center gap-1">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ $exam->duration }} min
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-600">{{ $start->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 text-xs text-slate-600">{{ $end->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($isCompleted)
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                <span class="text-xs font-semibold text-green-600">Completed</span>
                            </div>
                        @elseif($isMissed)
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                <span class="text-xs font-semibold text-red-500">Missed</span>
                            </div>
                        @elseif($isOngoing)
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                                <span class="text-xs font-semibold text-blue-600">Ongoing</span>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span class="text-xs font-semibold text-amber-600">Upcoming</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($isCompleted)
                            <a href="{{ route('exams.result', $attempt->id) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors hover:opacity-90"
                                style="background:#f0fdf4;color:#16a34a;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                View Result
                            </a>
                        @elseif($isOngoing)
                            <a href="{{ route('exams.start', $exam->id) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90"
                                style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                Start Exam
                            </a>
                        @elseif($isMissed)
                            <span class="text-xs text-slate-400">—</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold" style="background:#fef3c7;color:#d97706;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Not Yet
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect>
                            </svg>
                            <p class="text-slate-400 text-sm font-medium">No exams available for your class</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
