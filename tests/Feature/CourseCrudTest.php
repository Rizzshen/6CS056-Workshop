<?php

namespace Tests\Feature;

use App\Enums\CourseDifficulty;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_courses_can_be_listed_and_viewed_with_difficulty_and_active_badges(): void
    {
        $course = Course::create([
            'name' => 'Laravel Fundamentals',
            'description' => 'Build web applications with Laravel.',
            'duration_weeks' => 8,
            'fee' => '499.99',
            'difficulty' => CourseDifficulty::Medium,
            'is_active' => true,
        ]);

        $this->get(route('courses.index'))
            ->assertOk()
            ->assertSee('Laravel Fundamentals')
            ->assertSee('499.99')
            ->assertSee('Medium')
            ->assertSee('Active');

        $this->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('Build web applications with Laravel.')
            ->assertSee('8 weeks')
            ->assertSee('Medium')
            ->assertSee('Active');
    }

    public function test_courses_can_be_created_updated_and_deleted(): void
    {
        $this->get(route('courses.create'))
            ->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="duration_weeks"', false)
            ->assertSee('name="fee"', false)
            ->assertSee('name="difficulty"', false)
            ->assertSee('name="is_active"', false);

        $this->post(route('courses.store'), [
            'name' => 'PHP Basics',
            'description' => 'Learn the fundamentals.',
            'duration_weeks' => 4,
            'fee' => '125.50',
            'difficulty' => 'Easy',
            'is_active' => '1',
        ])->assertRedirect(route('courses.index'));

        $course = Course::query()->where('name', 'PHP Basics')->firstOrFail();
        $this->assertModelExists($course);

        $this->get(route('courses.edit', $course))
            ->assertOk()
            ->assertSee('Learn the fundamentals.')
            ->assertSee('value="125.50"', false)
            ->assertSee('Easy');

        $this->put(route('courses.update', $course), [
            'name' => 'Advanced PHP',
            'description' => 'Explore advanced PHP features.',
            'duration_weeks' => 10,
            'fee' => '250.00',
            'difficulty' => 'Hard',
            'is_active' => '0',
        ])->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced PHP',
            'description' => 'Explore advanced PHP features.',
            'duration_weeks' => 10,
            'fee' => '250.00',
            'difficulty' => 'Hard',
            'is_active' => false,
        ]);

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_difficulty_must_be_one_of_the_supported_values(): void
    {
        $this->from(route('courses.create'))
            ->post(route('courses.store'), [
                'name' => 'Invalid Difficulty Course',
                'duration_weeks' => 3,
                'fee' => '0',
                'difficulty' => 'Expert',
                'is_active' => '1',
            ])
            ->assertSessionHasErrors('difficulty');

        $this->assertDatabaseMissing('courses', ['name' => 'Invalid Difficulty Course']);
    }
}
