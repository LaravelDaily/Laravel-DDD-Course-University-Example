<?php

namespace StudentAdmission\Domain\Entities;

use DateTimeImmutable;
use InvalidArgumentException;
use StudentAdmission\Domain\ValueObjects\StudentApplicationStatus;

final class StudentApplication
{
    public ?int $id;
    public string $studentName;
    public DateTimeImmutable $submittedAt;
    public ?DateTimeImmutable $expiresAt;
    public ?float $entryExamScore;
    public ?string $notes;
    public ?DateTimeImmutable $acceptedAt;
    public ?DateTimeImmutable $rejectedAt;
    public ?Student $student;

    private function __construct(
        ?int $id,
        string $studentName,
        DateTimeImmutable $submittedAt,
        ?DateTimeImmutable $expiresAt,
        ?float $entryExamScore,
        ?string $notes,
        ?DateTimeImmutable $acceptedAt,
        ?DateTimeImmutable $rejectedAt,
        ?Student $student
    ) {
        if ($id !== null && $id <= 0) {
            throw new InvalidArgumentException('Application identity must be a positive integer.');
        }

        $studentName = trim($studentName);
        if ($studentName === '') {
            throw new InvalidArgumentException('Student name cannot be empty.');
        }

        if ($entryExamScore !== null && ($entryExamScore < 0 || $entryExamScore > 100)) {
            throw new InvalidArgumentException('Entry exam score must be between 0 and 100.');
        }

        if ($acceptedAt !== null && $rejectedAt !== null) {
            throw new InvalidArgumentException('Application cannot be accepted and rejected at the same time.');
        }

        if ($acceptedAt !== null && $student === null) {
            throw new InvalidArgumentException('Accepted applications must have a student record.');
        }

        if ($student !== null && $id !== null && $student->applicationId !== $id) {
            throw new InvalidArgumentException('Student record must belong to the application.');
        }

        $this->id = $id;
        $this->studentName = $studentName;
        $this->submittedAt = $submittedAt;
        $this->expiresAt = $expiresAt;
        $this->entryExamScore = $entryExamScore;
        $this->notes = $notes;
        $this->acceptedAt = $acceptedAt;
        $this->rejectedAt = $rejectedAt;
        $this->student = $student;
    }

    public static function submit(
        string $studentName,
        DateTimeImmutable $submittedAt,
        ?DateTimeImmutable $expiresAt = null,
        ?float $entryExamScore = null,
        ?string $notes = null
    ): self {
        return new self(
            id: null,
            studentName: $studentName,
            submittedAt: $submittedAt,
            expiresAt: $expiresAt,
            entryExamScore: $entryExamScore,
            notes: $notes,
            acceptedAt: null,
            rejectedAt: null,
            student: null
        );
    }

    public function accept(DateTimeImmutable $acceptedAt): void
    {
        if ($this->acceptedAt !== null && $this->rejectedAt === null) {
            throw new InvalidArgumentException('Application is already accepted.');
        }

        $this->acceptedAt = $acceptedAt;
        $this->rejectedAt = null;

        if ($this->student === null) {
            $this->student = new Student(
                name: $this->studentName,
                applicationId: $this->id
            );
        }
    }

    public function reject(DateTimeImmutable $rejectedAt): void
    {
        if ($this->rejectedAt !== null) {
            throw new InvalidArgumentException('Application is already rejected.');
        }

        $this->rejectedAt = $rejectedAt;
        $this->acceptedAt = null;
        $this->student = null;
    }

    public function status(): StudentApplicationStatus
    {
        return StudentApplicationStatus::fromTimeline(
            acceptedAt: $this->acceptedAt,
            rejectedAt: $this->rejectedAt
        );
    }

    public function snapshot(): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->studentName,
            'submitted_at' => $this->submittedAt,
            'expires_at' => $this->expiresAt,
            'entry_exam_score' => $this->entryExamScore,
            'notes' => $this->notes,
            'accepted_at' => $this->acceptedAt,
            'rejected_at' => $this->rejectedAt,
            'status' => $this->status()->value,
            'student' => $this->student?->snapshot(),
        ];
    }
}
