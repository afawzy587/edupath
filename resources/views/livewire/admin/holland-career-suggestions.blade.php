<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div class="space-y-8">
                {{-- Header --}}
                <div class="rounded-3xl border border-teal-100 bg-gradient-to-r from-white via-white to-teal-50 px-6 py-8 md:px-8">
                    <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.holland_career.badge') }}</p>
                    <h1 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">{{ __('admin.holland_career.title') }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('admin.holland_career.subtitle') }}</p>
                </div>

                {{-- Suggestions List --}}
                <div class="space-y-6">
                    @foreach($items as $index => $item)
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm" wire:key="item-{{ $item['id'] }}">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-sm font-bold text-teal-700 mr-2">{{ $item['code'] }}</span>
                                    {{ $item['title'] }}
                                </h2>
                                <button
                                    type="button"
                                    wire:click="save({{ $index }})"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-5 py-2 text-sm font-medium text-white hover:bg-teal-700 transition"
                                >
                                    <span wire:loading.remove wire:target="save({{ $index }})">{{ __('admin.holland_career.save') }}</span>
                                    <span wire:loading wire:target="save({{ $index }})">{{ __('admin.holland_career.saving') }}</span>
                                </button>
                            </div>

                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.title_label') }}</label>
                                    <input
                                        type="text"
                                        wire:model="items.{{ $index }}.title"
                                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.sort_label') }}</label>
                                    <input
                                        type="number"
                                        wire:model="items.{{ $index }}.sort_order"
                                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500"
                                    >
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.description_label') }}</label>
                                <textarea
                                    wire:model="items.{{ $index }}.description"
                                    rows="6"
                                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500"
                                ></textarea>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.majors_label') }}</label>
                                <textarea
                                    wire:model="items.{{ $index }}.majors"
                                    rows="3"
                                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500"
                                ></textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>

