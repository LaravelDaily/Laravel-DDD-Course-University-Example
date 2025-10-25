<?php

namespace StudentAdmission\Application\Queries;

final readonly class GetCourseQuery
{
    public function __construct(
        public int $id
    ) {
    }
}
