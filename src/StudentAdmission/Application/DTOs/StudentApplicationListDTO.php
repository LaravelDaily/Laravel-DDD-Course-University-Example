<?php

namespace StudentAdmission\Application\DTOs;

final class StudentApplicationListDTO
{
    /**
     * @param StudentApplicationDTO[] $applications
     */
    public function __construct(
        public readonly array $applications,
        public readonly int $total
    ) {
    }
}
