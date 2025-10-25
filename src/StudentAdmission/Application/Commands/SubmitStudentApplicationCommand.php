<?php

namespace StudentAdmission\Application\Commands;

use DateTimeImmutable;

final class SubmitStudentApplicationCommand
{
    public function __construct(
        public readonly string $studentName,
        public readonly DateTimeImmutable $submittedAt,
        public readonly ?DateTimeImmutable $expiresAt = null,
        public readonly ?float $entryExamScore = null,
        public readonly ?string $notes = null
    ) {
    }
}
