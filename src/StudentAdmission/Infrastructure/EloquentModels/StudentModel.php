<?php

namespace StudentAdmission\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentModel extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'application_id',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(StudentApplicationModel::class, 'application_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(CourseModel::class, 'course_student', 'student_id', 'course_id')
            ->withTimestamps();
    }
}
