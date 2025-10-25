<?php

namespace StudentAdmission\Infrastructure\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use StudentAdmission\Domain\Repositories\CourseRepositoryInterface;
use StudentAdmission\Domain\Repositories\StudentApplicationRepositoryInterface;
use StudentAdmission\Domain\Repositories\StudentRepositoryInterface;
use StudentAdmission\Infrastructure\Repositories\EloquentCourseRepository;
use StudentAdmission\Infrastructure\Repositories\EloquentStudentApplicationRepository;
use StudentAdmission\Infrastructure\Repositories\EloquentStudentRepository;

class StudentAdmissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind repository interfaces to implementations
        $this->app->bind(
            StudentApplicationRepositoryInterface::class,
            EloquentStudentApplicationRepository::class
        );

        $this->app->bind(
            StudentRepositoryInterface::class,
            EloquentStudentRepository::class
        );

        $this->app->bind(
            CourseRepositoryInterface::class,
            EloquentCourseRepository::class
        );
    }

    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        // Load routes with web middleware
        Route::middleware('web')
            ->group(__DIR__ . '/../../Presentation/routes.php');

        // Load views with namespace
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'studentadmission');
    }
}
