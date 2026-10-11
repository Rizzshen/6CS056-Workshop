<form method="POST" action="{{ $action }}">
    @csrf
    @isset($student)
        @method('PUT')
    @endisset

    <label for="name">Name</label>
    <input id="name" name="name" value="{{ old('name', $student->name ?? '') }}" required maxlength="255">
    @error('name') <p class="error">{{ $message }}</p> @enderror

    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="{{ old('email', $student->email ?? '') }}" required maxlength="255">
    @error('email') <p class="error">{{ $message }}</p> @enderror

    <div class="form-actions">
        <button type="submit">{{ isset($student) ? 'Update student' : 'Create student' }}</button>
        <a class="button secondary" href="{{ route('students.index') }}">Cancel</a>
    </div>
</form>
