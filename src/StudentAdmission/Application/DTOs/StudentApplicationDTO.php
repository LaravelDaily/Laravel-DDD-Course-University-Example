<?php

namespace StudentAdmission\Application\DTOs;

use DateTimeImmutable;

final class StudentApplicationDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $studentName,
        public readonly DateTimeImmutable $submittedAt,
        public readonly ?DateTimeImmutable $expiresAt,
        public readonly ?float $entryExamScore,
        public readonly ?string $notes,
        public readonly ?DateTimeImmutable $acceptedAt,
        public readonly ?DateTimeImmutable $rejectedAt,
        public readonly string $status,
        public readonly ?StudentDTO $student
    ) {
    }
}
