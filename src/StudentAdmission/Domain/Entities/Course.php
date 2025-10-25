<?php

namespace StudentAdmission\Domain\Entities;

use InvalidArgumentException;

final class Course
{
    public ?int $id;
    public string $name;

    public function __construct(string $name, ?int $id = null)
    {
        if ($id !== null && $id <= 0) {
            throw new InvalidArgumentException('Course identity must be a positive integer.');
        }

        $this->id = $id;
        $this->name = trim($name);

        if ($name === '') {
            throw new InvalidArgumentException('Course name cannot be empty.');
        }
    }

    public function snapshot(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
