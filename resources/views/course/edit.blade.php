<x-layouts.app :title="'Edit course: '.$course->name">
    <h1>Edit course</h1>
    <div class="card" style="padding: 22px">
        <form method="POST" action="{{ route('courses.update', $course) }}">
            @csrf
            @method('PUT')
            <x-courses.form :course="$course" />
            <div class="form-actions">
                <button type="submit">Update course</button>
                <a class="button secondary" href="{{ route('courses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
