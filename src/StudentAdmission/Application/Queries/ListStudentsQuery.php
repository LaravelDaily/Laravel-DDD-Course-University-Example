<?php

namespace StudentAdmission\Application\Queries;

final readonly class ListStudentsQuery
{
    public function __construct(
        public int $limit = 15,
        public int $offset = 0
    ) {
    }
}
