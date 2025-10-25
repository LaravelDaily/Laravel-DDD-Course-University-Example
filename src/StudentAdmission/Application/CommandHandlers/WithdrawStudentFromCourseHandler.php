<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\WithdrawStudentFromCourseCommand;
use StudentAdmission\Domain\Repositories\StudentRepositoryInterface;

final readonly class WithdrawStudentFromCourseHandler
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function handle(WithdrawStudentFromCourseCommand $command): void
    {
        $student = $this->studentRepository->byId($command->studentId);

        if ($student === null) {
            throw new \InvalidArgumentException('Student not found.');
        }

        $student->withdrawFromCourse($command->courseId);

        $this->studentRepository->save($student);
    }
}
