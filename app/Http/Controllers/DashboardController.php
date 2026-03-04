<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Kelas;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin') {
            $totalUsers    = User::count();
            $totalStudents = User::where('role', 'student')->count();
            $totalLecturers = User::where('role', 'lecturer')->count();
            $totalClasses  = Kelas::count();
            $totalSubjects = Subject::count();
            $totalExams    = Exam::count();
            $activeExams   = Exam::where('status', true)->count();
            $totalAttempts = ExamAttempt::whereNotNull('submitted_at')->count();

            $recentUsers = User::latest()->take(5)->get();

            $recentExams = Exam::with(['subject', 'classes'])
                ->withCount('attempts')
                ->latest()
                ->take(5)
                ->get();

            $pendingMarking = Exam::whereHas('attempts.answers', function ($q) {
                $q->whereHas('question', fn($q) => $q->where('type', 'open_text'))
                    ->whereNull('marks_awarded');
            })
                ->with('subject')
                ->withCount(['attempts' => fn($q) => $q->whereNotNull('submitted_at')])
                ->get();

            $ongoingExams = Exam::with('subject')
                ->where('status', true)
                ->where('start', '<=', now())
                ->where('end', '>=', now())
                ->withCount('attempts')
                ->get();

            $subjectStats = Subject::withCount(['exams'])->orderByDesc('exams_count')->take(5)->get();

            $classStats = Kelas::withCount('students')->orderByDesc('students_count')->take(5)->get();

            return view('dashboard.dashboard', compact(
                'totalUsers',
                'totalStudents',
                'totalLecturers',
                'totalClasses',
                'totalSubjects',
                'totalExams',
                'activeExams',
                'totalAttempts',
                'recentUsers',
                'recentExams',
                'pendingMarking',
                'ongoingExams',
                'subjectStats',
                'classStats'
            ));
        } elseif ($role === 'lecturer') {
            $lecturer = auth()->user();

            $totalExams    = Exam::count();
            $activeExams   = Exam::where('status', true)->count();
            $totalStudents = User::where('role', 'student')->count();
            $totalClasses  = Kelas::count();

            // recent exams with submission counts
            $recentExams = Exam::with(['subject', 'classes'])
                ->withCount('attempts')
                ->latest()
                ->take(5)
                ->get();

            // exams with pending open text marking
            $pendingMarking = Exam::whereHas('attempts.answers', function ($q) {
                $q->whereHas('question', fn($q) => $q->where('type', 'open_text'))
                    ->whereNull('marks_awarded');
            })
                ->withCount(['attempts' => fn($q) => $q->whereNotNull('submitted_at')])
                ->with('subject')
                ->get();

            // ongoing exams right now
            $ongoingExams = Exam::with('subject')
                ->where('status', true)
                ->where('start', '<=', now())
                ->where('end', '>=', now())
                ->withCount('attempts')
                ->get();

            return view('dashboard.lecturer', compact(
                'totalExams',
                'activeExams',
                'totalStudents',
                'totalClasses',
                'recentExams',
                'pendingMarking',
                'ongoingExams'
            ));

            return view('dashboard.lecturer');
        } elseif ($role === 'student') {
            $exams = Exam::with(['subject', 'classes', 'attempts' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
                ->whereHas('classes', function ($q) use ($user) {
                    $q->where('class_exam.class_id', $user->class_id);
                })
                ->where('status', true)
                ->latest()
                ->get();

            return view('dashboard.student', compact('exams', 'role', 'user'));
        }
    }
}
