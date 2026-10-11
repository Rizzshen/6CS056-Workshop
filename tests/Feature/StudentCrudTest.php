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
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com')
            ->assertSee('+1 555 0100')
            ->assertSee('12 Analytical Engine Way')
            ->assertSee('1815-12-10');

        $this->get(route('students.show', $student))
            ->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com')
            ->assertSee('+1 555 0100')
            ->assertSee('12 Analytical Engine Way')
            ->assertSee('December 10, 1815');
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
        ])->assertRedirect(route('students.index'));

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
        ])->assertRedirect(route('students.index'));

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
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_date_of_birth_cannot_be_in_the_future(): void
    {
        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Future Student',
                'email' => 'future@example.com',
                'date_of_birth' => now()->addDay()->toDateString(),
            ])
            ->assertSessionHasErrors('date_of_birth');
    }
}
