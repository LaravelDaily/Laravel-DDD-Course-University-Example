<?php

namespace StudentAdmission\Domain\Repositories;

use StudentAdmission\Domain\Entities\Student;

interface StudentRepositoryInterface
{
    public function byId(int $id): ?Student;

    public function save(Student $student): void;

    public function removeByApplicationId(int $applicationId): void;
}
