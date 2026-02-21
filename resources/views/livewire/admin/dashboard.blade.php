<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10 space-y-8">
        <section class="rounded-3xl border border-teal-100 bg-gradient-to-r from-white via-white to-teal-50 px-6 py-8 md:px-8">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">Admin Dashboard</p>
                    <h1 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                        Welcome back, {{ auth()->user()->name ?? 'Admin' }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Manage the platform, review student activity, and keep content up to date.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">Active Courses</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['active_courses'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">Active Questions</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['active_questions'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">Total Answers</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['answers'] }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">Students</p>
                    <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-semibold text-teal-700">+New</span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['students'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Total enrolled learners</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">Admins</p>
                    <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-semibold text-indigo-700">Team</span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['admins'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Management users</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">Courses</p>
                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">
                        {{ $stats['active_courses'] }} active
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['courses'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Available learning paths</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">Questions</p>
                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">
                        {{ $stats['active_questions'] }} active
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['questions'] }}</p>
                <p class="mt-2 text-xs text-gray-500">Assessment inventory</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Students</h2>
                    <span class="text-xs text-gray-500">Last 6 signups</span>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="py-2">Student</th>
                                <th class="py-2">School</th>
                                <th class="py-2">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($recentStudents as $student)
                                <tr>
                                    <td class="py-3">
                                        <p class="font-semibold text-gray-900">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                    </td>
                                    <td class="py-3 text-gray-700">{{ $student->school ?: '—' }}</td>
                                    <td class="py-3 text-gray-700">
                                        {{ optional($student->created_at)->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-gray-500">
                                        No students yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Top Courses</h2>
                    <span class="text-xs text-gray-500">By enrollments</span>
                </div>
                <div class="mt-4 space-y-4">
                    @forelse ($topCourses as $course)
                        <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $course->name }}</p>
                                <p class="text-xs text-gray-500">{{ $course->category?->name ?? 'Uncategorized' }}</p>
                            </div>
                            <span class="text-sm font-semibold text-teal-600">
                                {{ $course->students_count }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No courses yet.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">System Alerts</h2>
                <ul class="mt-4 space-y-3 text-sm text-gray-600">
                    <li class="flex items-center justify-between rounded-xl bg-amber-50 px-4 py-3">
                        <span>Inactive courses</span>
                        <span class="font-semibold text-amber-700">{{ $inactiveCourses }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-xl bg-teal-50 px-4 py-3">
                        <span>Categories</span>
                        <span class="font-semibold text-teal-700">{{ $stats['categories'] }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-xl bg-indigo-50 px-4 py-3">
                        <span>Answer submissions</span>
                        <span class="font-semibold text-indigo-700">{{ $stats['answers'] }}</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Management Checklist</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">1</span>
                        <p>Review new student registrations and confirm school details.</p>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">2</span>
                        <p>Audit course activity and deactivate outdated content.</p>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">3</span>
                        <p>Refresh assessments to keep recommendations accurate.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
