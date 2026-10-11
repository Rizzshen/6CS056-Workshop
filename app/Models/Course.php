<?php

namespace App\Models;

use App\Enums\CourseDifficulty;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_weeks',
        'fee',
        'difficulty',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => CourseDifficulty::class,
            'duration_weeks' => 'integer',
            'fee' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
