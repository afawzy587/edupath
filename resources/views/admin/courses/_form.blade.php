@php
    $course = $course ?? null;
    $isEdit = $course !== null;
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.category') }}</label>
            <select name="category_id" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.instructor') }}</label>
            <input
                type="text"
                name="instructor_name"
                value="{{ old('instructor_name', $course->instructor_name ?? '') }}"
                class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
            >
            @error('instructor_name')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="active" value="1" class="h-4 w-4 rounded border-gray-300"
                @checked(old('active', $course->active ?? true))>
            {{ __('admin.courses.fields.active') }}
        </label>

        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.image') }}</label>
            <input type="file" name="image" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
            <p class="mt-2 text-xs text-gray-400">{{ __('admin.courses.fields.image_help') }}</p>
            @if ($isEdit && optional($course)->translate('en')?->image)
                <div class="mt-3 flex items-center gap-3 text-xs text-gray-500">
                   <a href="{{ $course->image_path }}" target="_blank">
                    <img
                        src="{{ $course->image_path }}"
                        alt="{{ $course->name }}"
                        class="h-14 w-14 rounded-lg border border-gray-200 object-cover"
                    >
                    <span>{{ __('admin.courses.fields.current_image') }}</span>
                    </a>
                </div>
            @endif
            @error('image')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.video') }}</label>
            <input type="file" name="video" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
            <p class="mt-2 text-xs text-gray-400">{{ __('admin.courses.fields.video_help') }}</p>
            @if ($isEdit && $course?->video)
                <div class="mt-3 flex items-center gap-3 text-xs text-gray-500">
                    <a href="{{ $course->video_path }}" target="_blank" class="inline-flex items-center gap-2">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 text-gray-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </span>
                        <span>{{ __('admin.courses.fields.current_video') }}</span>
                    </a>
                </div>
            @endif
            @error('video')
                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.courses.locale.en') }}</p>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.name') }}</label>
                    <input
                        type="text"
                        name="name_en"
                        value="{{ old('name_en', optional($course)->translate('en')?->name ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                    >
                    @error('name_en')
                        <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.description') }}</label>
                    <textarea
                        name="description_en"
                        rows="5"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                    >{{ old('description_en', optional($course)->translate('en')?->description ?? '') }}</textarea>
                    @error('description_en')
                        <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold text-gray-900">{{ __('admin.courses.locale.ar') }}</p>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.name') }}</label>
                    <input
                        type="text"
                        name="name_ar"
                        value="{{ old('name_ar', optional($course)->translate('ar')?->name ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                    >
                    @error('name_ar')
                        <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('admin.courses.fields.description') }}</label>
                    <textarea
                        name="description_ar"
                        rows="5"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm"
                    >{{ old('description_ar', optional($course)->translate('ar')?->description ?? '') }}</textarea>
                    @error('description_ar')
                        <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a wire:navigate href="{{ route('admin.courses.index') }}" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
        {{ __('admin.courses.actions.cancel') }}
    </a>
    <button type="submit" class="rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
        {{ $isEdit ? __('admin.courses.actions.update') : __('admin.courses.actions.create') }}
    </button>
</div>
