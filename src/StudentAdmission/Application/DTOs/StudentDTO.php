<?php

namespace StudentAdmission\Application\DTOs;

final class StudentDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $applicationId
    ) {
    }
}
