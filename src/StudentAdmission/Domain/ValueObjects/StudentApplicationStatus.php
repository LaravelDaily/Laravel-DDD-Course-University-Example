<?php

namespace StudentAdmission\Domain\ValueObjects;

enum StudentApplicationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public static function fromTimeline(
        ?\DateTimeImmutable $acceptedAt,
        ?\DateTimeImmutable $rejectedAt
    ): self {
        if ($acceptedAt !== null) {
            return self::ACCEPTED;
        }

        if ($rejectedAt !== null) {
            return self::REJECTED;
        }

        return self::PENDING;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isAccepted(): bool
    {
        return $this === self::ACCEPTED;
    }

    public function isRejected(): bool
    {
        return $this === self::REJECTED;
    }
}
