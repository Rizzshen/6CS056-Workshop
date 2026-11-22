@props(['course'])

<x-form-input name="name" label="Name" :value="$course->name" required maxlength="255" />
<x-form-textarea name="description" label="Description" :value="$course->description" rows="4" maxlength="5000" />
<x-form-input name="duration_weeks" label="Duration (weeks)" type="number" :value="$course->duration_weeks" required min="1" max="65535" />
<x-form-input name="fee" label="Fee" type="number" :value="$course->fee" required step="0.01" min="0" />

<label for="difficulty">Difficulty</label>
<select id="difficulty" name="difficulty" required>
    <option value="">Choose difficulty</option>
    @foreach (['Easy', 'Medium', 'Hard'] as $level)
        <option value="{{ $level }}" @selected(old('difficulty', $course->difficulty?->value ?? $course->difficulty) === $level)>
            {{ $level }}
        </option>
    @endforeach
</select>
@error('difficulty')
    <p class="error">{{ $message }}</p>
@enderror

<input type="hidden" name="is_active" value="0">
<label class="checkbox-label" for="is_active">
    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $course->is_active))>
    Active
</label>
@error('is_active')
    <p class="error">{{ $message }}</p>
@enderror
