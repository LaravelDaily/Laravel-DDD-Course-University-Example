<?php

namespace StudentAdmission\Application\Queries;

final readonly class GetStudentApplicationQuery
{
    public function __construct(
        public int $applicationId
    ) {
    }
}
