<?php

namespace StudentAdmission\Application\Queries;

final readonly class GetStudentQuery
{
    public function __construct(
        public int $studentId
    ) {
    }
}
