<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Subject Management</h1>
            <p class="text-sm text-slate-400 mt-0.5">Manage all learning subjects</p>
        </div>
        <button onclick="openCreate()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:opacity-90 active:scale-95" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Subject
        </button>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl px-5 py-4 flex items-center gap-4" style="border:1px solid #e2e8f0;">
            <div class="rounded-xl flex items-center justify-center flex-shrink-0" style="width:40px;height:40px;background:#eff6ff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Total</p>
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
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">This Month</p>
                <p class="text-2xl font-bold text-slate-800">{{ app\Models\Subject::whereMonth('created_at', now()->month)->count() }}</p>
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

    {{-- Cards Grid --}}
    @if ($subjects->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl" style="border:1px solid #e2e8f0;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
            </svg>
            <p class="text-slate-400 text-sm font-medium">No subjects found</p>
            <button onclick="openCreate()" class="mt-4 text-sm font-semibold text-blue-600 hover:underline">Add your first subject</button>
        </div>
    @else
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach ($subjects as $subject)
                @php
                    $colors = [['bg' => '#eff6ff', 'border' => '#bfdbfe', 'icon' => '#2563eb', 'light' => '#dbeafe'], ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'icon' => '#16a34a', 'light' => '#dcfce7'], ['bg' => '#fef3c7', 'border' => '#fde68a', 'icon' => '#d97706', 'light' => '#fef9c3'], ['bg' => '#fdf4ff', 'border' => '#e9d5ff', 'icon' => '#9333ea', 'light' => '#f3e8ff'], ['bg' => '#fff1f2', 'border' => '#fecdd3', 'icon' => '#e11d48', 'light' => '#ffe4e6'], ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'icon' => '#059669', 'light' => '#d1fae5']];
                    $c = $colors[$subject->id % count($colors)];
                @endphp
                <div class="bg-white rounded-2xl p-5 flex flex-col gap-4 transition-all hover:shadow-md" style="border:1px solid #e2e8f0;">
                    {{-- Icon + status --}}
                    <div class="flex items-start justify-between">
                        <div class="flex items-center justify-center rounded-2xl" style="width:48px;height:48px;background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }};">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $c['icon'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full" style="background:{{ $subject->status ? '#f0fdf4' : '#f8fafc' }};">
                            <span class="w-1.5 h-1.5 rounded-full {{ $subject->status ? 'bg-green-400' : 'bg-slate-300' }}"></span>
                            <span class="text-xs font-semibold {{ $subject->status ? 'text-green-600' : 'text-slate-400' }}">
                                {{ $subject->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <h3 class="text-base font-bold text-slate-800">{{ $subject->name }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Added {{ $subject->created_at->format('d M Y') }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-1" style="border-top:1px solid #f1f5f9;">
                        <button onclick="openEdit({{ $subject->id }}, '{{ addslashes($subject->name) }}', {{ $subject->status ? 1 : 0 }})" class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold transition-colors hover:bg-amber-50" style="color:#d97706;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </button>
                        <div style="width:1px;height:20px;background:#e2e8f0;"></div>
                        <button onclick="openDelete({{ $subject->id }}, '{{ addslashes($subject->name) }}')" class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-semibold transition-colors hover:bg-red-50" style="color:#e11d48;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                <path d="M10 11v6M14 11v6"></path>
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="px-1 py-2">
            {{ $subjects->links() }}
        </div>
    @endif


    {{-- ── CREATE MODAL ── --}}
    <div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="border:1px solid #e2e8f0;">
            <div class="flex items-center justify-between px-6 py-5" style="border-bottom:1px solid #f1f5f9;">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Add New Subject</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Enter the subject details</p>
                </div>
                <button onclick="closeModal('create-modal')" class="flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors" style="width:32px;height:32px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="px-6 py-5 flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject Name</label>
                        <input name="name" type="text" placeholder="e.g. Mathematics" value="{{ old('name') }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none @error('name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50" style="border:1px solid #e2e8f0;">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 px-6 pb-6">
                    <button type="button" onclick="closeModal('create-modal')" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                        Create Subject
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── EDIT MODAL ── --}}
    <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="border:1px solid #e2e8f0;">
            <div class="flex items-center justify-between px-6 py-5" style="border-bottom:1px solid #f1f5f9;">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Edit Subject</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Update the subject details</p>
                </div>
                <button onclick="closeModal('edit-modal')" class="flex items-center justify-center rounded-xl hover:bg-slate-100 transition-colors" style="width:32px;height:32px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject Name</label>
                        <input id="edit-name" name="name" type="text" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                        <select id="edit-status" name="status" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50" style="border:1px solid #e2e8f0;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 px-6 pb-6">
                    <button type="button" onclick="closeModal('edit-modal')" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── DELETE MODAL ── --}}
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
                    <h2 class="text-base font-bold text-slate-800">Delete Subject?</h2>
                    <p class="text-sm text-slate-400 mt-1">
                        You're about to delete <span id="delete-name" class="font-semibold text-slate-700"></span>.
                        This cannot be undone.
                    </p>
                </div>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="closeModal('delete-modal')" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                    Cancel
                </button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90" style="background:#e11d48;">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
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

            function openEdit(id, name, status) {
                document.getElementById('edit-form').action = `/subjects/${id}`;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-status').value = status;
                openModal('edit-modal');
            }

            function openDelete(id, name) {
                document.getElementById('delete-form').action = `/subjects/${id}`;
                document.getElementById('delete-name').textContent = name;
                openModal('delete-modal');
            }

            ['create-modal', 'edit-modal', 'delete-modal'].forEach(id => {
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) closeModal(id);
                });
            });

            @if ($errors->any() && !old('_method'))
                openCreate();
            @endif
        </script>
    @endpush
</x-app-layout>
