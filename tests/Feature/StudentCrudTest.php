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
        ]);

        $this->get(route('students.index'))
            ->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com');

        $this->get(route('students.show', $student))
            ->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('ada@example.com');
    }

    public function test_students_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('students.store'), [
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
        ])->assertRedirect(route('students.index'));

        $student = Student::query()->where('email', 'grace@example.com')->firstOrFail();

        $this->put(route('students.update', $student), [
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace.hopper@example.com',
        ])->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Grace Brewster Hopper',
            'email' => 'grace.hopper@example.com',
        ]);

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
}
