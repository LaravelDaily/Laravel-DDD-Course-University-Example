<?php

namespace StudentAdmission\Presentation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use StudentAdmission\Application\CommandHandlers\CreateCourseHandler;
use StudentAdmission\Application\CommandHandlers\DeleteCourseHandler;
use StudentAdmission\Application\CommandHandlers\UpdateCourseHandler;
use StudentAdmission\Application\Commands\CreateCourseCommand;
use StudentAdmission\Application\Commands\DeleteCourseCommand;
use StudentAdmission\Application\Commands\UpdateCourseCommand;
use StudentAdmission\Application\DTOs\CourseDTO;
use StudentAdmission\Application\Queries\GetCourseQuery;
use StudentAdmission\Application\Queries\ListCoursesQuery;
use StudentAdmission\Infrastructure\EloquentModels\CourseModel;
use StudentAdmission\Presentation\Requests\StoreCourseRequest;
use StudentAdmission\Presentation\Requests\UpdateCourseRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CourseController extends Controller
{
    public function __construct(
        private readonly CreateCourseHandler $createHandler,
        private readonly UpdateCourseHandler $updateHandler,
        private readonly DeleteCourseHandler $deleteHandler
    ) {
    }

    public function index(): View
    {
        // Query object provides type safety and clear intent
        $query = new ListCoursesQuery(limit: 15, offset: 0);

        // CQRS principle: For queries, execute directly without handler
        $courses = CourseModel::withCount('students')
            ->latest()
            ->paginate($query->limit)
            ->through(fn($model) => new CourseDTO(
                id: $model->id,
                name: $model->name,
                studentCount: $model->students_count ?? 0,
                createdAt: $model->created_at->format('M j, Y'),
                updatedAt: $model->updated_at->format('M j, Y')
            ));

        return view('studentadmission::courses.index', compact('courses'));
    }

    public function show(int $id): View
    {
        // Query object provides type safety and clear intent
        $query = new GetCourseQuery(id: $id);

        // Execute query directly - find course by ID with students
        $model = CourseModel::with('students.application')->find($query->id);

        if ($model === null) {
            abort(404, 'Course not found');
        }

        // Map model to DTO for the view
        $course = new CourseDTO(
            id: $model->id,
            name: $model->name,
            studentCount: $model->students->count(),
            createdAt: $model->created_at->format('F j, Y \a\t g:i A'),
            updatedAt: $model->updated_at->format('F j, Y')
        );

        return view('studentadmission::courses.show', compact('course', 'model'));
    }

    public function create(): View
    {
        return view('studentadmission::courses.create');
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $command = new CreateCourseCommand(
            name: $request->validated('name')
        );

        $course = $this->createHandler->handle($command);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Course created successfully.');
    }

    public function edit(int $id): View
    {
        $model = CourseModel::findOrFail($id);

        $course = new CourseDTO(
            id: $model->id,
            name: $model->name
        );

        return view('studentadmission::courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, int $id): RedirectResponse
    {
        $command = new UpdateCourseCommand(
            id: $id,
            name: $request->validated('name')
        );

        $course = $this->updateHandler->handle($command);

        return redirect()
            ->route('courses.show', $course->id)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $command = new DeleteCourseCommand(id: $id);

        $this->deleteHandler->handle($command);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
