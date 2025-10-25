<?php

namespace StudentAdmission\Domain\Events;

use DateTimeImmutable;

final class StudentApplicationAccepted
{
    public function __construct(
        public readonly int $applicationId,
        public readonly DateTimeImmutable $acceptedAt
    ) {
    }
}
