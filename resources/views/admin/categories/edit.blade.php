<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('admin.categories.badge') }}</p>
                        <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ __('admin.categories.edit_title') }}</h1>
                        <p class="mt-2 text-sm text-gray-500">{{ __('admin.categories.edit_subtitle') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-8">
                    @csrf
                    @method('PUT')
                    @include('admin.categories._form', ['category' => $category])
                </form>
            </div>
        </div>
    </main>
</div>
