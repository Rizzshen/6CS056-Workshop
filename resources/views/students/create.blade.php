<x-layouts.app title="Add student">
    <h1>Add student</h1>
    <div class="card" style="padding: 22px">
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <x-students.form :student="new \App\Models\Student()" />
            <div class="form-actions">
                <button type="submit">Create student</button>
                <a class="button secondary" href="{{ route('students.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
