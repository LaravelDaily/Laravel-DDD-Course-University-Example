<?php

namespace StudentAdmission\Infrastructure\Repositories;

use StudentAdmission\Domain\Entities\Course;
use StudentAdmission\Domain\Entities\Student;
use StudentAdmission\Domain\Repositories\StudentRepositoryInterface;
use StudentAdmission\Infrastructure\EloquentModels\StudentModel;

class EloquentStudentRepository implements StudentRepositoryInterface
{
    public function byId(int $id): ?Student
    {
        $model = StudentModel::with('courses')->find($id);

        if ($model === null) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function save(Student $student): void
    {
        $model = $student->id
            ? StudentModel::findOrFail($student->id)
            : new StudentModel();

        $model->fill([
            'name' => $student->name,
            'application_id' => $student->applicationId,
        ]);

        $model->save();

        // Update the student ID after first save
        $student->id = $model->id;

        // Sync courses
        $courseIds = array_keys($student->courses);
        $model->courses()->sync($courseIds);
    }

    public function removeByApplicationId(int $applicationId): void
    {
        StudentModel::where('application_id', $applicationId)->delete();
    }

    private function toDomainEntity(StudentModel $model): Student
    {
        $courses = $model->courses->map(fn($courseModel) => new Course(
            name: $courseModel->name,
            id: $courseModel->id
        ))->all();

        return new Student(
            name: $model->name,
            applicationId: $model->application_id,
            id: $model->id,
            courses: $courses
        );
    }
}
