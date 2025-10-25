<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\SubmitStudentApplicationCommand;
use StudentAdmission\Domain\Entities\StudentApplication;
use StudentAdmission\Domain\Repositories\StudentApplicationRepositoryInterface;

final class SubmitStudentApplicationHandler
{
    public function __construct(
        private readonly StudentApplicationRepositoryInterface $applications
    ) {
    }

    public function handle(SubmitStudentApplicationCommand $command): StudentApplication
    {
        $application = StudentApplication::submit(
            studentName: $command->studentName,
            submittedAt: $command->submittedAt,
            expiresAt: $command->expiresAt,
            entryExamScore: $command->entryExamScore,
            notes: $command->notes
        );

        $this->applications->save($application);

        return $application;
    }
}
