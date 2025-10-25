<?php

namespace StudentAdmission\Presentation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use StudentAdmission\Application\CommandHandlers\EnrollStudentInCourseHandler;
use StudentAdmission\Application\CommandHandlers\WithdrawStudentFromCourseHandler;
use StudentAdmission\Application\Commands\EnrollStudentInCourseCommand;
use StudentAdmission\Application\Commands\WithdrawStudentFromCourseCommand;
use StudentAdmission\Application\DTOs\CourseDTO;
use StudentAdmission\Application\DTOs\StudentDetailDTO;
use StudentAdmission\Application\DTOs\StudentListDTO;
use StudentAdmission\Application\Queries\GetStudentQuery;
use StudentAdmission\Application\Queries\ListStudentsQuery;
use StudentAdmission\Infrastructure\EloquentModels\CourseModel;
use StudentAdmission\Infrastructure\EloquentModels\StudentModel;
use StudentAdmission\Presentation\Requests\UpdateStudentCoursesRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StudentController extends Controller
{
    public function __construct(
        private readonly EnrollStudentInCourseHandler $enrollHandler,
        private readonly WithdrawStudentFromCourseHandler $withdrawHandler
    ) {
    }

    public function index(): View
    {
        // Query object provides type safety and clear intent
        $query = new ListStudentsQuery(limit: 15);

        // CQRS principle: For queries, execute directly without handler
        $students = StudentModel::withCount('courses')
            ->with('application')
            ->latest()
            ->paginate($query->limit)
            ->through(fn($model) => new StudentListDTO(
                id: $model->id,
                name: $model->name,
                applicationId: $model->application_id,
                courseCount: $model->courses_count ?? 0,
                createdAt: $model->created_at->format('M j, Y')
            ));

        return view('studentadmission::students.index', compact('students'));
    }

    public function show(int $id): View
    {
        // Query object provides type safety and clear intent
        $query = new GetStudentQuery(studentId: $id);

        // Execute query directly - find student by ID with courses
        $model = StudentModel::with(['courses', 'application'])->find($query->studentId);

        if ($model === null) {
            abort(404, 'Student not found');
        }

        // Map model to DTO for the view
        $student = new StudentDetailDTO(
            id: $model->id,
            name: $model->name,
            applicationId: $model->application_id,
            courses: $model->courses->map(fn($course) => new CourseDTO(
                id: $course->id,
                name: $course->name,
                studentCount: 0, // Not needed for this view
                createdAt: '',
                updatedAt: ''
            ))->all(),
            createdAt: $model->created_at->format('F j, Y \a\t g:i A'),
            updatedAt: $model->updated_at->format('F j, Y')
        );

        return view('studentadmission::students.show', compact('student'));
    }

    public function edit(int $id): View
    {
        // Find student
        $model = StudentModel::with('courses')->find($id);

        if ($model === null) {
            abort(404, 'Student not found');
        }

        // Get all available courses
        $allCourses = CourseModel::orderBy('name')->get();

        // Map to DTOs
        $student = new StudentDetailDTO(
            id: $model->id,
            name: $model->name,
            applicationId: $model->application_id,
            courses: $model->courses->map(fn($course) => new CourseDTO(
                id: $course->id,
                name: $course->name,
                studentCount: 0,
                createdAt: '',
                updatedAt: ''
            ))->all(),
            createdAt: $model->created_at->format('F j, Y \a\t g:i A'),
            updatedAt: $model->updated_at->format('F j, Y')
        );

        $courses = $allCourses->map(fn($course) => new CourseDTO(
            id: $course->id,
            name: $course->name,
            studentCount: 0,
            createdAt: '',
            updatedAt: ''
        ));

        return view('studentadmission::students.edit', compact('student', 'courses'));
    }

    public function update(int $id, UpdateStudentCoursesRequest $request): RedirectResponse
    {
        $model = StudentModel::with('courses')->find($id);

        if ($model === null) {
            abort(404, 'Student not found');
        }

        $newCourseIds = $request->validated('courses', []);
        $currentCourseIds = $model->courses->pluck('id')->toArray();

        // Determine which courses to enroll in and withdraw from
        $toEnroll = array_diff($newCourseIds, $currentCourseIds);
        $toWithdraw = array_diff($currentCourseIds, $newCourseIds);

        // Enroll in new courses
        foreach ($toEnroll as $courseId) {
            $command = new EnrollStudentInCourseCommand(
                studentId: $id,
                courseId: $courseId
            );
            $this->enrollHandler->handle($command);
        }

        // Withdraw from removed courses
        foreach ($toWithdraw as $courseId) {
            $command = new WithdrawStudentFromCourseCommand(
                studentId: $id,
                courseId: $courseId
            );
            $this->withdrawHandler->handle($command);
        }

        return redirect()
            ->route('students.show', $id)
            ->with('success', 'Student courses updated successfully.');
    }
}
