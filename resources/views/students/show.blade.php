@extends('students.layout')

@section('title', $student->name)

@section('content')
    <h1>Student details</h1>
    <div class="card" style="padding: 22px">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <div class="actions">
            <a class="button" href="{{ route('students.edit', $student) }}">Edit student</a>
            <a class="button secondary" href="{{ route('students.index') }}">Back to students</a>
        </div>
    </div>
@endsection
