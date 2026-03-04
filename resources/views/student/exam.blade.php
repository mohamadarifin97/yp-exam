<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">

    {{-- Top bar with timer --}}
    <div class="sticky top-0 z-50 bg-white shadow-sm" style="border-bottom:1px solid #e2e8f0;">
        <div class="max-w-3xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold text-slate-800">{{ $exam->name }}</h1>
                <p class="text-xs text-slate-400">{{ $exam->subject->name }} &middot; {{ $exam->questions->count() }} questions</p>
            </div>
            <div class="flex items-center gap-3">
                <div id="timer-box" class="flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm"
                     style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span id="timer">--:--</span>
                </div>
                <button onclick="confirmSubmit()"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    Submit Exam
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-6 py-8">

        <form id="exam-form" action="{{ route('exams.submit', $attempt->id) }}" method="POST">
            @csrf

            <div class="flex flex-col gap-5">
                @foreach($exam->questions as $index => $question)
                <div class="bg-white rounded-2xl p-6" style="border:1px solid #e2e8f0;">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3">
                            <span class="flex items-center justify-center rounded-xl font-bold text-xs flex-shrink-0"
                                  style="width:28px;height:28px;background:#eff6ff;color:#2563eb;">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $question->question }}</p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0"
                              style="{{ $question->type === 'mcq' ? 'background:#eff6ff;color:#2563eb;' : 'background:#f0fdf4;color:#16a34a;' }}">
                            {{ $question->type === 'mcq' ? 'MCQ' : 'Open Text' }} &middot; {{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }}
                        </span>
                    </div>

                    @if($question->type === 'mcq')
                    <div class="flex flex-col gap-2 mt-3">
                        @foreach($question->options as $option)
                        <label class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer transition-all hover:bg-blue-50 option-label"
                               style="border:1px solid #e2e8f0;">
                            <input type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $option->id }}"
                                class="accent-blue-600 flex-shrink-0"
                                onchange="highlightOption(this)">
                            <span class="text-sm text-slate-700">{{ $option->option }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <textarea name="answers[{{ $question->id }}]"
                        rows="4"
                        placeholder="Write your answer here..."
                        class="w-full mt-3 px-4 py-3 rounded-xl text-sm text-slate-700 outline-none resize-none border-slate-200 bg-slate-50"
                        style="border-width:1px;"
                        onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                        onblur="this.style.borderColor='';this.style.boxShadow='none'"></textarea>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Bottom submit --}}
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="confirmSubmit()"
                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95"
                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Submit Exam
                </button>
            </div>
        </form>
    </div>

    {{-- Confirm submit modal --}}
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="border:1px solid #e2e8f0;">
            <div class="px-6 py-8 flex flex-col items-center text-center gap-4">
                <div class="flex items-center justify-center rounded-2xl" style="width:56px;height:56px;background:#eff6ff;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect><path d="M9 12l2 2 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Submit Exam?</h2>
                    <p class="text-sm text-slate-400 mt-1">Make sure you have answered all questions. You cannot change your answers after submitting.</p>
                </div>
                <div id="unanswered-warning" class="hidden w-full px-4 py-2.5 rounded-xl text-xs font-semibold text-amber-700" style="background:#fef3c7;">
                    ⚠ You have <span id="unanswered-count"></span> unanswered question(s).
                </div>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="closeConfirm()"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors border border-slate-200">
                    Review
                </button>
                <button onclick="doSubmit()"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    Yes, Submit
                </button>
            </div>
        </div>
    </div>

    {{-- Auto-submit modal when time is up --}}
    <div id="timeout-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         style="background:rgba(15,23,42,0.7);backdrop-filter:blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm text-center p-8" style="border:1px solid #e2e8f0;">
            <div class="flex items-center justify-center rounded-2xl mx-auto mb-4" style="width:56px;height:56px;background:#fee2e2;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h2 class="text-base font-bold text-slate-800 mb-1">Time's Up!</h2>
            <p class="text-sm text-slate-400 mb-4">Your exam is being submitted automatically...</p>
            <div class="w-8 h-8 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
        </div>
    </div>
{{-- @dd($attempt->started_at) --}}
<script>
    // ── Timer ──────────────────────────────────────────
    const duration   = {{ $exam->duration }} * 60; // seconds
    const startedAt  = new Date('{{ $started_at }}').getTime();
    const expiresAt  = startedAt + (duration * 1000);

    function updateTimer() {
        const remaining = Math.floor((expiresAt - Date.now()) / 1000);

        if (remaining <= 0) {
            document.getElementById('timer').textContent = '00:00';
            timeUp();
            return;
        }

        const m = String(Math.floor(remaining / 60)).padStart(2, '0');
        const s = String(remaining % 60).padStart(2, '0');
        document.getElementById('timer').textContent = `${m}:${s}`;

        // turn red when under 2 minutes
        if (remaining <= 120) {
            document.getElementById('timer-box').style.background = '#fee2e2';
            document.getElementById('timer-box').style.color = '#e11d48';
            document.getElementById('timer-box').style.borderColor = '#fecdd3';
        }
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);

    function timeUp() {
        clearInterval(timerInterval);
        document.getElementById('timeout-modal').classList.remove('hidden');
        document.getElementById('timeout-modal').classList.add('flex');
        setTimeout(() => document.getElementById('exam-form').submit(), 2000);
    }

    // ── Submit ─────────────────────────────────────────
    function confirmSubmit() {
        // count unanswered
        const questions = document.querySelectorAll('[name^="answers["]');
        const answered  = new Set();

        document.querySelectorAll('input[type=radio]:checked').forEach(r => {
            answered.add(r.name);
        });
        document.querySelectorAll('textarea').forEach(t => {
            if (t.value.trim()) answered.add(t.name);
        });

        const totalMcq      = document.querySelectorAll('.option-label').length > 0;
        const totalQ        = {{ $exam->questions->count() }};
        const unanswered    = totalQ - answered.size;

        if (unanswered > 0) {
            document.getElementById('unanswered-warning').classList.remove('hidden');
            document.getElementById('unanswered-count').textContent = unanswered;
        } else {
            document.getElementById('unanswered-warning').classList.add('hidden');
        }

        const m = document.getElementById('confirm-modal');
        m.classList.remove('hidden');
        m.classList.add('flex');
    }

    function closeConfirm() {
        const m = document.getElementById('confirm-modal');
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    function doSubmit() {
        clearInterval(timerInterval);
        document.getElementById('exam-form').submit();
    }

    // ── Highlight selected option ──────────────────────
    function highlightOption(radio) {
        const group = document.querySelectorAll(`input[name="${radio.name}"]`);
        group.forEach(r => {
            r.closest('label').style.background   = '';
            r.closest('label').style.borderColor  = '#e2e8f0';
        });
        radio.closest('label').style.background  = '#eff6ff';
        radio.closest('label').style.borderColor = '#2563eb';
    }
</script>
</body>
</html>