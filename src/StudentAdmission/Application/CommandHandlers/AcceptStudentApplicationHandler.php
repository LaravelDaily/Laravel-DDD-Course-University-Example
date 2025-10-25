<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\AcceptStudentApplicationCommand;
use StudentAdmission\Domain\Services\StudentAdmissionService;

final class AcceptStudentApplicationHandler
{
    public function __construct(
        private readonly StudentAdmissionService $service
    ) {
    }

    public function handle(AcceptStudentApplicationCommand $command): void
    {
        $event = $this->service->acceptApplication(
            applicationId: $command->applicationId,
            acceptedAt: $command->acceptedAt
        );

        event($event);
    }
}
