<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div class="space-y-8">
                <section class="rounded-3xl border border-teal-100 bg-gradient-to-r from-white via-white to-teal-50 px-6 py-8 md:px-8">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.dashboard.badge') }}</p>
                    <h1 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                        {{ __('admin.dashboard.welcome', ['name' => auth()->user()->name ?? __('admin.nav.admin')]) }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('admin.dashboard.subtitle') }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">{{ __('admin.dashboard.stats.active_courses') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['active_courses'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">{{ __('admin.dashboard.stats.active_questions') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['active_questions'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 text-center shadow-sm">
                        <p class="text-xs text-gray-500">{{ __('admin.dashboard.stats.total_answers') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['answers'] }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.stats.students') }}</p>
                    <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-semibold text-teal-700">
                        {{ __('admin.dashboard.stats.students_badge') }}
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['students'] }}</p>
                <p class="mt-2 text-xs text-gray-500">{{ __('admin.dashboard.stats.students_note') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.stats.admins') }}</p>
                    <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-semibold text-indigo-700">
                        {{ __('admin.dashboard.stats.admins_badge') }}
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['admins'] }}</p>
                <p class="mt-2 text-xs text-gray-500">{{ __('admin.dashboard.stats.admins_note') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.stats.courses') }}</p>
                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">
                        {{ __('admin.dashboard.stats.courses_badge', ['count' => $stats['active_courses']]) }}
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['courses'] }}</p>
                <p class="mt-2 text-xs text-gray-500">{{ __('admin.dashboard.stats.courses_note') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.stats.questions') }}</p>
                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">
                        {{ __('admin.dashboard.stats.questions_badge', ['count' => $stats['active_questions']]) }}
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold text-gray-900">{{ $stats['questions'] }}</p>
                <p class="mt-2 text-xs text-gray-500">{{ __('admin.dashboard.stats.questions_note') }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.recent_students.title') }}</h2>
                    <span class="text-xs text-gray-500">{{ __('admin.dashboard.recent_students.subtitle') }}</span>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="py-2">{{ __('admin.dashboard.recent_students.headers.student') }}</th>
                                <th class="py-2">{{ __('admin.dashboard.recent_students.headers.school') }}</th>
                                <th class="py-2">{{ __('admin.dashboard.recent_students.headers.joined') }}</th>
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
                                        {{ __('admin.dashboard.recent_students.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.top_courses.title') }}</h2>
                    <span class="text-xs text-gray-500">{{ __('admin.dashboard.top_courses.subtitle') }}</span>
                </div>
                <div class="mt-4 space-y-4">
                    @forelse ($topCourses as $course)
                        <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $course->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $course->category?->name ?? __('admin.dashboard.top_courses.uncategorized') }}
                                </p>
                            </div>
                            <span class="text-sm font-semibold text-teal-600">
                                {{ $course->students_count }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('admin.dashboard.top_courses.empty') }}</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.models.title') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.models.subtitle') }}</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($modelStats as $model)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ __('admin.dashboard.models.' . $model['key'] . '.label') }}
                            </p>
                            <span class="text-sm font-semibold text-teal-600">{{ $model['count'] }}</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            {{ __('admin.dashboard.models.' . $model['key'] . '.note') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

                <section class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.system_alerts.title') }}</h2>
                <ul class="mt-4 space-y-3 text-sm text-gray-600">
                    <li class="flex items-center justify-between rounded-xl bg-amber-50 px-4 py-3">
                        <span>{{ __('admin.dashboard.system_alerts.inactive_courses') }}</span>
                        <span class="font-semibold text-amber-700">{{ $inactiveCourses }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-xl bg-teal-50 px-4 py-3">
                        <span>{{ __('admin.dashboard.system_alerts.categories') }}</span>
                        <span class="font-semibold text-teal-700">{{ $stats['categories'] }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-xl bg-indigo-50 px-4 py-3">
                        <span>{{ __('admin.dashboard.system_alerts.answer_submissions') }}</span>
                        <span class="font-semibold text-indigo-700">{{ $stats['answers'] }}</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.checklist.title') }}</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">1</span>
                        <p>{{ __('admin.dashboard.checklist.item_one') }}</p>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">2</span>
                        <p>{{ __('admin.dashboard.checklist.item_two') }}</p>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-teal-700">3</span>
                        <p>{{ __('admin.dashboard.checklist.item_three') }}</p>
                    </div>
                </div>
            </div>
                </section>
            </div>
        </div>
    </main>
</div>
