<?php

namespace StudentAdmission\Domain\Exceptions;

use RuntimeException;

final class InvalidApplicationStateException extends RuntimeException
{
    public static function applicationNotFound(int $applicationId): self
    {
        return new self(sprintf('Student application %d could not be found.', $applicationId));
    }
}
