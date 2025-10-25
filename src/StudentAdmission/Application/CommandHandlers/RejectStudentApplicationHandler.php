<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\RejectStudentApplicationCommand;
use StudentAdmission\Domain\Services\StudentAdmissionService;

final class RejectStudentApplicationHandler
{
    public function __construct(
        private readonly StudentAdmissionService $service
    ) {
    }

    public function handle(RejectStudentApplicationCommand $command): void
    {
        $event = $this->service->rejectApplication(
            applicationId: $command->applicationId,
            rejectedAt: $command->rejectedAt
        );

        event($event);
    }
}
