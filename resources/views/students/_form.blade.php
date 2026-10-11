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

    <label for="phone">Phone</label>
    <input id="phone" name="phone" type="tel" value="{{ old('phone', $student->phone ?? '') }}" maxlength="30">
    @error('phone') <p class="error">{{ $message }}</p> @enderror

    <label for="address">Address</label>
    <textarea id="address" name="address" rows="3" maxlength="2000">{{ old('address', $student->address ?? '') }}</textarea>
    @error('address') <p class="error">{{ $message }}</p> @enderror

    <label for="date_of_birth">Date of birth</label>
    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', isset($student) ? $student->date_of_birth?->format('Y-m-d') : '') }}" max="{{ now()->toDateString() }}">
    @error('date_of_birth') <p class="error">{{ $message }}</p> @enderror

    <div class="form-actions">
        <button type="submit">{{ isset($student) ? 'Update student' : 'Create student' }}</button>
        <a class="button secondary" href="{{ route('students.index') }}">Cancel</a>
    </div>
</form>
