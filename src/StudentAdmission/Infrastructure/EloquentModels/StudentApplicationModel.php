<?php

namespace StudentAdmission\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentApplicationModel extends Model
{
    protected $table = 'student_applications';

    protected $fillable = [
        'student_name',
        'submitted_at',
        'expires_at',
        'entry_exam_score',
        'notes',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'entry_exam_score' => 'float',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(StudentModel::class, 'application_id');
    }
}
