<form method="POST" action="{{ $action }}">
    @csrf
    @isset($course)
        @method('PUT')
    @endisset

    <label for="name">Name</label>
    <input id="name" name="name" value="{{ old('name', $course->name ?? '') }}" required maxlength="255">
    @error('name') <p class="error">{{ $message }}</p> @enderror

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4" maxlength="5000">{{ old('description', $course->description ?? '') }}</textarea>
    @error('description') <p class="error">{{ $message }}</p> @enderror

    <label for="duration_weeks">Duration (weeks)</label>
    <input id="duration_weeks" name="duration_weeks" type="number" min="1" max="65535" value="{{ old('duration_weeks', $course->duration_weeks ?? '') }}" required>
    @error('duration_weeks') <p class="error">{{ $message }}</p> @enderror

    <label for="fee">Fee</label>
    <input id="fee" name="fee" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('fee', $course->fee ?? '') }}" required>
    @error('fee') <p class="error">{{ $message }}</p> @enderror

    <label for="difficulty">Difficulty</label>
    <select id="difficulty" name="difficulty" required>
        <option value="">Choose difficulty</option>
        @foreach (\App\Enums\CourseDifficulty::cases() as $difficulty)
            <option value="{{ $difficulty->value }}" @selected(old('difficulty', isset($course) ? $course->difficulty->value : '') === $difficulty->value)>
                {{ $difficulty->value }}
            </option>
        @endforeach
    </select>
    @error('difficulty') <p class="error">{{ $message }}</p> @enderror

    <input type="hidden" name="is_active" value="0">
    <label class="checkbox-label" for="is_active">
        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $course->is_active ?? true))>
        Active
    </label>
    @error('is_active') <p class="error">{{ $message }}</p> @enderror

    <div class="form-actions">
        <button type="submit">{{ isset($course) ? 'Update course' : 'Create course' }}</button>
        <a class="button secondary" href="{{ route('courses.index') }}">Cancel</a>
    </div>
</form>
