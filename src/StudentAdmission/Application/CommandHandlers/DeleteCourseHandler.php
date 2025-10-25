<?php

namespace StudentAdmission\Application\CommandHandlers;

use StudentAdmission\Application\Commands\DeleteCourseCommand;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;

final class DeleteCourseHandler
{
    public function __construct(
        private readonly CourseRepositoryInterface $courses
    ) {
    }

    public function handle(DeleteCourseCommand $command): void
    {
        $this->courses->delete($command->id);
    }
}
