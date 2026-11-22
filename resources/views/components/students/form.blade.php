@props(['student'])

<x-form-input name="name" label="Name" :value="$student->name" required maxlength="255" />
<x-form-input name="email" label="Email" type="email" :value="$student->email" required maxlength="255" />
<x-form-input name="phone" label="Phone" type="tel" :value="$student->phone" required maxlength="20" />
<x-form-textarea name="address" label="Address" :value="$student->address" rows="3" maxlength="500" />
<x-form-input name="date_of_birth" label="Date of birth" type="date" :value="$student->date_of_birth?->format('Y-m-d')" />
