<x-app-layout>{{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Exam Management</h1>
            <p class="text-sm text-slate-400 mt-0.5">Create and manage exams for your classes</p>
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
                <p class="text-2xl font-bold text-slate-800">{{ $total }}</p>
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
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Active</p>
                <p class="text-2xl font-bold text-slate-800">{{ $active }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fef3c7;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Inactive</p>
                <p class="text-2xl font-bold text-slate-800">{{ $inactive }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#fdf4ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">This Month</p>
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Exam::whereMonth('created_at', now()->month)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="mb-4 flex items-center gap-3 px-5 py-3.5 rounded-2xl text-white text-sm font-semibold" style="background:#16a34a;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
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
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Exam</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Subject</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Duration</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Period</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Classes</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                        <tr class="hover:bg-slate-50 transition-colors" style="border-bottom:1px solid #f8fafc;">
                            <td class="px-6 py-4 text-sm text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-700">{{ $exam->name }}</p>
                                @if ($exam->description)
                                    <p class="text-xs text-slate-400 mt-0.5 truncate" style="max-width:200px;">{{ $exam->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#eff6ff;color:#2563eb;">
                                    {{ $exam->subject->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $exam->duration }} min</td>
                            <td class="px-6 py-4">
                                <p class="text-xs text-slate-600 font-medium">{{ \Carbon\Carbon::parse($exam->start)->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">to {{ \Carbon\Carbon::parse($exam->end)->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($exam->classes->isEmpty())
                                    <span class="text-xs text-slate-400">—</span>
                                @else
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($exam->classes as $class)
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#f1f5f9;color:#475569;">
                                                {{ $class->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $exam->status ? 'bg-green-400' : 'bg-slate-300' }}"></span>
                                    <span class="text-sm {{ $exam->status ? 'text-green-600 font-medium' : 'text-slate-400' }}">
                                        {{ $exam->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('exams.marking', $exam) }}" class="flex items-center justify-center rounded-lg hover:bg-purple-50 transition-colors" style="width:32px;height:32px;" title="Mark Open Text">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('exams.edit', $exam) }}" class="flex items-center justify-center rounded-lg hover:bg-amber-50 transition-colors" style="width:32px;height:32px;" title="Edit">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <button onclick="openDelete({{ $exam->id }}, '{{ addslashes($exam->name) }}')" class="flex items-center justify-center rounded-lg hover:bg-red-50 transition-colors" style="width:32px;height:32px;" title="Delete">
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
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path>
                                        <rect x="9" y="3" width="6" height="4" rx="1"></rect>
                                    </svg>
                                    <p class="text-slate-400 text-sm font-medium">No exams found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4" style="border-top:1px solid #f1f5f9;">
            {{ $exams->links() }}
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
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
                    <h2 class="text-base font-bold text-slate-800">Delete Exam?</h2>
                    <p class="text-sm text-slate-400 mt-1">
                        You're about to delete <span id="delete-name" class="font-semibold text-slate-700"></span>.
                        All questions and options will also be removed.
                    </p>
                </div>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="closeModal()" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                    Cancel
                </button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-semibold text-white" style="background:#e11d48;">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDelete(id, name) {
            document.getElementById('delete-form').action = `/exams/${id}`;
            document.getElementById('delete-name').textContent = name;
            const m = document.getElementById('delete-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeModal() {
            const m = document.getElementById('delete-modal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</x-app-layout>
