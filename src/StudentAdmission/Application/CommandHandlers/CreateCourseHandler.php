<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\CreateCourseCommand;
use StudentAdmission\Domain\Entities\Course;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;

final class CreateCourseHandler
{
    public function __construct(
        private readonly CourseRepositoryInterface $courses
    ) {
    }

    public function handle(CreateCourseCommand $command): Course
    {
        $course = new Course(
            name: $command->name
        );

        $this->courses->save($course);

        return $course;
    }
}
