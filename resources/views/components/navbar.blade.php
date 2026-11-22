<nav class="navbar" aria-label="Main navigation">
    <a href="{{ route('students.index') }}">Training Institute</a>
    <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
    <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Courses</a>
</nav>
