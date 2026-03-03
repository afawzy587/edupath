<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('admin.questions.badge') }}</p>
                        <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ __('admin.questions.title') }}</h1>
                        <p class="mt-2 text-sm text-gray-500">{{ __('admin.questions.subtitle') }}</p>
                    </div>
                    <a wire:navigate href="{{ route('admin.questions.create') }}" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                        {{ __('admin.questions.actions.add') }}
                    </a>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-4 py-3">{{ __('admin.questions.table.title') }}</th>
                                <th class="px-4 py-3">{{ __('admin.questions.table.category') }}</th>
                                <th class="px-4 py-3">{{ __('admin.questions.table.type') }}</th>
                                <th class="px-4 py-3">{{ __('admin.questions.table.order') }}</th>
                                <th class="px-4 py-3">{{ __('admin.questions.table.status') }}</th>
                                <th class="px-4 py-3 text-right">{{ __('admin.questions.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($questions as $question)
                                <tr>
                                    <td class="px-4 py-3" style="max-width: 240px">
                                        <p class="font-semibold text-gray-900">{{ $question->title }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $question->category?->name ?? __('admin.questions.uncategorized') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ __('admin.questions.types.' . $question->type) }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $question->order }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $question->active ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $question->active ? __('admin.questions.status.active') : __('admin.questions.status.inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a wire:navigate href="{{ route('admin.questions.edit', $question) }}" class="rounded-lg border border-gray-200 px-3 py-1 text-xs text-gray-600 hover:bg-gray-50">
                                                {{ __('admin.questions.actions.edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" onsubmit="return confirm('{{ __('admin.questions.actions.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1 text-xs text-red-600 hover:bg-red-50">
                                                    {{ __('admin.questions.actions.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                                        {{ __('admin.questions.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($questions, 'links'))
                    <div class="mt-6">
                        {{ $questions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
