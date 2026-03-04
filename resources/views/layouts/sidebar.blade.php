@php
    $role = auth()->user()->role;
@endphp

<aside id="sidebar" class="sidebar flex flex-col relative z-20 bg-white" style="width:240px; border-right:1px solid #e2e8f0; flex-shrink:0;">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5" style="border-bottom:1px solid #e2e8f0;">
        <div class="flex items-center justify-center rounded-xl flex-shrink-0" style="width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#7c3aed);">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <span id="logo-label" class="sidebar-label font-bold text-slate-800" style="font-size:16px;">YPExam</span>
    </div>

    <!-- Toggle -->
    <button onclick="toggleSidebar()" class="absolute flex items-center justify-center rounded-full bg-white hover:bg-slate-100 transition-colors shadow-sm" style="top:24px;right:-12px;width:24px;height:24px;border:1px solid #e2e8f0;z-index:30;">
        <svg id="toggle-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform 0.3s;">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>

    <!-- Section: Main -->
    <div class="px-5 pt-5 pb-1">
        <span id="label-main" class="sidebar-label text-xs font-semibold text-slate-400 uppercase tracking-widest">Main</span>
    </div>

    <nav class="flex flex-col gap-0.5 px-3 pb-2">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500">
            <svg class="flex-shrink-0 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span class="sidebar-label text-sm font-medium flex-1">
                Dashboard
            </span>
        </a>

        @if (in_array($role, ['admin', 'lecturer']))
            <a href="{{ route('exams.index') }}" class="{{ request()->routeIs('exams.*') ? 'active' : '' }} nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500">
                <svg class="flex-shrink-0 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path>
                    <rect x="9" y="3" width="6" height="4" rx="1"></rect>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
                <span class="sidebar-label text-sm font-medium flex-1">
                    Exam
                </span>
            </a>
            <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.index') ? 'active' : '' }} nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500">
                <svg class="flex-shrink-0 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                    <path d="M8 21h8M12 17v4"></path>
                </svg>
                <span class="sidebar-label text-sm font-medium flex-1">
                    Class
                </span>
            </a>
        @endif

        @if ($role == 'admin')
            <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'active' : '' }} nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500">
                <svg class="flex-shrink-0 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 0 3-3h7z"></path>
                </svg>
                <span class="sidebar-label text-sm font-medium flex-1">
                    Subject
                </span>
            </a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }} nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500">
                <svg class="flex-shrink-0 text-slate-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="sidebar-label text-sm font-medium flex-1">
                    User
                </span>
            </a>
        @endif
    </nav>

    <!-- Section: Other -->
    {{-- <div class="px-5 pt-2 pb-1">
        <span id="label-other" class="sidebar-label text-xs font-semibold text-slate-400 uppercase tracking-widest">Other</span>
    </div>
    <nav class="flex flex-col gap-0.5 px-3 pb-3">
        @foreach ($navItems2 as $item)
            @php $isActive = strtolower($item['label']) === $currentPage; @endphp
            <a href="/{{ strtolower($item['label']) }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg {{ $isActive ? 'active text-blue-600' : 'text-slate-500' }}">
                <svg class="flex-shrink-0 {{ $isActive ? 'text-blue-600' : 'text-slate-400' }}" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    {!! $icons[$item['icon']] !!}
                </svg>
                <span class="sidebar-label text-sm {{ $isActive ? 'font-semibold' : 'font-medium' }} flex-1">
                    {{ $item['label'] }}
                </span>
            </a>
        @endforeach
    </nav> --}}

    <!-- Bottom user card -->
    <div class="mt-auto p-3" style="border-top:1px solid #e2e8f0;">
        <div class="flex items-center gap-3 px-2 py-2 rounded-lg">
            <div class="flex items-center justify-center rounded-full flex-shrink-0 font-bold text-white text-xs" style="width:34px;height:34px;background:linear-gradient(135deg,#2563eb,#7c3aed);">
                {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}
            </div>
            <div class="sidebar-label flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-700 truncate">
                    {{ auth()->check() ? auth()->user()->name : 'Admin User' }}
                </p>
                <p class="text-xs text-slate-400 truncate">
                    {{ auth()->check() ? auth()->user()->email : 'admin@example.com' }}
                </p>
            </div>
        </div>
    </div>
</aside>
