            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <!-- Dashboard -->
                            <x-layouts.sidebar-link href="{{ route('dashboard') }}" icon='fas-house'
                                :active="request()->routeIs('dashboard*')">Dashboard</x-layouts.sidebar-link>

                            <!-- Student Admission -->
                            <x-layouts.sidebar-two-level-link-parent title="Student Admission" icon="fas-house"
                                :active="request()->routeIs(['applications*', 'courses*', 'students*'])">
                                <x-layouts.sidebar-two-level-link href="{{ route('applications.index') }}" icon='fas-file-lines'
                                :active="request()->routeIs('applications*')">Applications</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('courses.index') }}" icon='fas-house'
                                    :active="request()->routeIs('courses*')">Courses</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('students.index') }}" icon='fas-user-graduate'
                                    :active="request()->routeIs('students*')">Students</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>
                        </ul>
                    </nav>
                </div>
            </aside>
