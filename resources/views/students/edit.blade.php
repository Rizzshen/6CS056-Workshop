<x-layouts.app :title="'Edit student: '.$student->name">
    <h1>Edit student</h1>
    <div class="card" style="padding: 22px">
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')
            <x-students.form :student="$student" />
            <div class="form-actions">
                <button type="submit">Update student</button>
                <a class="button secondary" href="{{ route('students.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
