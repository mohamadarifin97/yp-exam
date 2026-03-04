<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Admin Dashboard</h1>
            <p class="text-sm text-slate-400 mt-0.5">Full system overview</p>
        </div>
        {{-- <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-xl" style="background:#fdf4ff;color:#9333ea;border:1px solid #e9d5ff;">
                Administrator
            </span>
            <span class="text-xs text-slate-400 font-medium">{{ auth()->user()->name }}</span>
        </div> --}}
    </div>

    {{-- Stats row 1 --}}
    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Users</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#f0fdf4;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Students</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fdf4ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Lecturers</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalLecturers }}</p>
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
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Classes</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalClasses }}</p>
            </div>
        </div>
    </div>

    {{-- Stats row 2 --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#ecfdf5;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Subjects</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalSubjects }}</p>
            </div>
        </div>
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
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fff1f2;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Submissions</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalAttempts }}</p>
            </div>
        </div>
    </div>

    {{-- Ongoing exams alert --}}
    @if ($ongoingExams->isNotEmpty())
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border:1px solid #bfdbfe;">
            <div class="px-5 py-3.5 flex items-center gap-2" style="background:#eff6ff;border-bottom:1px solid #bfdbfe;">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <h2 class="text-sm font-bold text-blue-700">Live Now — {{ $ongoingExams->count() }} Ongoing Exam{{ $ongoingExams->count() > 1 ? 's' : '' }}</h2>
            </div>
            <div class="divide-y" style="border-color:#f1f5f9;">
                @foreach ($ongoingExams as $exam)
                    <div class="flex items-center justify-between px-5 py-3.5">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">{{ $exam->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $exam->subject->name }} &middot;
                                ends {{ \Carbon\Carbon::parse($exam->end)->format('H:i') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-semibold text-slate-500">{{ $exam->attempts_count }} taking</span>
                            <a href="{{ route('exams.marking', $exam) }}" class="text-xs font-semibold px-3 py-1.5 rounded-xl" style="background:#eff6ff;color:#2563eb;">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-3 gap-4">

        {{-- Left: Recent Exams --}}
        <div class="col-span-2 flex flex-col gap-4">

            {{-- Recent Exams table --}}
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
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Submissions</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Action</th>
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
                                <td class="px-5 py-3.5 text-sm font-semibold text-slate-700">{{ $exam->attempts_count }}</td>
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
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('exams.edit', $exam) }}" class="text-xs font-semibold px-3 py-1.5 rounded-xl hover:opacity-90 transition-colors" style="background:#fef3c7;color:#d97706;">
                                        Edit
                                    </a>
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

            {{-- Recent Users --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Recent Users</h2>
                    <a href="{{ route('users.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">View all</a>
                </div>
                <div class="divide-y" style="border-color:#f8fafc;">
                    @forelse($recentUsers as $user)
                        @php
                            $av = ['#eff6ff|#2563eb', '#f0fdf4|#16a34a', '#fef3c7|#d97706', '#fdf4ff|#9333ea', '#fff1f2|#e11d48'];
                            $c = explode('|', $av[$user->id % count($av)]);
                            $in = strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') ? substr($user->name, strpos($user->name, ' ') + 1, 1) : ''));
                            $rolePalette = ['admin' => '#ede9fe|#7c3aed', 'lecturer' => '#fef3c7|#d97706', 'student' => '#f0fdf4|#16a34a'];
                            $rp = explode('|', $rolePalette[$user->role] ?? '#f1f5f9|#64748b');
                        @endphp
                        <div class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full font-bold text-xs flex-shrink-0" style="width:34px;height:34px;background:{{ $c[0] }};color:{{ $c[1] }};">
                                    {{ $in }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:{{ $rp[0] }};color:{{ $rp[1] }};">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="text-xs text-slate-400">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-sm text-slate-400">No users yet</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right col --}}
        <div class="flex flex-col gap-4">

            {{-- Pending Marking --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Pending Marking</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Open text awaiting marks</p>
                </div>
                @forelse($pendingMarking as $exam)
                    <div class="flex items-center justify-between px-5 py-3.5" style="border-bottom:1px solid #f8fafc;">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-700 truncate">{{ $exam->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $exam->subject->name }} &middot; {{ $exam->attempts_count }} submitted</p>
                        </div>
                        <a href="{{ route('exams.marking', $exam) }}" class="flex-shrink-0 ml-3 flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold hover:opacity-90" style="background:#fdf4ff;color:#9333ea;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Mark
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 px-5 text-center">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <p class="text-sm text-slate-400 font-medium">All caught up!</p>
                    </div>
                @endforelse
            </div>

            {{-- Subject Stats --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Exams by Subject</h2>
                    <a href="{{ route('subjects.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">Manage</a>
                </div>
                <div class="px-5 py-4 flex flex-col gap-3">
                    @forelse($subjectStats as $subject)
                        @php
                            $colors = ['#2563eb', '#16a34a', '#d97706', '#9333ea', '#e11d48'];
                            $color = $colors[$loop->index % count($colors)];
                            $max = $subjectStats->max('exams_count') ?: 1;
                            $pct = round(($subject->exams_count / $max) * 100);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-semibold text-slate-600">{{ $subject->name }}</span>
                                <span class="text-xs font-bold text-slate-500">{{ $subject->exams_count }} exam{{ $subject->exams_count !== 1 ? 's' : '' }}</span>
                            </div>
                            <div class="w-full rounded-full" style="height:6px;background:#f1f5f9;">
                                <div class="rounded-full transition-all" style="height:6px;width:{{ $pct }}%;background:{{ $color }};"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">No data yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Class Stats --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
                <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <h2 class="text-sm font-bold text-slate-700">Students by Class</h2>
                    <a href="{{ route('classes.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">Manage</a>
                </div>
                <div class="divide-y" style="border-color:#f8fafc;">
                    @forelse($classStats as $class)
                        <div class="flex items-center justify-between px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:28px;height:28px;background:#eff6ff;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                        <path d="M8 21h8M12 17v4"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ $class->name }}</span>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#f1f5f9;color:#475569;">
                                {{ $class->students_count }} student{{ $class->students_count !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-sm text-slate-400">No classes yet</div>
                    @endforelse
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white rounded-2xl p-5 flex flex-col gap-2" style="border:1px solid #e2e8f0;">
                <h2 class="text-sm font-bold text-slate-700 mb-1">Quick Links</h2>
                @foreach ([['route' => 'users.index', 'label' => 'Manage Users', 'bg' => '#eff6ff', 'color' => '#2563eb'], ['route' => 'classes.index', 'label' => 'Manage Classes', 'bg' => '#fef3c7', 'color' => '#d97706'], ['route' => 'subjects.index', 'label' => 'Manage Subjects', 'bg' => '#f0fdf4', 'color' => '#16a34a'], ['route' => 'exams.index', 'label' => 'Manage Exams', 'bg' => '#fdf4ff', 'color' => '#9333ea'], ['route' => 'exams.create', 'label' => 'Create Exam', 'bg' => '#fff1f2', 'color' => '#e11d48']] as $link)
                    <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition-colors" style="border:1px solid #f1f5f9;">
                        <div class="rounded-lg flex items-center justify-center flex-shrink-0" style="width:30px;height:30px;background:{{ $link['bg'] }};">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $link['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
