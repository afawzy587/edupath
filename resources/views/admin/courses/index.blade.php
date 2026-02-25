<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('admin.courses.badge') }}</p>
                        <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ __('admin.courses.title') }}</h1>
                        <p class="mt-2 text-sm text-gray-500">{{ __('admin.courses.subtitle') }}</p>
                    </div>
                    <a wire:navigate href="{{ route('admin.courses.create') }}" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                        {{ __('admin.courses.actions.add') }}
                    </a>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-4 py-3">{{ __('admin.courses.table.name') }}</th>
                                <th class="px-4 py-3">{{ __('admin.courses.table.category') }}</th>
                                <th class="px-4 py-3">{{ __('admin.courses.table.instructor') }}</th>
                                <th class="px-4 py-3">{{ __('admin.courses.table.status') }}</th>
                                <th class="px-4 py-3 text-right">{{ __('admin.courses.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($courses as $course)
                                <tr>
                                    <td class="px-4 py-3" style="max-width: 200px">
                                        <p class="font-semibold text-gray-900">{{ $course->name }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $course->category?->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $course->instructor_name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $course->active ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $course->active ? __('admin.courses.status.active') : __('admin.courses.status.inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a wire:navigate href="{{ route('admin.courses.edit', $course) }}" class="rounded-lg border border-gray-200 px-3 py-1 text-xs text-gray-600 hover:bg-gray-50">
                                                {{ __('admin.courses.actions.edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('{{ __('admin.courses.actions.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1 text-xs text-red-600 hover:bg-red-50">
                                                    {{ __('admin.courses.actions.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                        {{ __('admin.courses.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($courses, 'links'))
                    <div class="mt-6">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
