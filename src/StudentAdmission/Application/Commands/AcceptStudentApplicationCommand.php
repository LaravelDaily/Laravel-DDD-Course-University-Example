<?php

namespace StudentAdmission\Application\Commands;

use DateTimeImmutable;

final class AcceptStudentApplicationCommand
{
    public function __construct(
        public readonly int $applicationId,
        public readonly DateTimeImmutable $acceptedAt
    ) {
    }
}
