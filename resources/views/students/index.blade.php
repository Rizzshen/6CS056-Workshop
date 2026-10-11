@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="actions" style="justify-content: space-between; margin-bottom: 18px">
        <h1>Students</h1>
        <a class="button" href="{{ route('students.create') }}">Add student</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Date of birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone ?: '—' }}</td>
                    <td>{{ $student->address ?: '—' }}</td>
                    <td>{{ $student->date_of_birth?->format('Y-m-d') ?? '—' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('students.show', $student) }}">View</a>
                            <a href="{{ route('students.edit', $student) }}">Edit</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student?')">
                                @csrf
                                @method('DELETE')
                                <button class="danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="empty" colspan="6">No students yet. Add one to get started.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
