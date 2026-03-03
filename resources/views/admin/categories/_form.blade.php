@php
    $category = $category ?? null;
    $isEdit = $category !== null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-5">
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="active" value="1" class="h-4 w-4 rounded border-gray-300"
                @checked(old('active', $category->active ?? true))>
            {{ __('admin.categories.fields.active') }}
        </label>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.categories.locale.en') }}</p>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.categories.fields.name') }}</label>
                <input
                    type="text"
                    name="name_en"
                    value="{{ old('name_en', optional($category)->translate('en')?->name ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                >
                @error('name_en')
                    <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.categories.locale.ar') }}</p>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.categories.fields.name') }}</label>
                <input
                    type="text"
                    name="name_ar"
                    value="{{ old('name_ar', optional($category)->translate('ar')?->name ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                >
                @error('name_ar')
                    <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a wire:navigate href="{{ route('admin.categories.index') }}" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
        {{ __('admin.categories.actions.cancel') }}
    </a>
    <button type="submit" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
        {{ $isEdit ? __('admin.categories.actions.update') : __('admin.categories.actions.create') }}
    </button>
</div>
