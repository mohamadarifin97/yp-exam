<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">

    <div class="max-w-3xl mx-auto px-6 py-10">

        {{-- Back --}}
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 mb-6 font-medium">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back to Dashboard
        </a>

        {{-- Score card --}}
        @php
            $exam        = $attempt->exam;
            $totalMarks  = $exam->questions->sum('marks');
            $scored      = $attempt->total_score ?? 0;
            $percent     = $totalMarks > 0 ? round(($scored / $totalMarks) * 100) : 0;
            $hasOpenText = $exam->questions->where('type', 'open_text')->count() > 0;
            $grade = match(true) {
                $percent >= 90 => ['label' => 'A+', 'bg' => '#f0fdf4', 'color' => '#16a34a'],
                $percent >= 80 => ['label' => 'A',  'bg' => '#f0fdf4', 'color' => '#16a34a'],
                $percent >= 70 => ['label' => 'B',  'bg' => '#eff6ff', 'color' => '#2563eb'],
                $percent >= 60 => ['label' => 'C',  'bg' => '#fef3c7', 'color' => '#d97706'],
                $percent >= 50 => ['label' => 'D',  'bg' => '#fef3c7', 'color' => '#d97706'],
                default        => ['label' => 'F',  'bg' => '#fee2e2', 'color' => '#e11d48'],
            };
        @endphp

        <div class="bg-white rounded-2xl p-8 mb-6 text-center" style="border:1px solid #e2e8f0;">
            <div class="inline-flex items-center justify-center rounded-2xl font-extrabold mb-4"
                 style="width:72px;height:72px;font-size:28px;background:{{ $grade['bg'] }};color:{{ $grade['color'] }};">
                {{ $grade['label'] }}
            </div>
            <h1 class="text-xl font-bold text-slate-800 mb-1">{{ $exam->name }}</h1>
            <p class="text-sm text-slate-400 mb-6">{{ $exam->subject->name }}</p>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="rounded-2xl p-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Score</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $scored }}<span class="text-sm text-slate-400 font-normal">/{{ $totalMarks }}</span></p>
                </div>
                <div class="rounded-2xl p-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Percentage</p>
                    <p class="text-2xl font-bold" style="color:{{ $grade['color'] }};">{{ $percent }}%</p>
                </div>
                <div class="rounded-2xl p-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Submitted</p>
                    <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('d M, H:i') }}</p>
                </div>
            </div>

            @if($hasOpenText)
            <div class="flex items-center gap-2 px-4 py-3 rounded-xl text-xs font-semibold text-amber-700 mt-2" style="background:#fef3c7;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                Open text questions are pending manual marking. Your final score may change.
            </div>
            @endif
        </div>

        {{-- Answer review --}}
        <div class="flex flex-col gap-4">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide">Answer Review</h2>

            @foreach($exam->questions as $index => $question)
            @php
                $answer = $attempt->answers->where('question_id', $question->id)->first();
            @endphp
            <div class="bg-white rounded-2xl p-6" style="border:1px solid #e2e8f0;">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-start gap-3">
                        <span class="flex items-center justify-center rounded-xl font-bold text-xs flex-shrink-0"
                              style="width:28px;height:28px;background:#eff6ff;color:#2563eb;">
                            {{ $index + 1 }}
                        </span>
                        <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $question->question }}</p>
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        @if($question->type === 'mcq')
                            @if($answer && $answer->marks_awarded > 0)
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#f0fdf4;color:#16a34a;">
                                    +{{ $answer->marks_awarded }} / {{ $question->marks }}
                                </span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#fee2e2;color:#e11d48;">
                                    0 / {{ $question->marks }}
                                </span>
                            @endif
                        @else
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#fef3c7;color:#d97706;">
                                Pending / {{ $question->marks }}
                            </span>
                        @endif
                    </div>
                </div>

                @if($question->type === 'mcq')
                <div class="flex flex-col gap-2">
                    @foreach($question->options as $option)
                    @php
                        $isSelected = $answer && $answer->selected_option_id == $option->id;
                        $isCorrect  = $option->is_correct;
                    @endphp
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl"
                         style="border:1px solid {{ $isCorrect ? '#bbf7d0' : ($isSelected && !$isCorrect ? '#fecdd3' : '#e2e8f0') }};
                                background:{{ $isCorrect ? '#f0fdf4' : ($isSelected && !$isCorrect ? '#fff1f2' : '#fafafa') }};">
                        <span class="flex-shrink-0">
                            @if($isCorrect)
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            @elseif($isSelected && !$isCorrect)
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            @else
                                <span class="w-3.5 h-3.5 rounded-full inline-block" style="border:1.5px solid #cbd5e1;"></span>
                            @endif
                        </span>
                        <span class="text-sm {{ $isCorrect ? 'text-green-700 font-semibold' : ($isSelected && !$isCorrect ? 'text-red-600 font-semibold' : 'text-slate-600') }}">
                            {{ $option->option }}
                        </span>
                        @if($isSelected && !$isCorrect)
                            <span class="ml-auto text-xs text-red-400 font-medium">Your answer</span>
                        @elseif($isSelected && $isCorrect)
                            <span class="ml-auto text-xs text-green-600 font-medium">Your answer ✓</span>
                        @endif
                    </div>
                    @endforeach
                </div>

                @else
                <div class="mt-2">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">Your Answer</p>
                    <div class="px-4 py-3 rounded-xl text-sm text-slate-700" style="background:#f8fafc;border:1px solid #e2e8f0;white-space:pre-wrap;">{{ $answer->answer_text ?? '—' }}</div>
                    @if($answer && $answer->marks_awarded !== null && $answer->marks_awarded > 0)
                    <p class="text-xs text-green-600 font-semibold mt-1.5">Marks awarded: {{ $answer->marks_awarded }} / {{ $question->marks }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</body>
</html>