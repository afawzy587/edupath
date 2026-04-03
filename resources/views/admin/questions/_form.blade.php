@php
    $question = $question ?? null;
    $isEdit = $question !== null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.questions.fields.category') }}</label>
            <select name="category_id" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <option value="">{{ __('admin.questions.fields.no_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $question->category_id ?? '') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.questions.fields.type') }}</label>
            <select name="type" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                @foreach (['assessments', 'hobbies'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $question->type ?? 'assessments') === $type)>
                        {{ __('admin.questions.types.' . $type) }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.questions.fields.order') }}</label>
            <input
                type="number"
                name="order"
                min="0"
                value="{{ old('order', $question->order ?? 0) }}"
                class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
            >
            @error('order')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="active" value="1" class="h-4 w-4 rounded border-gray-300"
                @checked(old('active', $question->active ?? true))>
            {{ __('admin.questions.fields.active') }}
        </label>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.questions.locale.en') }}</p>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.questions.fields.title') }}</label>
                <input
                    type="text"
                    name="title_en"
                    value="{{ old('title_en', optional($question)->translate('en')?->title ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                >
                @error('title_en')
                    <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.questions.locale.ar') }}</p>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('admin.questions.fields.title') }}</label>
                <input
                    type="text"
                    name="title_ar"
                    value="{{ old('title_ar', optional($question)->translate('ar')?->title ?? '') }}"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                >
                @error('title_ar')
                    <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a wire:navigate href="{{ route('admin.questions.index') }}" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
        {{ __('admin.questions.actions.cancel') }}
    </a>
    <button type="submit" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
        {{ $isEdit ? __('admin.questions.actions.update') : __('admin.questions.actions.create') }}
    </button>
</div>
