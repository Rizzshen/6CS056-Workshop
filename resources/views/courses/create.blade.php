@extends('layouts.app')

@section('title', 'Add course')

@section('content')
    <h1>Add course</h1>
    <div class="card" style="padding: 22px">
        @include('courses._form', ['action' => route('courses.store')])
    </div>
@endsection
