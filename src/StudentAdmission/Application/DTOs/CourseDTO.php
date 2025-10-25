<?php

namespace StudentAdmission\Application\DTOs;

final class CourseDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $studentCount = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
