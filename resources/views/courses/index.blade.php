@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="actions" style="justify-content: space-between; margin-bottom: 18px">
        <h1>Courses</h1>
        <a class="button" href="{{ route('courses.create') }}">Add course</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Fee</th>
                <th>Difficulty</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->duration_weeks }} weeks</td>
                    <td>{{ number_format((float) $course->fee, 2) }}</td>
                    <td><span class="badge badge-{{ strtolower($course->difficulty->value) }}">{{ $course->difficulty->value }}</span></td>
                    <td>
                        <span class="badge {{ $course->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('courses.show', $course) }}">View</a>
                            <a href="{{ route('courses.edit', $course) }}">Edit</a>
                            <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Delete this course?')">
                                @csrf
                                @method('DELETE')
                                <button class="danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="empty" colspan="6">No courses yet. Add one to get started.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
