<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\User::where('role', 'trainee')->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%");
            });
        }
        
        $trainees = $query->paginate(15)->withQueryString();
        return view('admin.trainees.index', compact('trainees'));
    }

    public function create()
    {
        return view('admin.trainees.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'domain' => 'nullable|string|max:255',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'trainee',
            'domain' => $request->domain,
        ]);

        return redirect()->route('admin.trainees.index')->with('success', 'Trainee added successfully.');
    }

    public function edit(\App\Models\User $trainee)
    {
        return view('admin.trainees.edit', compact('trainee'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\User $trainee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $trainee->id,
            'domain' => 'nullable|string|max:255',
        ]);

        $trainee->update([
            'name' => $request->name,
            'email' => $request->email,
            'domain' => $request->domain,
        ]);

        if ($request->password) {
            $trainee->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return redirect()->route('admin.trainees.index')->with('success', 'Trainee updated successfully.');
    }

    public function destroy(\App\Models\User $trainee)
    {
        $trainee->delete();
        return redirect()->route('admin.trainees.index')->with('success', 'Trainee deleted successfully.');
    }
}
