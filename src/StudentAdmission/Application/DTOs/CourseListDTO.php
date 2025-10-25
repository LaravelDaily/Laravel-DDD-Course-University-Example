<?php

namespace StudentAdmission\Application\DTOs;

final class CourseListDTO
{
    public function __construct(
        public readonly array $courses,
        public readonly int $total,
        public readonly int $page,
        public readonly int $perPage
    ) {
    }
}
