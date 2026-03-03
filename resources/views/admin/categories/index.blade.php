<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('admin.categories.badge') }}</p>
                        <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ __('admin.categories.title') }}</h1>
                        <p class="mt-2 text-sm text-gray-500">{{ __('admin.categories.subtitle') }}</p>
                    </div>
                    <a wire:navigate href="{{ route('admin.categories.create') }}" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                        {{ __('admin.categories.actions.add') }}
                    </a>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-4 py-3">{{ __('admin.categories.table.name') }}</th>
                                <th class="px-4 py-3">{{ __('admin.categories.table.status') }}</th>
                                <th class="px-4 py-3 text-right">{{ __('admin.categories.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $category->active ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $category->active ? __('admin.categories.status.active') : __('admin.categories.status.inactive') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a wire:navigate href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg border border-gray-200 px-3 py-1 text-xs text-gray-600 hover:bg-gray-50">
                                                {{ __('admin.categories.actions.edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('{{ __('admin.categories.actions.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1 text-xs text-red-600 hover:bg-red-50">
                                                    {{ __('admin.categories.actions.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500">
                                        {{ __('admin.categories.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($categories, 'links'))
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
