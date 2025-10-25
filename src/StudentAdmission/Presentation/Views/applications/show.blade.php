<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('applications.index') }}"
                        class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    @if($application->status === 'pending')
                        <form method="POST" action="{{ route('applications.accept', $application->id) }}" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Accept Application
                            </button>
                        </form>
                        <form method="POST" action="{{ route('applications.reject', $application->id) }}" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject Application
                            </button>
                        </form>
                    @elseif($application->status === 'rejected')
                        <form method="POST" action="{{ route('applications.accept', $application->id) }}" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Re-accept Application
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $application->studentName }}</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                    Application submitted on {{ $application->submittedAt->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @session('success')
            <div x-data="{ show: true }" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="mb-6 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="show = false"
                            class="inline-flex rounded-md p-1.5 text-green-500 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endsession

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Application Details</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Applicant Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $application->studentName }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Application Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($application->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($application->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Entry Exam Score</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @if($application->entryExamScore)
                                        <span class="font-mono text-lg">{{ number_format($application->entryExamScore, 1) }}%</span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Not evaluated yet</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $application->submittedAt->format('F j, Y') }}</dd>
                            </div>
                            @if($application->expiresAt)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expires At</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $application->expiresAt->format('F j, Y') }}</dd>
                                </div>
                            @endif
                            @if($application->acceptedAt)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Accepted Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $application->acceptedAt->format('F j, Y') }}</dd>
                                </div>
                            @endif
                            @if($application->rejectedAt)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rejected Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $application->rejectedAt->format('F j, Y') }}</dd>
                                </div>
                            @endif
                        </dl>

                        @if($application->notes)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                                <dd class="mt-2 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    {{ $application->notes }}
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Student Status</h3>
                    </div>
                    <div class="p-6">
                        @if($application->student)
                            <div class="text-center">
                                <div class="mx-auto h-12 w-12 text-green-500">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Student Enrolled</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    This application has been converted to a student record.
                                </p>
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    Student ID: #{{ $application->student->id }}
                                </p>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No Student Record</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    @if($application->status === 'accepted')
                                        This application has been accepted. Student record was created automatically.
                                    @elseif($application->status === 'pending')
                                        Application is pending review.
                                    @else
                                        Application was rejected.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
