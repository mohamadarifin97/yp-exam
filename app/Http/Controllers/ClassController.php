<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'lecturer') {
            $classes = Kelas::with(['students', 'subjects'])
                ->withCount('students')
                ->orderBy('name')
                ->paginate(10);

            $total        = Kelas::count();
            $totalStudents = User::where('role', 'student')->count();

            return view('classes.lecturer.index', compact('classes', 'total', 'totalStudents'));
        }
        if ($user->role == 'admin') {
            $classes  = Kelas::with('students')->withCount('students')->latest()->paginate(10);
            $total    = Kelas::count();
            $students = User::where('role', 'student')->orderBy('name')->get();
            $allStudents = User::where('role', 'student')->orderBy('name')->get();
            $subjects = Subject::where('status', true)->orderBy('name')->get();
            return view('classes.index', compact('classes', 'total', 'students', 'allStudents', 'subjects'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:classes,name',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $class = Kelas::create($request->only('name'));
        User::whereIn('id', $request->student_ids ?? [])->update(['class_id' => $class->id]);
        $class->subjects()->sync($request->subject_ids ?? []);

        flash()->success('Class created successfully!');
        return redirect()->route('classes.index');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:classes,name,' . $kelas->id,
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $kelas->update($request->only('name'));
        User::where('class_id', $kelas->id)->update(['class_id' => null]);
        User::whereIn('id', $request->student_ids ?? [])->update(['class_id' => $kelas->id]);
        $kelas->subjects()->sync($request->subject_ids ?? []);

        flash()->success('Class updated successfully!');
        return redirect()->route('classes.index');
    }

    public function destroy($kelas)
    {
        $kelas = Kelas::findOrFail($kelas);
        $kelas->subjects()->detach();
        $kelas->students()->update(['class_id' => null]);
        $kelas->delete();

        flash()->success('Class deleted successfully!');
        return redirect()->route('classes.index');
    }
}
