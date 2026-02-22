<div>
    @auth
        @include('partials.app-header')

        <section class="bg-slate-50 py-12">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ __('courses.title') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('courses.subtitle') }}
                    </p>
                </div>

                <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ __('courses.all_courses') }}
                    </h2>
                    <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                        <button
                            type="button"
                            wire:click="setCategory"
                            @class([
                                'rounded-full px-3 py-1',
                                'bg-teal-600 text-white' => $activeCategoryId === null,
                                'border border-gray-200 bg-white text-gray-600' => $activeCategoryId !== null,
                            ])
                        >
                            {{ __('courses.categories.all') }}
                        </button>
                        @foreach ($categories as $category)
                            <button
                                type="button"
                                wire:click="setCategory({{ $category->id }})"
                                @class([
                                    'rounded-full px-3 py-1',
                                    'bg-teal-600 text-white' => $activeCategoryId === $category->id,
                                    'border border-gray-200 bg-white text-gray-600' => $activeCategoryId !== $category->id,
                                ])
                            >
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($courses as $course)
                        @php
                            $duration = 3 + ($course->id % 6);
                        @endphp
                        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                            <div class="h-40 overflow-hidden bg-gray-100">
                                <img
                                    src="{{ $course->image_path }}"
                                    alt="{{ $course->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between gap-2">
                                    <h3 class="text-base font-semibold text-gray-900">
                                        {{ $course->name }}
                                    </h3>

                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $course->description ?? __('courses.default_description') }}
                                </p>
                                @php
                                    $matchPercent = isset($course->rating_percent)
                                        ? max(0, min(100, (int) round((float) $course->rating_percent)))
                                        : 0;
                                @endphp
                                <div class="mt-4 rounded-xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
                                    <div class="flex items-center justify-between text-xs font-semibold text-gray-700">
                                        <span>{{ __('courses.matching') }}</span>
                                        <span>{{ $matchPercent }}%</span>
                                    </div>
                                    <div class="mt-3 h-2 w-full rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-teal-500" style="width: {{ $matchPercent }}%"></div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 3" />
                                        </svg>
                                        {{ __('courses.duration', ['hours' => $duration]) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M3 7h18" />
                                            <path d="M5 7v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7" />
                                            <path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        {{ $course->category?->name }}
                                    </span>
                                </div>
                                @php
                                    $isEnrolled = in_array($course->id, $enrolledCourseIds, true);
                                @endphp
                                @if ($isEnrolled)
                                    <a
                                        wire:navigate
                                        href="{{ route('student.courses.show', $course) }}"
                                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-600"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        <span>{{ __('courses.card_action') }}</span>
                                    </a>
                                @else
                                    <button
                                        type="button"
                                        wire:click="signIn({{ $course->id }})"
                                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-600"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        <span>{{ __('courses.sign_in') }}</span>
                                    </button>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                            {{ __('courses.empty') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endauth

    @guest
        <section class="bg-gradient-to-b from-teal-50 to-white py-20">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('courses.login_title') }}</h1>
                <p class="text-gray-600 mt-4">{{ __('courses.login_subtitle') }}</p>
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700">
                    {{ __('courses.login_cta') }}
                </a>
            </div>
        </section>
    @endguest
</div>
