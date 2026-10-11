@extends('students.layout')

@section('title', 'Add student')

@section('content')
    <h1>Add student</h1>
    <div class="card" style="padding: 22px">
        @include('students._form', ['action' => route('students.store')])
    </div>
@endsection
