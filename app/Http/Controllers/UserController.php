<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('user.index', [
            'users'    => $users,
            'total'    => User::count(),
            'active'   => User::where('status', true)->count(),
            'inactive' => User::where('status', false)->count(),
            'admins'   => User::where('role', 'admin')->count(),
        ]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required',
            'status'   => 'required',
            'password' => 'required|min:8',
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            flash()->success('User created successfully!');

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            flash()->error('Something went wrong!');
            return redirect()->back()->withInput();
        }
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'   => 'required|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'   => 'required',
            'status' => 'required',
            'password' => 'nullable',
        ]);

        try {
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);
            flash()->success('User updated successfully!');

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            flash()->error('Something went wrong!');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash()->success('User deleted successfully!');
        return redirect()->route('users.index');
    }
}
