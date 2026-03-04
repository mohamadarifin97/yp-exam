<header class="flex items-center justify-between px-6 py-4 bg-white flex-shrink-0" style="border-bottom:1px solid #e2e8f0;">
    <div>
        <h1 class="font-bold text-slate-800 text-lg">Dashboard</h1>
        <p class="text-xs text-slate-400 mt-0.5">{{ now()->format('l, j F Y') }}</p>
    </div>

    <div class="flex items-center gap-3">
        <!-- Search -->
        <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-100" style="width:200px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <span class="text-xs text-slate-400">Search...</span>
            <span class="ml-auto text-xs text-slate-300 bg-white px-1 rounded border border-slate-200" style="font-size:10px;">⌘K</span>
        </div>

        <!-- Notification -->
        <div class="relative flex items-center justify-center rounded-lg bg-slate-100 cursor-pointer hover:bg-slate-200 transition-colors" style="width:38px;height:38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500" style="border:2px solid white;"></span>
        </div>

        <!-- Avatar with Dropdown -->
        <div class="relative">
            <button onclick="toggleDropdown()" class="avatar-btn flex items-center gap-2 rounded-xl px-2 py-1.5 hover:bg-slate-100 transition-colors">
                <div class="flex items-center justify-center rounded-full font-bold text-white text-xs flex-shrink-0" style="width:34px;height:34px;background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}
                </div>
                <div class="text-left hidden sm:block">
                    <p class="text-sm font-semibold text-slate-700 leading-tight">
                        {{ auth()->check() ? auth()->user()->name : 'Admin User' }}
                    </p>
                    <p class="text-xs text-slate-400 leading-tight">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <!-- Dropdown -->
            <div id="avatar-dropdown" class="dropdown absolute right-0 mt-2 bg-white rounded-2xl shadow-xl z-50" style="width:230px;border:1px solid #e2e8f0;top:100%;">

                <!-- Profile header -->
                <div class="px-4 py-4" style="border-bottom:1px solid #f1f5f9;">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center rounded-full font-bold text-white text-sm flex-shrink-0" style="width:42px;height:42px;background:linear-gradient(135deg,#2563eb,#7c3aed);">
                            {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ auth()->check() ? auth()->user()->name : 'Admin User' }}
                            </p>
                            <p class="text-xs text-slate-400 truncate">
                                {{ auth()->check() ? auth()->user()->email : 'admin@example.com' }}
                            </p>
                            <span class="inline-flex items-center mt-1 text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#eff6ff;color:#2563eb;">Administrator</span>
                        </div>
                    </div>
                </div>

                <!-- Menu links -->
                <div class="p-1.5">
                    <a href="/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors text-slate-600 hover:text-slate-800 group">
                        <div class="flex items-center justify-center rounded-lg group-hover:bg-blue-100 transition-colors" style="width:30px;height:30px;background:#f1f5f9;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-blue-600">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">My Profile</p>
                        </div>
                    </a>

                    {{-- <a href="/settings" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors text-slate-600 hover:text-slate-800 group">
                        <div class="flex items-center justify-center rounded-lg group-hover:bg-blue-100 transition-colors" style="width:30px;height:30px;background:#f1f5f9;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-blue-600">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Account Settings</p>
                            <p class="text-xs text-slate-400">Preferences & security</p>
                        </div>
                    </a> --}}
                </div>

                <!-- Logout -->
                <div class="p-1.5" style="border-top:1px solid #f1f5f9;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 transition-colors group">
                            <div class="flex items-center justify-center rounded-lg group-hover:bg-red-100 transition-colors" style="width:30px;height:30px;background:#f1f5f9;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-red-500">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-red-500 group-hover:text-red-600">Log Out</p>
                                <p class="text-xs text-slate-400">End your session</p>
                            </div>
                        </button>
                    </form>
                </div>

            </div><!-- end dropdown -->
        </div>
    </div>
</header>
