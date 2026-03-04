<x-app-layout>
{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800">Class Management</h1>
        <p class="text-sm text-slate-400 mt-0.5">Manage student learning classes</p>
    </div>
    <button onclick="openCreate()"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:opacity-90 active:scale-95"
        style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Add Class
    </button>
</div>

{{-- Stat --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
        <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8M12 17v4"></path>
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total Classes</p>
            <p class="text-2xl font-bold text-slate-800">{{ $total }}</p>
        </div>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="mb-4 flex items-center gap-3 px-5 py-3.5 rounded-2xl text-white text-sm font-semibold" style="background:#16a34a;">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
    {{ session('success') }}
</div>
@endif

{{-- Table --}}
<div class="bg-white rounded-2xl" style="border:1px solid #e2e8f0;">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid #f1f5f9;background:#fafafa;">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Class Name</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Students</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Subjects</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Created</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                    <td class="px-6 py-4 text-sm text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center rounded-xl flex-shrink-0" style="width:36px;height:36px;background:#eff6ff;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8M12 17v4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ $class->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm font-semibold text-slate-700">{{ $class->students_count }}</span>
                            <span class="text-xs text-slate-400">{{ Str::plural('student', $class->students_count) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($class->subjects->isEmpty())
                            <span class="text-xs text-slate-400">—</span>
                        @else
                            <div class="flex flex-wrap gap-1">
                                @foreach($class->subjects as $subject)
                                @php
                                    $colors = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48','#ecfdf5|#059669'];
                                    $c = explode('|', $colors[$subject->id % count($colors)]);
                                @endphp
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                                      style="background:{{ $c[0] }};color:{{ $c[1] }};">
                                    {{ $subject->name }}
                                </span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-400">{{ $class->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <button onclick="openEdit({{ $class->id }}, '{{ addslashes($class->name) }}', {{ json_encode($class->students->pluck('id')) }}, {{ json_encode($class->subjects->pluck('id')) }})"
                                class="flex items-center justify-center rounded-lg hover:bg-amber-50 transition-colors" style="width:32px;height:32px;" title="Edit">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            <button onclick="openDelete({{ $class->id }}, '{{ addslashes($class->name) }}')"
                                class="flex items-center justify-center rounded-lg hover:bg-red-50 transition-colors" style="width:32px;height:32px;" title="Delete">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6M14 11v6"></path>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8M12 17v4"></path>
                            </svg>
                            <p class="text-slate-400 text-sm font-medium">No classes found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4" style="border-top:1px solid #f1f5f9;">
        {{ $classes->links() }}
    </div>
</div>


{{-- ══════════════════════════════════════ --}}
{{-- CREATE MODAL                          --}}
{{-- ══════════════════════════════════════ --}}
<div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" style="border:1px solid #e2e8f0;max-height:90vh;overflow-y:auto;">
        <div class="flex items-center justify-between px-6 py-5" style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-800">Add New Class</h2>
                <p class="text-xs text-slate-400 mt-0.5">Enter class details and assign students & subjects</p>
            </div>
            <button onclick="closeModal('create-modal')" class="flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors flex-shrink-0" style="width:32px;height:32px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="px-6 py-5 flex flex-col gap-5">

                {{-- Class Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class Name</label>
                    <input name="name" type="text" placeholder="e.g. Form 1 Bestari" value="{{ old('name') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none @error('name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror"
                        style="border-width:1px;"
                        onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                        onblur="this.style.borderColor='';this.style.boxShadow='none'">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Students --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Enroll Students
                        <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" placeholder="Search students..."
                        oninput="filterList(this, 'create-student-list')"
                        class="w-full px-3 py-2 rounded-xl text-sm text-slate-600 outline-none mb-2 bg-slate-50"
                        style="border:1px solid #e2e8f0;">
                    <div id="create-student-list" class="flex flex-col gap-1 overflow-y-auto rounded-xl p-2"
                         style="max-height:160px;border:1px solid #e2e8f0;background:#fafafa;">
                        @forelse($students as $student)
                        @php
                            $av = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48'];
                            $c  = explode('|', $av[$student->id % count($av)]);
                            $in = strtoupper(substr($student->name,0,1).(strpos($student->name,' ') ? substr($student->name,strpos($student->name,' ')+1,1) : ''));
                        @endphp
                        <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                class="w-4 h-4 rounded accent-blue-600"
                                onchange="updateCount('create-student-list', 'create-student-count')">
                            <div class="flex items-center justify-center rounded-full font-bold flex-shrink-0"
                                 style="width:28px;height:28px;font-size:10px;background:{{ $c[0] }};color:{{ $c[1] }};">
                                {{ $in }}
                            </div>
                            <span class="text-sm text-slate-700 truncate list-name">{{ $student->name }}</span>
                        </label>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-4">No unassigned students available</p>
                        @endforelse
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5"><span id="create-student-count">0</span> students selected</p>
                </div>

                {{-- Subjects --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Assign Subjects
                        <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" placeholder="Search subjects..."
                        oninput="filterList(this, 'create-subject-list')"
                        class="w-full px-3 py-2 rounded-xl text-sm text-slate-600 outline-none mb-2 bg-slate-50"
                        style="border:1px solid #e2e8f0;">
                    <div id="create-subject-list" class="flex flex-col gap-1 overflow-y-auto rounded-xl p-2"
                         style="max-height:160px;border:1px solid #e2e8f0;background:#fafafa;">
                        @forelse($subjects as $subject)
                        @php
                            $colors = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48','#ecfdf5|#059669'];
                            $c = explode('|', $colors[$subject->id % count($colors)]);
                        @endphp
                        <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                class="w-4 h-4 rounded accent-blue-600"
                                onchange="updateCount('create-subject-list', 'create-subject-count')">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $c[1] }};"></span>
                            <span class="text-sm text-slate-700 truncate list-name">{{ $subject->name }}</span>
                        </label>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-4">No active subjects available</p>
                        @endforelse
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5"><span id="create-subject-count">0</span> subjects selected</p>
                </div>

            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeModal('create-modal')"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    Create Class
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════ --}}
{{-- EDIT MODAL                            --}}
{{-- ══════════════════════════════════════ --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" style="border:1px solid #e2e8f0;max-height:90vh;overflow-y:auto;">
        <div class="flex items-center justify-between px-6 py-5" style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-800">Edit Class</h2>
                <p class="text-xs text-slate-400 mt-0.5">Update class details, students & subjects</p>
            </div>
            <button onclick="closeModal('edit-modal')" class="flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors flex-shrink-0" style="width:32px;height:32px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="px-6 py-5 flex flex-col gap-5">

                {{-- Class Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class Name</label>
                    <input id="edit-name" name="name" type="text"
                        class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50"
                        style="border-width:1px;"
                        onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                        onblur="this.style.borderColor='';this.style.boxShadow='none'">
                </div>

                {{-- Students --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Enroll Students
                        <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" placeholder="Search students..."
                        oninput="filterList(this, 'edit-student-list')"
                        class="w-full px-3 py-2 rounded-xl text-sm text-slate-600 outline-none mb-2 bg-slate-50"
                        style="border:1px solid #e2e8f0;">
                    <div id="edit-student-list" class="flex flex-col gap-1 overflow-y-auto rounded-xl p-2"
                         style="max-height:160px;border:1px solid #e2e8f0;background:#fafafa;">
                        @forelse($allStudents as $student)
                        @php
                            $av = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48'];
                            $c  = explode('|', $av[$student->id % count($av)]);
                            $in = strtoupper(substr($student->name,0,1).(strpos($student->name,' ') ? substr($student->name,strpos($student->name,' ')+1,1) : ''));
                            $takenByOther = $student->class_id !== null;
                        @endphp
                        <label class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                            {{ $takenByOther ? 'opacity-40 cursor-not-allowed' : 'hover:bg-blue-50 cursor-pointer' }}">
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                class="w-4 h-4 rounded accent-blue-600"
                                {{ $takenByOther ? 'disabled' : '' }}
                                onchange="updateCount('edit-student-list', 'edit-student-count')">
                            <div class="flex items-center justify-center rounded-full font-bold flex-shrink-0"
                                 style="width:28px;height:28px;font-size:10px;background:{{ $c[0] }};color:{{ $c[1] }};">
                                {{ $in }}
                            </div>
                            <div class="min-w-0">
                                <span class="text-sm text-slate-700 truncate list-name block">{{ $student->name }}</span>
                                @if($takenByOther)
                                    <span class="text-xs text-slate-400">Enrolled in another class</span>
                                @endif
                            </div>
                        </label>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-4">No students found</p>
                        @endforelse
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5"><span id="edit-student-count">0</span> students selected</p>
                </div>

                {{-- Subjects --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Assign Subjects
                        <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" placeholder="Search subjects..."
                        oninput="filterList(this, 'edit-subject-list')"
                        class="w-full px-3 py-2 rounded-xl text-sm text-slate-600 outline-none mb-2 bg-slate-50"
                        style="border:1px solid #e2e8f0;">
                    <div id="edit-subject-list" class="flex flex-col gap-1 overflow-y-auto rounded-xl p-2"
                         style="max-height:160px;border:1px solid #e2e8f0;background:#fafafa;">
                        @forelse($subjects as $subject)
                        @php
                            $colors = ['#eff6ff|#2563eb','#f0fdf4|#16a34a','#fef3c7|#d97706','#fdf4ff|#9333ea','#fff1f2|#e11d48','#ecfdf5|#059669'];
                            $c = explode('|', $colors[$subject->id % count($colors)]);
                        @endphp
                        <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                class="w-4 h-4 rounded accent-blue-600"
                                onchange="updateCount('edit-subject-list', 'edit-subject-count')">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $c[1] }};"></span>
                            <span class="text-sm text-slate-700 truncate list-name">{{ $subject->name }}</span>
                        </label>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-4">No active subjects available</p>
                        @endforelse
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5"><span id="edit-subject-count">0</span> subjects selected</p>
                </div>

            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeModal('edit-modal')"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════ --}}
{{-- DELETE MODAL                          --}}
{{-- ══════════════════════════════════════ --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="border:1px solid #e2e8f0;">
        <div class="px-6 py-8 flex flex-col items-center text-center gap-4">
            <div class="flex items-center justify-center rounded-2xl" style="width:56px;height:56px;background:#fee2e2;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                    <path d="M10 11v6M14 11v6"></path>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800">Delete Class?</h2>
                <p class="text-sm text-slate-400 mt-1">
                    You're about to delete <span id="delete-name" class="font-semibold text-slate-700"></span>.
                    This cannot be undone.
                </p>
            </div>
        </div>
        <div class="flex gap-3 px-6 pb-6">
            <button onclick="closeModal('delete-modal')"
                class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                Cancel
            </button>
            <form id="delete-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background:#e11d48;">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    function openModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
    }

    function closeModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    function openCreate() {
        openModal('create-modal');
    }

    function openEdit(id, name, enrolledIds, subjectIds) {
        document.getElementById('edit-form').action = `/classes/${id}`;
        document.getElementById('edit-name').value  = name;

        // students — re-enable those belonging to this class, disable others with a class
        document.querySelectorAll('#edit-student-list input[type=checkbox]').forEach(cb => {
            const isEnrolledHere = enrolledIds.includes(parseInt(cb.value));
            if (isEnrolledHere) {
                cb.disabled = false;
                cb.closest('label').classList.remove('opacity-40', 'cursor-not-allowed');
                cb.closest('label').classList.add('hover:bg-blue-50', 'cursor-pointer');
            }
            cb.checked = isEnrolledHere;
        });

        // subjects
        document.querySelectorAll('#edit-subject-list input[type=checkbox]').forEach(cb => {
            cb.checked = subjectIds.includes(parseInt(cb.value));
        });

        updateCount('edit-student-list', 'edit-student-count');
        updateCount('edit-subject-list', 'edit-subject-count');
        openModal('edit-modal');
    }

    function openDelete(id, name) {
        document.getElementById('delete-form').action = `/classes/${id}`;
        document.getElementById('delete-name').textContent = name;
        openModal('delete-modal');
    }

    function filterList(input, listId) {
        const q = input.value.toLowerCase();
        document.querySelectorAll(`#${listId} label`).forEach(label => {
            const name = label.querySelector('.list-name');
            if (name) label.style.display = name.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    function updateCount(listId, countId) {
        const count = document.querySelectorAll(`#${listId} input:checked`).length;
        document.getElementById(countId).textContent = count;
    }

    // close on backdrop click
    ['create-modal', 'edit-modal', 'delete-modal'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });

    @if($errors->any() && !old('_method'))
        openCreate();
    @endif
</script>
</x-app-layout>
