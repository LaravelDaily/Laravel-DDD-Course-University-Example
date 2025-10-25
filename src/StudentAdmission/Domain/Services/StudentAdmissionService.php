<?php

namespace StudentAdmission\Domain\Services;

use DateTimeImmutable;
use StudentAdmission\Domain\Entities\Student;
use StudentAdmission\Domain\Entities\StudentApplication;
use StudentAdmission\Domain\Exceptions\InvalidApplicationStateException;
use StudentAdmission\Domain\Events\StudentApplicationAccepted;
use StudentAdmission\Domain\Events\StudentApplicationRejected;
use StudentAdmission\Domain\Repositories\StudentApplicationRepositoryInterface;
use StudentAdmission\Domain\Repositories\StudentRepositoryInterface;

final class StudentAdmissionService
{
    public function __construct(
        private readonly StudentApplicationRepositoryInterface $applications,
        private readonly StudentRepositoryInterface $students
    ) {
    }

    public function acceptApplication(int $applicationId, DateTimeImmutable $acceptedAt): StudentApplicationAccepted
    {
        $application = $this->requireApplication($applicationId);

        $application->accept($acceptedAt);
        $this->applications->save($application);

        $this->persistStudentIfPresent($application->student);

        return new StudentApplicationAccepted(
            applicationId: $applicationId,
            acceptedAt: $acceptedAt
        );
    }

    public function rejectApplication(int $applicationId, DateTimeImmutable $rejectedAt): StudentApplicationRejected
    {
        $application = $this->requireApplication($applicationId);

        $application->reject($rejectedAt);
        $this->applications->save($application);

        $this->students->removeByApplicationId($applicationId);

        return new StudentApplicationRejected(
            applicationId: $applicationId,
            rejectedAt: $rejectedAt
        );
    }

    private function persistStudentIfPresent(?Student $student): void
    {
        if ($student === null) {
            return;
        }

        $this->students->save($student);
    }

    private function requireApplication(int $applicationId): StudentApplication
    {
        $application = $this->applications->byId($applicationId);

        if ($application === null) {
            throw InvalidApplicationStateException::applicationNotFound($applicationId);
        }

        return $application;
    }
}
