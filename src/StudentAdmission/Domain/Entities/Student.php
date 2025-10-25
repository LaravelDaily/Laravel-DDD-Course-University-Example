<?php

namespace StudentAdmission\Domain\Entities;

use InvalidArgumentException;

final class Student
{
    public ?int $id;
    public int $applicationId;
    public string $name;
    public array $courses = [];

    public function __construct(
        string $name,
        int $applicationId,
        ?int $id = null,
        array $courses = []
    ) {
        if ($id !== null && $id <= 0) {
            throw new InvalidArgumentException('Student identity must be a positive integer.');
        }

        if ($applicationId <= 0) {
            throw new InvalidArgumentException('Application identity must be a positive integer.');
        }

        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException('Student name cannot be empty.');
        }

        $this->name = $name;
        $this->id = $id;
        $this->applicationId = $applicationId;

        foreach ($courses as $course) {
            $this->addExistingCourse($course);
        }
    }

    public function enrollInCourse(Course $course): void
    {
        $courseId = $course->id;

        if ($courseId === null) {
            throw new InvalidArgumentException('Course must have an identity before student enrolment.');
        }

        if (isset($this->courses[$courseId])) {
            throw new InvalidArgumentException('Student is already enrolled in the specified course.');
        }

        $this->courses[$courseId] = $course;
    }

    public function withdrawFromCourse(int $courseId): void
    {
        if (!isset($this->courses[$courseId])) {
            throw new InvalidArgumentException('Student is not enrolled in the specified course.');
        }

        unset($this->courses[$courseId]);
    }

    public function snapshot(): array
    {
        return [
            'id' => $this->id,
            'application_id' => $this->applicationId,
            'name' => $this->name,
            'courses' => array_map(
                static fn (Course $course) => $course->snapshot(),
                array_values($this->courses)
            ),
        ];
    }

    private function addExistingCourse(Course $course): void
    {
        $courseId = $course->id;

        if ($courseId === null) {
            throw new InvalidArgumentException('Courses must have an identity when reconstructing a student.');
        }

        $this->courses[$courseId] = $course;
    }
}
