<?php

namespace StudentAdmission\Application\Commands;

final class CreateCourseCommand
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
