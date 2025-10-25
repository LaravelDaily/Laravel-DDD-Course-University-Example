<?php

namespace StudentAdmission\Domain\Repositories;

use StudentAdmission\Domain\Entities\Course;

interface CourseRepositoryInterface
{
    public function byId(int $id): ?Course;

    public function save(Course $course): void;

    public function delete(int $id): void;

    public function all(): array;
}
