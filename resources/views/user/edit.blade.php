<x-app-layout>
    <div class="max-w-lg">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-800">Edit User</h2>
            <p class="text-sm text-slate-400 mt-0.5">Update the details for {{ $user->name }}</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white rounded-2xl p-6 flex flex-col gap-4" style="border:1px solid #e2e8f0;">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Full Name</label>
                <input name="name" type="text" placeholder="e.g. John Doe" value="{{ old('name', $user->name) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none transition-all @error('name') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
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

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Address</label>
                <input name="email" type="email" placeholder="e.g. john@example.com" value="{{ old('email', $user->email) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none transition-all @error('email') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                @error('email')
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

            {{-- Role & Status --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Role</label>
                    <select name="role" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50 transition-all" style="border:1px solid #e2e8f0;">
                        <option value="">Select role</option>
                        <option {{ old('role', $user->role) === 'lecturer' ? 'selected' : '' }} value="lecturer">Lecturer</option>
                        <option {{ old('role', $user->role) === 'student' ? 'selected' : '' }} value="student">Student</option>
                        <option {{ old('role', $user->role) === 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50" style="border:1px solid #e2e8f0;">
                        <option {{ old('status', $user->status) == '1' ? 'selected' : '' }} value="1">Active</option>
                        <option {{ old('status', $user->status) == '0' ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    New Password
                    <span class="text-slate-400 font-normal">(leave blank to keep current)</span>
                </label>
                <input name="password" type="password" placeholder="Min. 8 characters" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none transition-all @error('password') border-red-400 bg-red-50 @else border-slate-200 bg-slate-50 @enderror" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                @error('password')
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

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-2" style="border-top:1px solid #f1f5f9;">
                <a href="{{ route('users.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
