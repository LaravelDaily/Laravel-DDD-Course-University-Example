<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('students.index') }}"
                        class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Students
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('students.edit', $student->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Manage Courses
                    </a>
                </div>
            </div>
            <div class="mt-4">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $student->name }}</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                    Enrolled on {{ $student->createdAt }}
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @session('success')
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="ml-3 text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endsession

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Student Information -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Student Details</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Student Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $student->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Application ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('applications.show', $student->applicationId) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        #{{ $student->applicationId }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Courses</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ count($student->courses) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Enrolled Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $student->createdAt }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $student->updatedAt }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Enrolled Courses</h3>
                    </div>
                    <div class="p-6">
                        @if(count($student->courses) > 0)
                            <ul class="space-y-3">
                                @foreach($student->courses as $course)
                                    <li class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $course->name }}</span>
                                        </div>
                                        <a href="{{ route('courses.show', $course->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                            View Course
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No courses</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This student is not enrolled in any courses yet.</p>
                                <div class="mt-6">
                                    <a href="{{ route('students.edit', $student->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                                        Enroll in Courses
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
