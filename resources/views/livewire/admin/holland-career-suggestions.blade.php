<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div class="space-y-8">
                {{-- Header --}}
                <div class="rounded-3xl border border-teal-100 bg-gradient-to-r from-white via-white to-teal-50 px-6 py-8 md:px-8">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.holland_career.badge') }}</p>
                            <h1 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">{{ __('admin.holland_career.title') }}</h1>
                            <p class="mt-2 text-sm text-gray-600">{{ __('admin.holland_career.subtitle') }}</p>
                        </div>
                        <button
                            type="button"
                            wire:click="$toggle('showForm')"
                            class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-teal-700 transition"
                        >
                            {{ $showForm ? __('admin.holland_career.cancel') : __('admin.holland_career.add') }}
                        </button>
                    </div>
                </div>

                {{-- Add New Form --}}
                @if($showForm)
                    <div class="rounded-2xl border border-teal-100 bg-white p-6 shadow-sm" wire:key="new-item-form">
                        <h2 class="text-lg font-semibold text-gray-900 mb-5">{{ __('admin.holland_career.add_title') }}</h2>

                        <div class="grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.code_label') }} <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    wire:model="newItem.code"
                                    maxlength="1"
                                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500 @error('newItem.code') border-red-500 @enderror"
                                    placeholder="R"
                                >
                                @error('newItem.code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.title_label') }} <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    wire:model="newItem.title"
                                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500 @error('newItem.title') border-red-500 @enderror"
                                >
                                @error('newItem.title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.sort_label') }}</label>
                                <input
                                    type="number"
                                    wire:model="newItem.sort_order"
                                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500 @error('newItem.sort_order') border-red-500 @enderror"
                                >
                                @error('newItem.sort_order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.description_label') }} <span class="text-red-500">*</span></label>
                            <textarea
                                wire:model="newItem.description"
                                rows="4"
                                class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500 @error('newItem.description') border-red-500 @enderror"
                            ></textarea>
                            @error('newItem.description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.holland_career.majors_label') }} <span class="text-red-500">*</span></label>
                            <textarea
                                wire:model="newItem.majors"
                                rows="3"
                                class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-teal-500 @error('newItem.majors') border-red-500 @enderror"
                            ></textarea>
                            @error('newItem.majors') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button
                                type="button"
                                wire:click="add"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-teal-700 transition"
                            >
                                <span wire:loading.remove wire:target="add">{{ __('admin.holland_career.create') }}</span>
                                <span wire:loading wire:target="add">{{ __('admin.holland_career.creating') }}</span>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Suggestions List --}}
                <div class="space-y-6">
                    @foreach($items as $index => $item)
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm" wire:key="item-{{ $item['id'] }}">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-sm font-bold text-teal-700 mr-2">{{ $item['code'] }}</span>
                                    {{ $item['title'] }}
                                </h2>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="delete({{ $item['id'] }})"
                                        wire:loading.attr="disabled"
                                        wire:confirm="{{ __('admin.holland_career.confirm_delete') }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-100 transition"
                                    >
                                        <span wire:loading.remove wire:target="delete({{ $item['id'] }})">{{ __('admin.holland_career.delete') }}</span>
                                        <span wire:loading wire:target="delete({{ $item['id'] }})">{{ __('admin.holland_career.deleting') }}</span>
                                    </button>
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

