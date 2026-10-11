@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <h1>Course details</h1>
    <div class="card" style="padding: 22px">
        <p><strong>Name:</strong> {{ $course->name }}</p>
        <p><strong>Description:</strong> {{ $course->description ?: 'Not provided' }}</p>
        <p><strong>Duration:</strong> {{ $course->duration_weeks }} weeks</p>
        <p><strong>Fee:</strong> {{ number_format((float) $course->fee, 2) }}</p>
        <p><strong>Difficulty:</strong> <span class="badge badge-{{ strtolower($course->difficulty->value) }}">{{ $course->difficulty->value }}</span></p>
        <p><strong>Status:</strong>
            <span class="badge {{ $course->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $course->is_active ? 'Active' : 'Inactive' }}
            </span>
        </p>
        <div class="actions">
            <a class="button" href="{{ route('courses.edit', $course) }}">Edit course</a>
            <a class="button secondary" href="{{ route('courses.index') }}">Back to courses</a>
        </div>
    </div>
@endsection
