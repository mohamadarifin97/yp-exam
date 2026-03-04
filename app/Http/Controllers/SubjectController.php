<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(12);
        $total    = Subject::count();
        $active   = Subject::where('status', true)->count();
        $inactive = Subject::where('status', false)->count();
        return view('subjects.index', compact('subjects', 'total', 'active', 'inactive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|max:255|unique:subjects,name',
            'status' => 'required|boolean',
        ]);

        Subject::create($request->only('name', 'status'));
        flash()->success('Subject created successfully!');
        return redirect()->route('subjects.index');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name'   => 'required|max:255|unique:subjects,name,' . $subject->id,
            'status' => 'required|boolean',
        ]);

        $subject->update($request->only('name', 'status'));
        flash()->success('Subject updated successfully!');
        return redirect()->route('subjects.index');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        flash()->success('Subject deleted successfully!');
        return redirect()->route('subjects.index');
    }
}
