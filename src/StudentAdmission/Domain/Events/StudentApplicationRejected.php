<?php

namespace StudentAdmission\Domain\Events;

use DateTimeImmutable;

final class StudentApplicationRejected
{
    public function __construct(
        public readonly int $applicationId,
        public readonly DateTimeImmutable $rejectedAt
    ) {
    }
}
