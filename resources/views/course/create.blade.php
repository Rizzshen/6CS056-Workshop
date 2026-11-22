<x-layouts.app title="Add course">
    <h1>Add course</h1>
    <div class="card" style="padding: 22px">
        <form method="POST" action="{{ route('courses.store') }}">
            @csrf
            <x-courses.form :course="new \App\Models\Course(['is_active' => true])" />
            <div class="form-actions">
                <button type="submit">Create course</button>
                <a class="button secondary" href="{{ route('courses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
