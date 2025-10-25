<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Courses
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('courses.edit', $course->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Course
                    </a>
                </div>
            </div>
            <div class="mt-4">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $course->name }}</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                    Created on {{ $course->createdAt }}
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
            <!-- Course Information -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Course Details</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Course Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $course->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $course->studentCount }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $model->created_at->format('F j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $model->updated_at->format('F j, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Enrolled Students</h3>
                    </div>
                    <div class="p-6">
                        @if($model->students->count() > 0)
                            <div class="space-y-4">
                                @foreach($model->students as $student)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-700 dark:text-green-300">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $student->name)[1] ?? '', 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $student->name }}</h4>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    Student ID: {{ $student->id }} •
                                                    Enrolled {{ $student->pivot->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-300">
                                                Active
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-7.5a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No students enrolled</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This course doesn't have any enrolled students yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
