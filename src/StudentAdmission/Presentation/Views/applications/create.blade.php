<x-layouts.app>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('applications.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Applications
                </a>
            </div>
            <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">Create New Application</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                Submit a new student admission application.
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('applications.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Student Name -->
                    <div>
                        <x-forms.input
                            name="student_name"
                            label="Student Name *"
                            value="{{ old('student_name') }}"
                            required
                        />
                    </div>

                    <!-- Expires At -->
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Expiration Date
                        </label>
                        <input
                            type="date"
                            name="expires_at"
                            id="expires_at"
                            value="{{ old('expires_at') }}"
                            class="w-full px-4 py-1.5 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional. Leave blank if no expiration.</p>
                        @error('expires_at')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Entry Exam Score -->
                    <div>
                        <x-forms.input
                            name="entry_exam_score"
                            type="number"
                            label="Entry Exam Score (0-100)"
                            value="{{ old('entry_exam_score') }}"
                            min="0"
                            max="100"
                            step="0.01"
                        />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional. Leave blank if not yet evaluated.</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Notes
                        </label>
                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            class="w-full px-4 py-1.5 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Additional notes about this application...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <a href="{{ route('applications.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
