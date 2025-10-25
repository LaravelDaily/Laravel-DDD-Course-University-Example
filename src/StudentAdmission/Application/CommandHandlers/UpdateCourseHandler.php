<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\UpdateCourseCommand;
use StudentAdmission\Domain\Entities\Course;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;

final class UpdateCourseHandler
{
    public function __construct(
        private readonly CourseRepositoryInterface $courses
    ) {
    }

    public function handle(UpdateCourseCommand $command): Course
    {
        $course = $this->courses->byId($command->id);

        if ($course === null) {
            throw new \InvalidArgumentException("Course with ID {$command->id} not found.");
        }

        $course->name = $command->name;

        $this->courses->save($course);

        return $course;
    }
}
