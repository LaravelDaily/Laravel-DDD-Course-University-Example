<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\EnrollStudentInCourseCommand;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;
use StudentAdmission\Domain\Repositories\StudentRepositoryInterface;

final readonly class EnrollStudentInCourseHandler
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
        private CourseRepositoryInterface $courseRepository
    ) {
    }

    public function handle(EnrollStudentInCourseCommand $command): void
    {
        $student = $this->studentRepository->byId($command->studentId);

        if ($student === null) {
            throw new \InvalidArgumentException('Student not found.');
        }

        $course = $this->courseRepository->byId($command->courseId);

        if ($course === null) {
            throw new \InvalidArgumentException('Course not found.');
        }

        $student->enrollInCourse($course);

        $this->studentRepository->save($student);
    }
}
