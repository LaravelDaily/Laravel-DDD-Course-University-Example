<?php

namespace StudentAdmission\Application\DTOs;

final class StudentDetailDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $applicationId,
        public readonly array $courses, // Array of CourseDTO
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {
    }
}
