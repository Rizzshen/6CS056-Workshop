<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_students_can_be_listed_and_viewed(): void
    {
        $student = Student::create([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '+1 555 0100',
            'address' => '12 Analytical Engine Way',
            'date_of_birth' => '1815-12-10',
        ]);

        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('class="active"', false)
            ->assertSee('Training Institute')
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com')
            ->assertSee('+1 555 0100')
            ->assertSee('12 Analytical Engine Way')
            ->assertSee('1815-12-10')
            ->assertSee("return confirm('Delete this record?')", false);

        $this->get(route('students.show', $student))
            ->assertOk()
            ->assertSee('&copy; '.date('Y').' Training Institute', false)
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com')
            ->assertSee('+1 555 0100')
            ->assertSee('12 Analytical Engine Way')
            ->assertSee('December 10, 1815');
    }

    public function test_empty_student_list_and_root_route_render_the_student_list(): void
    {
        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('No students yet. Add one to get started.');

        $this->get('/')
            ->assertOk()
            ->assertSee('Students')
            ->assertSee('No students yet. Add one to get started.');
    }

    public function test_students_can_be_created_updated_and_deleted(): void
    {
        $this->get(route('students.create'))
            ->assertOk()
            ->assertSee('name="phone"', false)
            ->assertSee('name="address"', false)
            ->assertSee('name="date_of_birth"', false);

        $this->post(route('students.store'), [
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
            'phone' => '+1 555 0101',
            'address' => '42 Navy Lane',
            'date_of_birth' => '1906-12-09',
        ])->assertRedirect(route('students.index'))
            ->assertSessionHas('success', 'Student created successfully.');

        $student = Student::query()->where('email', 'grace@example.com')->firstOrFail();

        $this->get(route('students.edit', $student))
            ->assertOk()
            ->assertSee('value="+1 555 0101"', false)
            ->assertSee('42 Navy Lane')
            ->assertSee('value="1906-12-09"', false);

        $this->put(route('students.update', $student), [
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace.hopper@example.com',
            'phone' => '+1 555 0102',
            'address' => '84 Compiler Court',
            'date_of_birth' => '1906-12-10',
        ])->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace.hopper@example.com',
            'phone' => '+1 555 0102',
            'address' => '84 Compiler Court',
        ]);
        $this->assertSame('1906-12-10', $student->fresh()->date_of_birth->toDateString());

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_student_email_must_be_unique(): void
    {
        Student::create([
            'name' => 'First Student',
            'email' => 'same@example.com',
        ]);

        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Second Student',
                'email' => 'same@example.com',
                'phone' => '+1 555 0102',
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_empty_student_form_is_validated_by_the_server(): void
    {
        $this->get(route('students.create'))
            ->assertOk()
            ->assertDontSee('required');

        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'date_of_birth' => '',
            ])
            ->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['name', 'email', 'phone']);

        $this->assertDatabaseCount('students', 0);
    }

    public function test_student_can_keep_the_same_email_when_updated(): void
    {
        $student = Student::create([
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
            'phone' => '+1 555 0101',
        ]);

        $this->put(route('students.update', $student), [
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace@example.com',
            'phone' => '+1 555 0102',
        ])->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace@example.com',
        ]);
    }

    public function test_student_validation_returns_old_input_and_missing_students_are_not_found(): void
    {
        $this->followingRedirects()->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Retained Name',
                'email' => 'not-an-email',
                'phone' => '',
            ])
            ->assertOk()
            ->assertSee('value="Retained Name"', false)
            ->assertSee('class="error"', false);

        $this->get('/students/9999')->assertNotFound();
    }

    public function test_date_of_birth_cannot_be_in_the_future(): void
    {
        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Future Student',
                'email' => 'future@example.com',
                'phone' => '+1 555 0103',
                'date_of_birth' => now()->addDay()->toDateString(),
            ])
            ->assertSessionHasErrors('date_of_birth');
    }
}
