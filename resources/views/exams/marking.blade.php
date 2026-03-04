<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('exams.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-1">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Back to Exams
            </a>
            <h1 class="text-xl font-bold text-slate-800">Mark Open Text</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $exam->name }} &middot; {{ $exam->subject->name }}</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white" style="border:1px solid #e2e8f0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
            <span class="text-sm font-semibold text-slate-700">{{ $attempts->count() }} submission{{ $attempts->count() !== 1 ? 's' : '' }}</span>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center gap-3 px-5 py-3.5 rounded-2xl text-white text-sm font-semibold" style="background:#16a34a;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($attempts->isEmpty())
        <div class="bg-white rounded-2xl flex flex-col items-center justify-center py-20" style="border:1px solid #e2e8f0;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path>
                <rect x="9" y="3" width="6" height="4" rx="1"></rect>
            </svg>
            <p class="text-slate-400 text-sm font-medium">No submissions yet</p>
        </div>
    @else
        <div class="flex flex-col gap-6">
            @foreach ($attempts as $attempt)
                @php
                    $totalMarks = $attempt->exam->questions->sum('marks');
                    $scoredSoFar = $attempt->answers->sum('marks_awarded');
                    $pendingCount = $attempt->answers->whereNull('marks_awarded')->count() + $attempt->answers->where('marks_awarded', 0)->whereNull('answer_text')->count();
                    $allMarked = $attempt->answers->every(fn($a) => $a->marks_awarded !== null);
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">

                    {{-- Student header --}}
                    <div class="flex items-center justify-between px-6 py-4" style="background:#fafafa;border-bottom:1px solid #f1f5f9;">
                        <div class="flex items-center gap-3">
                            @php
                                $av = ['#eff6ff|#2563eb', '#f0fdf4|#16a34a', '#fef3c7|#d97706', '#fdf4ff|#9333ea', '#fff1f2|#e11d48'];
                                $c = explode('|', $av[$attempt->user->id % count($av)]);
                                $in = strtoupper(substr($attempt->user->name, 0, 1) . (strpos($attempt->user->name, ' ') ? substr($attempt->user->name, strpos($attempt->user->name, ' ') + 1, 1) : ''));
                            @endphp
                            <div class="flex items-center justify-center rounded-full font-bold text-xs flex-shrink-0" style="width:36px;height:36px;background:{{ $c[0] }};color:{{ $c[1] }};">
                                {{ $in }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $attempt->user->name }}</p>
                                <p class="text-xs text-slate-400">Submitted {{ \Carbon\Carbon::parse($attempt->submitted_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Current Score</p>
                                <p class="text-base font-bold text-slate-800">{{ $scoredSoFar }} / {{ $attempt->exam->questions->sum('marks') }}</p>
                            </div>
                            @if ($allMarked)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#f0fdf4;color:#16a34a;">Fully Marked</span>
                            @else
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#fef3c7;color:#d97706;">Pending</span>
                            @endif
                        </div>
                    </div>

                    {{-- Open text answers --}}
                    <div class="divide-y" style="border-color:#f1f5f9;">
                        @foreach ($attempt->answers as $answer)
                            <div class="px-6 py-5">
                                <div class="flex items-start justify-between gap-6">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Question</p>
                                        <p class="text-sm font-semibold text-slate-700 mb-3">{{ $answer->question->question }}</p>

                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Student Answer</p>
                                        <div class="px-4 py-3 rounded-xl text-sm text-slate-700" style="background:#f8fafc;border:1px solid #e2e8f0;white-space:pre-wrap;min-height:60px;">{{ $answer->answer_text ?? '—' }}</div>
                                    </div>

                                    {{-- Mark input --}}
                                    <div class="flex-shrink-0" style="width:180px;">
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
                                            Marks
                                            <span class="text-slate-300">(max {{ $answer->question->marks }})</span>
                                        </p>
                                        <form action="{{ route('answers.mark', $answer->id) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <input type="number" name="marks_awarded" min="0" max="{{ $answer->question->marks }}" value="{{ $answer->marks_awarded }}" placeholder="0" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50 text-center font-bold" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                                            <button type="submit" class="w-full py-2 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                                                Save Mark
                                            </button>
                                        </form>
                                        @if ($answer->marks_awarded !== null)
                                            <p class="text-xs text-center mt-1.5 font-semibold" style="color:#16a34a;">
                                                Marked: {{ $answer->marks_awarded }} / {{ $answer->question->marks }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
