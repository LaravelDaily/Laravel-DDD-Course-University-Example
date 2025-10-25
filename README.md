# Laravel DDD Example

A demo project from a [Laravel Modules and DDD](https://laraveldaily.com/course/laravel-modules-ddd) course on [LaravelDaily.com](https://laraveldaily.com).

This is only one **interpretation** of DDD, and simplified for a tutorial, with only one bounded context of Student Admission.

```
Domain/
├── StudentApplication.php          # Aggregate root entity
├── Student.php                     # Entity
├── Course.php                      # Entity
├── StudentApplicationStatus.php    # Value Object (Enum)
├── StudentAdmissionService.php     # Domain Service
├── Events/                         # Domain Events
│   ├── StudentApplicationAccepted.php
│   └── StudentApplicationRejected.php
├── Repositories/                   # Interfaces only (implemented in Infrastructure)
│   ├── StudentApplicationRepositoryInterface.php
│   ├── StudentRepositoryInterface.php
│   └── CourseRepositoryInterface.php
└── Exceptions/
    └── InvalidApplicationStateException.php
```
