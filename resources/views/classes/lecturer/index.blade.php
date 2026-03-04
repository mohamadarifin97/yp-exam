<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Classes</h1>
            <p class="text-sm text-slate-400 mt-0.5">View all classes and enrolled students</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                    <path d="M8 21h8M12 17v4"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Classes</p>
                <p class="text-2xl font-bold text-slate-800">{{ $total }}</p>
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
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Students</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalStudents }}</p>
            </div>
        </div>
    </div>

    {{-- Classes --}}
    <div class="flex flex-col gap-4">
        @forelse($classes as $class)
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">

                {{-- Class header --}}
                <div class="flex items-center justify-between px-6 py-4 cursor-pointer select-none" style="border-bottom:1px solid #f1f5f9;background:#fafafa;" onclick="toggleClass({{ $class->id }})">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center rounded-xl flex-shrink-0" style="width:38px;height:38px;background:#eff6ff;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                <path d="M8 21h8M12 17v4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $class->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $class->students_count }} {{ Str::plural('student', $class->students_count) }}
                                &middot;
                                {{ $class->subjects->count() }} {{ Str::plural('subject', $class->subjects->count()) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Subject badges --}}
                        <div class="flex flex-wrap gap-1">
                            @foreach ($class->subjects->take(3) as $subject)
                                @php
                                    $colors = ['#eff6ff|#2563eb', '#f0fdf4|#16a34a', '#fef3c7|#d97706', '#fdf4ff|#9333ea', '#fff1f2|#e11d48', '#ecfdf5|#059669'];
                                    $c = explode('|', $colors[$subject->id % count($colors)]);
                                @endphp
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:{{ $c[0] }};color:{{ $c[1] }};">
                                    {{ $subject->name }}
                                </span>
                            @endforeach
                            @if ($class->subjects->count() > 3)
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#f1f5f9;color:#64748b;">
                                    +{{ $class->subjects->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                        {{-- Chevron --}}
                        <svg id="chevron-{{ $class->id }}" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transition:transform 0.2s;">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </div>

                {{-- Student list (collapsible) --}}
                <div id="students-{{ $class->id }}" class="hidden">
                    @if ($class->students->isEmpty())
                        <div class="flex flex-col items-center justify-center py-10">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                            <p class="text-sm text-slate-400 font-medium">No students enrolled</p>
                        </div>
                    @else
                        <table class="w-full">
                            <thead>
                                <tr style="border-bottom:1px solid #f1f5f9;background:#fafafa;">
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Student</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($class->students as $student)
                                    @php
                                        $av = ['#eff6ff|#2563eb', '#f0fdf4|#16a34a', '#fef3c7|#d97706', '#fdf4ff|#9333ea', '#fff1f2|#e11d48'];
                                        $c = explode('|', $av[$student->id % count($av)]);
                                        $in = strtoupper(substr($student->name, 0, 1) . (strpos($student->name, ' ') ? substr($student->name, strpos($student->name, ' ') + 1, 1) : ''));
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                                        <td class="px-6 py-3.5 text-sm text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center justify-center rounded-full font-bold text-xs flex-shrink-0" style="width:32px;height:32px;background:{{ $c[0] }};color:{{ $c[1] }};">
                                                    {{ $in }}
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3.5 text-sm text-slate-400">{{ $student->email }}</td>
                                        <td class="px-6 py-3.5">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $student->status ? 'bg-green-400' : 'bg-slate-300' }}"></span>
                                                <span class="text-xs font-semibold {{ $student->status ? 'text-green-600' : 'text-slate-400' }}">
                                                    {{ $student->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3.5 text-sm text-slate-400">{{ $student->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl flex flex-col items-center justify-center py-20" style="border:1px solid #e2e8f0;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                    <path d="M8 21h8M12 17v4"></path>
                </svg>
                <p class="text-slate-400 text-sm font-medium">No classes found</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $classes->links() }}
    </div>

    <script>
        function toggleClass(id) {
            const panel = document.getElementById(`students-${id}`);
            const chevron = document.getElementById(`chevron-${id}`);
            const isOpen = !panel.classList.contains('hidden');

            panel.classList.toggle('hidden');
            chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
        }
    </script>
</x-app-layout>
