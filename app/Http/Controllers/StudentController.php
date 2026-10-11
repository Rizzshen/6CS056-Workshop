<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('students.index', [
            'students' => Student::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('status', 'Student created successfully.');
    }

    public function show(Student $student): View
    {
        return view('students.show', [
            'student' => $student,
        ]);
    }

    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,'.$student->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:2000'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('status', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('status', 'Student deleted successfully.');
    }
}
