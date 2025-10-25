<?php

namespace StudentAdmission\Application\Commands;

final class UpdateCourseCommand
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
