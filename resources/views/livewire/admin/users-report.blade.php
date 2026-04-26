<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div class="space-y-6">
                <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.reports.badge') }}</p>
                            <h1 class="mt-2 text-2xl font-bold text-gray-900">
                                {{ __('admin.reports.title', ['type' => $this->typeLabel]) }}
                            </h1>
                            <p class="mt-2 text-sm text-gray-600">{{ __('admin.reports.subtitle') }}</p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <a wire:navigate href="{{ route('admin.reports.show', ['type' => $this->altType]) }}"
                               class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                {{ __('admin.reports.switch_to', ['type' => $this->altTypeLabel]) }}
                            </a>
                            <a href="{{ route('admin.reports.export', ['type' => $reportType, 'search' => $search]) }}"
                               class="inline-flex items-center rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                                {{ __('admin.reports.export') }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="report-search" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                            {{ __('admin.reports.search_label') }}
                        </label>
                        <input
                            id="report-search"
                            type="text"
                            wire:model.live.debounce.350ms="search"
                            placeholder="{{ __('admin.reports.search_placeholder') }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm text-gray-700 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-100"
                        >
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[900px] text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-4 py-3">{{ __('admin.reports.table.student') }}</th>
                                    <th class="px-4 py-3">{{ __('admin.reports.table.gender') }}</th>
                                    <th class="px-4 py-3">{{ __('admin.reports.table.age') }}</th>
                                    @forelse ($questions as $question)
                                        <th class="px-4 py-3">{{ $question->title }}</th>
                                    @empty
                                        <th class="px-4 py-3">{{ __('admin.reports.table.no_questions') }}</th>
                                    @endforelse
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($students as $row)
                                    <tr>
                                        <td class="px-4 py-3 align-top">
                                            <p class="font-semibold text-gray-900">{{ $row['student']->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $row['student']->email }}</p>
                                        </td>
                                        <td class="px-4 py-3 align-top text-gray-700">{{ __('admin.reports.genders.'.$row['gender'], [], 'en') }}</td>
                                        <td class="px-4 py-3 align-top text-gray-700">{{ __('admin.reports.ages.'.$row['age'], [], 'en') }}</td>
                                        @forelse ($questions as $question)
                                            <td class="px-4 py-3 align-top text-gray-700">{{ $row['answers'][$question->id] }}</td>
                                        @empty
                                            <td class="px-4 py-3 text-gray-500">—</td>
                                        @endforelse
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 1 + max($questions->count(), 1) }}" class="px-4 py-8 text-center text-sm text-gray-500">
                                            {{ __('admin.reports.empty') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                @if (method_exists($students, 'links'))
                    <div>
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
