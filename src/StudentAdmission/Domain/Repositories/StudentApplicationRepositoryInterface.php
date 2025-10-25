<?php

namespace StudentAdmission\Domain\Repositories;

use StudentAdmission\Domain\Entities\StudentApplication;

interface StudentApplicationRepositoryInterface
{
    public function byId(int $id): ?StudentApplication;

    public function save(StudentApplication $application): void;
}
