<?php

namespace StudentAdmission\Presentation\Controllers;

use DateTimeImmutable;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use StudentAdmission\Application\CommandHandlers\AcceptStudentApplicationHandler;
use StudentAdmission\Application\CommandHandlers\RejectStudentApplicationHandler;
use StudentAdmission\Application\CommandHandlers\SubmitStudentApplicationHandler;
use StudentAdmission\Application\Commands\AcceptStudentApplicationCommand;
use StudentAdmission\Application\Commands\RejectStudentApplicationCommand;
use StudentAdmission\Application\Commands\SubmitStudentApplicationCommand;
use StudentAdmission\Application\DTOs\StudentApplicationDTO;
use StudentAdmission\Application\DTOs\StudentDTO;
use StudentAdmission\Application\Queries\GetStudentApplicationQuery;
use StudentAdmission\Application\Queries\ListPendingApplicationsQuery;
use StudentAdmission\Infrastructure\EloquentModels\StudentApplicationModel;
use StudentAdmission\Presentation\Requests\SubmitApplicationRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StudentApplicationController extends Controller
{
    public function __construct(
        private readonly SubmitStudentApplicationHandler $submitHandler,
        private readonly AcceptStudentApplicationHandler $acceptHandler,
        private readonly RejectStudentApplicationHandler $rejectHandler
    ) {
    }

    public function index(): View
    {
        // Query object provides type safety and clear intent
        $query = new ListPendingApplicationsQuery(limit: 15, offset: 0);

        // CQRS principle: For queries, execute directly without handler
        // Commands use handlers to enforce business rules
        $models = StudentApplicationModel::with('student')
            ->latest('submitted_at')
            ->limit($query->limit)
            ->offset($query->offset)
            ->get();

        $applications = $models->map(fn($model) => new StudentApplicationDTO(
            id: $model->id,
            studentName: $model->student_name,
            submittedAt: DateTimeImmutable::createFromMutable($model->submitted_at),
            expiresAt: $model->expires_at ? DateTimeImmutable::createFromMutable($model->expires_at) : null,
            entryExamScore: $model->entry_exam_score,
            notes: $model->notes,
            acceptedAt: $model->accepted_at ? DateTimeImmutable::createFromMutable($model->accepted_at) : null,
            rejectedAt: $model->rejected_at ? DateTimeImmutable::createFromMutable($model->rejected_at) : null,
            status: $this->calculateStatus($model),
            student: $model->student ? new StudentDTO(
                id: $model->student->id,
                name: $model->student->name,
                applicationId: $model->student->application_id
            ) : null
        ))->all();

        return view('studentadmission::applications.index', compact('applications'));
    }

    public function show(int $id): View
    {
        // Query object provides type safety and clear intent
        $query = new GetStudentApplicationQuery(applicationId: $id);

        // Execute query directly - find application by ID
        $model = StudentApplicationModel::with('student')->find($query->applicationId);

        if ($model === null) {
            abort(404, 'Application not found');
        }

        // Map model to DTO for the view
        $application = new StudentApplicationDTO(
            id: $model->id,
            studentName: $model->student_name,
            submittedAt: DateTimeImmutable::createFromMutable($model->submitted_at),
            expiresAt: $model->expires_at ? DateTimeImmutable::createFromMutable($model->expires_at) : null,
            entryExamScore: $model->entry_exam_score,
            notes: $model->notes,
            acceptedAt: $model->accepted_at ? DateTimeImmutable::createFromMutable($model->accepted_at) : null,
            rejectedAt: $model->rejected_at ? DateTimeImmutable::createFromMutable($model->rejected_at) : null,
            status: $this->calculateStatus($model),
            student: $model->student ? new StudentDTO(
                id: $model->student->id,
                name: $model->student->name,
                applicationId: $model->student->application_id
            ) : null
        );

        return view('studentadmission::applications.show', compact('application'));
    }

    public function create(): View
    {
        return view('studentadmission::applications.create');
    }

    public function store(SubmitApplicationRequest $request): RedirectResponse
    {
        $command = new SubmitStudentApplicationCommand(
            studentName: $request->validated('student_name'),
            submittedAt: new DateTimeImmutable(),
            expiresAt: $request->validated('expires_at') ? new DateTimeImmutable($request->validated('expires_at')) : null,
            entryExamScore: $request->validated('entry_exam_score') ? (float) $request->validated('entry_exam_score') : null,
            notes: $request->validated('notes')
        );

        $application = $this->submitHandler->handle($command);

        return redirect()
            ->route('applications.show', $application->id)
            ->with('success', 'Application submitted successfully.');
    }

    public function accept(int $id): RedirectResponse
    {
        $command = new AcceptStudentApplicationCommand(
            applicationId: $id,
            acceptedAt: new DateTimeImmutable()
        );

        $this->acceptHandler->handle($command);

        return redirect()
            ->back()
            ->with('success', 'Application accepted successfully.');
    }

    public function reject(int $id): RedirectResponse
    {
        $command = new RejectStudentApplicationCommand(
            applicationId: $id,
            rejectedAt: new DateTimeImmutable()
        );

        $this->rejectHandler->handle($command);

        return redirect()
            ->back()
            ->with('success', 'Application rejected successfully.');
    }

    private function calculateStatus(StudentApplicationModel $model): string
    {
        if ($model->accepted_at !== null) {
            return 'accepted';
        }

        if ($model->rejected_at !== null) {
            return 'rejected';
        }

        return 'pending';
    }
}
