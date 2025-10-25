<?php

namespace StudentAdmission\Application\Commands;

use DateTimeImmutable;

final class RejectStudentApplicationCommand
{
    public function __construct(
        public readonly int $applicationId,
        public readonly DateTimeImmutable $rejectedAt
    ) {
    }
}
