<?php

namespace StudentAdmission\Application\DTOs;

final class StudentListDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $applicationId,
        public readonly int $courseCount,
        public readonly string $createdAt
    ) {
    }
}
