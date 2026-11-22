@props(['action'])

<form method="POST" action="{{ $action }}" class="inline-form" onsubmit="return confirm('Delete this record?')">
    @csrf
    @method('DELETE')
    <button class="danger" type="submit">Delete</button>
</form>
