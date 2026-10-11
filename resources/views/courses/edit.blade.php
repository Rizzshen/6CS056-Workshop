@extends('layouts.app')

@section('title', 'Edit course')

@section('content')
    <h1>Edit course</h1>
    <div class="card" style="padding: 22px">
        @include('courses._form', ['action' => route('courses.update', $course), 'course' => $course])
    </div>
@endsection
