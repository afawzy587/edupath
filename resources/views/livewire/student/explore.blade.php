<div>
    @auth
        @include('partials.app-header')

        <section class="bg-white py-12">
            <div class="mx-auto max-w-6xl px-4">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">
                        {{ __('explore.title') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('explore.subtitle') }}
                    </p>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-xs text-gray-600">
                    <button
                        type="button"
                        wire:click="setCategory"
                        @class([
                            'rounded-full px-3 py-1',
                            'bg-rose-500 text-white' => $activeCategoryId === null,
                            'border border-rose-100 bg-white text-gray-600' => $activeCategoryId !== null,
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
                                'bg-rose-500 text-white' => $activeCategoryId === $category->id,
                                'border border-rose-100 bg-white text-gray-600' => $activeCategoryId !== $category->id,
                            ])
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-10 space-y-8">
                    @forelse ($courses as $course)
                        <article class="group mx-auto w-full max-w-[360px] overflow-hidden rounded-[28px] border border-gray-100 bg-white shadow-sm" data-explore-video-wrapper>
                            <div class="relative h-[65vh] max-h-[640px] min-h-[420px] overflow-hidden bg-gray-900">
                                <video
                                    class="h-full w-full object-cover"
                                    preload="metadata"
                                    autoplay
                                    loop
                                    muted
                                    playsinline
                                    data-explore-video
                                    src="{{ $course->video_path }}"
                                ></video>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <span class="absolute left-4 top-4 inline-flex items-center rounded-full bg-black/55 px-2 py-0.5 text-[11px] font-semibold text-white">
                                    {{ $loop->iteration }}/{{ $courses->count() }}
                                </span>
                                <span class="absolute right-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-gray-800">
                                    {{ $course->category?->name }}
                                </span>
                                <div class="absolute left-4 bottom-24 flex flex-col items-center gap-3 text-white/90">
                                    <div class="flex flex-col items-center gap-1">
                                        @php
                                            $isLiked = in_array($course->id, $likedCourseIds, true);
                                        @endphp
                                        <button
                                            type="button"
                                            wire:click="toggleLike({{ $course->id }})"
                                            @class([
                                                'flex h-9 w-9 items-center justify-center rounded-full transition',
                                                'bg-rose-500 text-white' => $isLiked,
                                                'bg-black/40 text-white/90' => ! $isLiked,
                                            ])
                                        >
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                                                <path d="M12 21s-7-4.5-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 11c0 5.5-7 10-7 10z" />
                                            </svg>
                                        </button>
                                        <span class="text-[10px] text-white/70">{{ $course->likes_count }} {{ __('explore.like') }}</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1">
                                        <a
                                            wire:navigate
                                            href="{{ route('student.courses.show', $course) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 text-white/90 transition hover:bg-white/20"
                                        >
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M4 6.5c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2V18c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V6.5z" />
                                                <path d="M8 9h8M8 13h6" />
                                            </svg>
                                        </a>
                                        <span class="text-[10px] text-white/70">{{ $course->reviews_count }} {{ __('explore.comment') }}</span>
                                    </div>

                                </div>
                                <div class="absolute inset-x-0 bottom-0 p-5 text-white">
                                    <h3 class="text-base font-semibold">
                                        {{ $course->name }}
                                    </h3>
{{--                                    <p class="mt-2 text-xs text-white/80 max-w-2xl break-words">--}}
{{--                                        {{ $course->description ?? __('courses.default_description') }}--}}
{{--                                    </p>--}}
                                    <div class="mt-4 flex items-center justify-between text-xs text-white/80">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 7v5l3 3" />
                                            </svg>
                                            {{ __('courses.duration', ['hours' => 4]) }}
                                        </span>
                                        <a
                                            wire:navigate
                                            href="{{ route('student.courses.show', $course) }}"
                                            class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold text-white ring-1 ring-white/30 transition hover:bg-white/25"
                                        >
                                            {{ __('explore.view') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-10 text-center text-sm text-gray-500">
                            {{ __('explore.empty') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endauth

    @guest
        <section class="bg-gradient-to-b from-teal-50 to-white py-20">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('courses.login_title') }}</h1>
                <p class="mt-4 text-gray-600">{{ __('courses.login_subtitle') }}</p>
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-white hover:bg-teal-700">
                    {{ __('courses.login_cta') }}
                </a>
            </div>
        </section>
    @endguest
</div>
