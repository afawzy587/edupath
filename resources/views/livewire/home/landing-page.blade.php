<div>
    @auth
        @include('partials.app-header')

        <section class="bg-white py-10">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-lg font-semibold text-gray-900">{{ __('home.explore.title') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ __('home.explore.subtitle') }}</p>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-xs text-gray-600">
                    @foreach(__('home.explore.filters') as $filter)
                        <span class="rounded-full border px-3 py-1 shadow-sm transition {{ $loop->first ? 'border-teal-200 bg-teal-50 text-teal-700' : 'border-gray-200 bg-white hover:border-teal-200 hover:text-teal-700' }}">
                            {{ $filter }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-center">
                    <div class="relative w-72 sm:w-80">
                        <div class="relative h-[430px] overflow-hidden rounded-3xl bg-gradient-to-b from-slate-300 via-slate-200 to-slate-100 shadow-lg">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.25),transparent_45%)]"></div>
                            <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/70"></div>
                            <span class="absolute top-3 start-3 rounded-full bg-black/50 px-2 py-1 text-[10px] font-semibold text-white">
                                {{ __('home.explore.card.progress') }}
                            </span>
                            <div class="absolute inset-x-0 bottom-0 p-5 text-start text-white">
                                <h3 class="text-base font-semibold">{{ __('home.explore.card.title') }}</h3>
                                <p class="mt-1 text-xs text-white/80">
                                    {{ __('home.explore.card.subtitle') }}
                                </p>
                                <span class="mt-3 inline-flex rounded-full border border-white/20 bg-white/15 px-3 py-1 text-[11px]">
                                    {{ __('home.explore.card.tag') }}
                                </span>
                            </div>
                        </div>

                        <div class="absolute start-3 top-24 flex flex-col gap-3">
                            <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/80 text-slate-600 shadow-sm transition hover:bg-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M12 21s-6-4.5-8-8.5A4.5 4.5 0 0 1 12 6a4.5 4.5 0 0 1 8 6.5C18 16.5 12 21 12 21z" />
                                </svg>
                            </button>
                            <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/80 text-slate-600 shadow-sm transition hover:bg-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15a4 4 0 0 1-4 4H8l-5 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z" />
                                </svg>
                            </button>
                            <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/80 text-slate-600 shadow-sm transition hover:bg-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M6 4h12a2 2 0 0 1 2 2v14l-8-4-8 4V6a2 2 0 0 1 2-2z" />
                                </svg>
                            </button>
                            <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/80 text-slate-600 shadow-sm transition hover:bg-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M4 12v7a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-7" />
                                    <path d="M12 3v12" />
                                    <path d="M7 8l5-5 5 5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

{{--        <section class="py-12">--}}
{{--            <div class="max-w-4xl mx-auto px-4">--}}
{{--                <div class="flex flex-wrap justify-center gap-16 text-center text-teal-600 font-semibold text-2xl">--}}
{{--                    <div>--}}
{{--                        2--}}
{{--                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.assessment_types') }}</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        30+--}}
{{--                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.career_paths') }}</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        AI--}}
{{--                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.smart_matching') }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
    @endauth

    @guest
        <section class="bg-gradient-to-b from-teal-50 to-white py-20">
            <div class="text-center max-w-3xl mx-auto">
                <span class="bg-teal-100 text-teal-700 px-4 py-1 rounded-full text-sm">
                    {{ __('landing.hero.badge') }}
                </span>

                <h1 class="text-4xl font-bold mt-6">
                    {{ __('landing.hero.title') }}
                    <span class="text-teal-600">{{ __('landing.hero.title_highlight') }}</span>
                </h1>

                <p class="text-gray-600 mt-4">
                    {{ __('landing.hero.subtitle') }}
                </p>
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700">
                    {{ __('landing.hero.cta') }}
                </a>
            </div>
        </section>
    @endguest
</div>
