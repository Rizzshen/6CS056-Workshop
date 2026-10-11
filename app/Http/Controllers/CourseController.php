<?php

namespace App\Http\Controllers;

use App\Enums\CourseDifficulty;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('courses.index', [
            'courses' => Course::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('courses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration_weeks' => ['required', 'integer', 'min:1', 'max:65535'],
            'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'difficulty' => ['required', Rule::enum(CourseDifficulty::class)],
            'is_active' => ['required', 'boolean'],
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('status', 'Course created successfully.');
    }

    public function show(Course $course): View
    {
        return view('courses.show', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course): View
    {
        return view('courses.edit', [
            'course' => $course,
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration_weeks' => ['required', 'integer', 'min:1', 'max:65535'],
            'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'difficulty' => ['required', Rule::enum(CourseDifficulty::class)],
            'is_active' => ['required', 'boolean'],
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('status', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('status', 'Course deleted successfully.');
    }
}
