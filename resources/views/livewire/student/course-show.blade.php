<div>
    @auth
        @include('partials.app-header')

        <section class="bg-white py-12">
            <div class="mx-auto max-w-3xl px-4">
                <div class="text-center">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        {{ $course->name }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ $course->description }}
                    </p>
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs">

                            <span class="rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-teal-700">
                                {{ $course->category->name }}
                            </span>
                    </div>
                </div>

                <div class="mt-8 space-y-6">
                    <div class="rounded-xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
                        <div class="flex items-center justify-between text-xs font-semibold text-gray-700">
                            <span>{{ __('courses.matching') }}</span>
                            <span>{{ $matchPercent }}%</span>
                        </div>
                        <div class="mt-3 h-2 w-full rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-teal-500" style="width: {{ $matchPercent }}%"></div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-gray-700">{{ __('courses.content_title') }}</h2>
                        <div class="mt-2 rounded-xl border border-gray-100 bg-white px-6 py-8 text-center text-sm text-gray-500 shadow-sm">
                            <svg class="mx-auto h-6 w-6 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 6.5c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2V18c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V6.5z" />
                                <path d="M9 4v16" />
                            </svg>
                            <p class="mt-2">{{ $course->description }}</p>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-gray-700">{{ __('courses.comments') }}</h2>
                        <div class="mt-2 flex items-center gap-3 rounded-xl border border-gray-100 bg-white px-4 py-3 shadow-sm">
                            <input
                                type="text"
                                class="h-10 w-full border-0 bg-transparent text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0"
                                placeholder="{{ __('courses.comment_placeholder') }}"
                            />
                            <button
                                type="button"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500 text-white shadow-sm transition hover:bg-teal-600"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M3 11.5L21.5 4.5l-7 18-2.5-6.5L3 11.5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
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
