<?php

namespace StudentAdmission\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseModel extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(StudentModel::class, 'course_student', 'course_id', 'student_id')
            ->withTimestamps();
    }
}
