@extends('layouts.app')

@section('title', 'Edit student')

@section('content')
    <h1>Edit student</h1>
    <div class="card" style="padding: 22px">
        @include('students._form', ['action' => route('students.update', $student), 'student' => $student])
    </div>
@endsection
