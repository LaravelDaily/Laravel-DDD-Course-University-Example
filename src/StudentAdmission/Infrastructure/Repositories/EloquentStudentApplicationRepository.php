<?php

namespace StudentAdmission\Infrastructure\Repositories;

use DateTimeImmutable;
use StudentAdmission\Domain\Entities\Student;
use StudentAdmission\Domain\Entities\StudentApplication;
use StudentAdmission\Domain\Repositories\StudentApplicationRepositoryInterface;
use StudentAdmission\Infrastructure\EloquentModels\StudentApplicationModel;
use StudentAdmission\Infrastructure\EloquentModels\StudentModel;

class EloquentStudentApplicationRepository implements StudentApplicationRepositoryInterface
{
    public function byId(int $id): ?StudentApplication
    {
        $model = StudentApplicationModel::with('student')->find($id);

        if ($model === null) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function save(StudentApplication $application): void
    {
        $model = $application->id
            ? StudentApplicationModel::findOrFail($application->id)
            : new StudentApplicationModel();

        $model->fill([
            'student_name' => $application->studentName,
            'submitted_at' => $application->submittedAt,
            'expires_at' => $application->expiresAt,
            'entry_exam_score' => $application->entryExamScore,
            'notes' => $application->notes,
            'accepted_at' => $application->acceptedAt,
            'rejected_at' => $application->rejectedAt,
        ]);

        $model->save();

        // Update the application ID after first save
        $application->id = $model->id;

        // Handle student relationship
        if ($application->student !== null) {
            $studentModel = $model->student ?? new StudentModel();
            $studentModel->fill([
                'name' => $application->student->name,
                'application_id' => $model->id,
            ]);

            if ($studentModel->exists) {
                $studentModel->save();
            } else {
                $model->student()->save($studentModel);
            }

            // Update student ID
            $application->student->id = $studentModel->id;
        } elseif ($model->student !== null) {
            // Student was removed, delete the model
            $model->student->delete();
        }
    }

    private function toDomainEntity(StudentApplicationModel $model): StudentApplication
    {
        $student = null;
        if ($model->student !== null) {
            $student = new Student(
                name: $model->student->name,
                applicationId: $model->student->application_id,
                id: $model->student->id,
                courses: [] // Courses are not loaded for applications
            );
        }

        // Use reflection to create the entity with all fields
        $reflection = new \ReflectionClass(StudentApplication::class);
        $instance = $reflection->newInstanceWithoutConstructor();

        $instance->id = $model->id;
        $instance->studentName = $model->student_name;
        $instance->submittedAt = DateTimeImmutable::createFromMutable($model->submitted_at);
        $instance->expiresAt = $model->expires_at ? DateTimeImmutable::createFromMutable($model->expires_at) : null;
        $instance->entryExamScore = $model->entry_exam_score;
        $instance->notes = $model->notes;
        $instance->acceptedAt = $model->accepted_at ? DateTimeImmutable::createFromMutable($model->accepted_at) : null;
        $instance->rejectedAt = $model->rejected_at ? DateTimeImmutable::createFromMutable($model->rejected_at) : null;
        $instance->student = $student;

        return $instance;
    }
}
