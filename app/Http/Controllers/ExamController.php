<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Kelas;
use App\Models\StudentAnswer;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function index()
    {
        $exams    = Exam::with('subject', 'classes')->latest()->paginate(10);
        $total    = Exam::count();
        $active   = Exam::where('status', true)->count();
        $inactive = Exam::where('status', false)->count();

        return view('exams.index', compact('exams', 'total', 'active', 'inactive'));
    }

    public function create()
    {
        $subjects = Subject::where('status', true)->orderBy('name')->get();
        $classes  = Kelas::orderBy('name')->get();

        return view('exams.create', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required|max:255",
            "subject_id" => "required|exists:subjects,id",
            "description" => "nullable",
            "start" => "required|date",
            "end" => "required|date|after:start",
            "duration" => "required|integer|min:1",
            "status" => "required|boolean",
            "class_ids" => "nullable|array",
            "class_ids" => "exists:classes,id",
            "questions" => "required|array|min:1",
            "questions.*.question" => "required|string",
            "questions.*.type" => "required|in:mcq,open_text",
            "questions.*.marks" => "required|integer|min:1",
            "questions.*.options" => "required_if:questions.*.type,mcq|array",
            "questions.*.options.*.option" => "required_if:questions.*.type,mcq|string",
            "questions.*.correct_option" => "required_if:questions.*.type,mcq|integer",
        ]);

        try {
            DB::beginTransaction();
            $exam = Exam::create($request->only('name', 'subject_id', 'description', 'start', 'end', 'duration', 'status'));

            $exam->classes()->sync($request->class_ids ?? []);

            foreach ($request->questions as $q) {
                $question = $exam->questions()->create([
                    'question' => $q['question'],
                    'type'     => $q['type'],
                    'marks'    => $q['marks'],
                ]);

                if ($q['type'] === 'mcq' && isset($q['options'])) {
                    foreach ($q['options'] as $idx => $opt) {
                        $question->options()->create([
                            'option'     => $opt['option'],
                            'is_correct' => isset($q['correct_option']) && (int)$q['correct_option'] === $idx,
                        ]);
                    }
                }
            }

            DB::commit();
            flash()->success('Exam created successfully!');
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            flash()->error('Something went wrong!');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Exam $exam)
    {
        $exam->load('subject', 'classes', 'questions.options');
        $subjects = Subject::where('status', true)->orderBy('name')->get();
        $classes  = Kelas::orderBy('name')->get();

        return view('exams.edit', compact('exam', 'subjects', 'classes'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'subject_id'  => 'required|exists:subjects,id',
            'description' => 'nullable',
            'start'       => 'required|date',
            'end'         => 'required|date|after:start',
            'duration'    => 'required|integer|min:1',
            'status'      => 'required|boolean',
            'class_ids'   => 'nullable|array',
            'class_ids.*' => 'exists:classes,id',
            'questions'              => 'required|array|min:1',
            'questions.*.question'   => 'required|string',
            'questions.*.type'       => 'required|in:mcq,open_text',
            'questions.*.marks'      => 'required|integer|min:1',
        ]);

        try {
            $exam->update($request->only('name', 'subject_id', 'description', 'start', 'end', 'duration', 'status'));

            $exam->classes()->sync($request->class_ids ?? []);

            // delete old questions and rebuild
            $exam->questions()->each(fn($q) => $q->options()->delete());
            $exam->questions()->delete();

            foreach ($request->questions as $q) {
                $question = $exam->questions()->create([
                    'question' => $q['question'],
                    'type'     => $q['type'],
                    'marks'    => $q['marks'],
                ]);

                if ($q['type'] === 'mcq' && isset($q['options'])) {
                    foreach ($q['options'] as $idx => $opt) {
                        $question->options()->create([
                            'option'     => $opt['option'],
                            'is_correct' => isset($q['correct_option']) && (int)$q['correct_option'] === $idx,
                        ]);
                    }
                }
            }

            flash()->success('Exam updated successfully!');
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            flash()->error('Something went wrong!');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Exam $exam)
    {
        $exam->classes()->detach();
        $exam->questions()->each(fn($q) => $q->options()->delete());
        $exam->questions()->delete();
        $exam->delete();

        flash()->success('Exam deleted successfully!');
        return redirect()->route('exams.index');
    }

    public function startExam(Exam $exam)
    {
        $student = auth()->user();

        // verify exam belongs to student's class
        $allowed = $exam->classes()->where('class_exam.class_id', $student->class_id)->exists();
        if (!$allowed) abort(403);

        // check exam window
        $now = \Carbon\Carbon::now();
        if ($now->lt($exam->start) || $now->gt($exam->end)) {
            return redirect()->route('dashboard')->with('error', 'This exam is not available right now.');
        }

        // check already submitted
        $existing = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', $student->id)
            ->whereNotNull('submitted_at')
            ->first();
        if ($existing) {
            return redirect()->route('exams.result', $existing->id);
        }

        // get or create attempt
        $attempt = ExamAttempt::firstOrCreate(
            ['exam_id' => $exam->id, 'user_id' => $student->id],
            ['started_at' => $now]
        );

        $exam->load('questions.options');
        $started_at = Carbon::parse($attempt->started_at)->toISOString();

        return view('student.exam', compact('exam', 'attempt', 'started_at'));
    }

    public function submitExam(Request $request, ExamAttempt $attempt)
    {
        $student = auth()->user();

        if ($attempt->user_id !== $student->id) abort(403);
        if ($attempt->submitted_at) {
            return redirect()->route('exams.result', $attempt->id);
        }

        $totalScore = 0;

        foreach ($attempt->exam->questions as $question) {
            $answerData = [
                'exam_attempt_id'  => $attempt->id,
                'question_id'      => $question->id,
                'selected_option_id' => null,
                'answer_text'      => null,
                'marks_awarded'    => 0,
            ];

            if ($question->type === 'mcq') {
                $selectedId = $request->input("answers.{$question->id}");
                if ($selectedId) {
                    $option = $question->options()->find($selectedId);
                    $answerData['selected_option_id'] = $selectedId;
                    if ($option && $option->is_correct) {
                        $answerData['marks_awarded'] = $question->marks;
                        $totalScore += $question->marks;
                    }
                }
            } else {
                $answerData['answer_text'] = $request->input("answers.{$question->id}");
                // open text needs manual marking, leave marks_awarded as 0
            }

            StudentAnswer::updateOrCreate(
                ['exam_attempt_id' => $attempt->id, 'question_id' => $question->id],
                $answerData
            );
        }

        $attempt->update([
            'submitted_at' => now(),
            'total_score'  => $totalScore,
        ]);

        return redirect()->route('exams.result', $attempt->id);
    }

    public function result(ExamAttempt $attempt)
    {
        $student = auth()->user();
        if ($attempt->user_id !== $student->id) abort(403);

        $attempt->load('exam.questions.options', 'answers.selectedOption');

        return view('student.result', compact('attempt'));
    }

    public function marking(Exam $exam)
    {
        $attempts = ExamAttempt::with([
                'user',
                'exam.questions',
                'answers' => function($q) {
                    $q->whereHas('question', fn($q) => $q->where('type', 'open_text'));
                },
                'answers.question'
            ])
            ->where('exam_id', $exam->id)
            ->whereNotNull('submitted_at')
            ->get();

        return view('exams.marking', compact('exam', 'attempts'));
    }

    public function saveMark(Request $request, StudentAnswer $answer)
    {
        $request->validate([
            'marks_awarded' => 'required|integer|min:0|max:' . $answer->question->marks,
        ]);

        $answer->update(['marks_awarded' => $request->marks_awarded]);

        // recalculate total score for the attempt
        $attempt = $answer->attempt;
        $total   = $attempt->answers()->sum('marks_awarded');
        $attempt->update(['total_score' => $total]);

        flash()->success('Mark saved successfully!');
        return back();
    }
}
