<?php

namespace StudentAdmission\Application\Commands;

final readonly class EnrollStudentInCourseCommand
{
    public function __construct(
        public int $studentId,
        public int $courseId
    ) {
    }
}
