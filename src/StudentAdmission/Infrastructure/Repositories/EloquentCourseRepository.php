<?php

namespace StudentAdmission\Infrastructure\Repositories;

use StudentAdmission\Domain\Entities\Course;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;
use StudentAdmission\Infrastructure\EloquentModels\CourseModel;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function byId(int $id): ?Course
    {
        $model = CourseModel::find($id);

        if ($model === null) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function save(Course $course): void
    {
        $model = $course->id
            ? CourseModel::findOrFail($course->id)
            : new CourseModel();

        $model->fill([
            'name' => $course->name,
        ]);

        $model->save();

        // Update the course ID after first save
        $course->id = $model->id;
    }

    public function delete(int $id): void
    {
        $model = CourseModel::findOrFail($id);
        $model->delete();
    }

    public function all(): array
    {
        $models = CourseModel::withCount('students')
            ->latest()
            ->get();

        return $models->map(fn($model) => $this->toDomainEntity($model))->all();
    }

    private function toDomainEntity(CourseModel $model): Course
    {
        return new Course(
            name: $model->name,
            id: $model->id
        );
    }
}
