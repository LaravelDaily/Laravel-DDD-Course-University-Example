<?php

namespace StudentAdmission\Application\Commands;

final class DeleteCourseCommand
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
