<div>
    @auth
        @include('partials.app-header')

        <section class="bg-slate-50 py-16">
            <div class="max-w-6xl mx-auto px-4">
                <div class="rounded-3xl bg-gradient-to-b from-white to-teal-50 border border-teal-100 px-6 py-16 text-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-teal-100 text-teal-700 px-4 py-1 text-sm">
                        ✨ {{ __('home.badge') }}
                    </span>

                    <h1 class="mt-6 text-3xl md:text-4xl font-bold text-gray-900">
                        {{ __('home.hero_title') }}
                        <span class="text-teal-600">{{ __('home.hero_title_highlight') }}</span>
                    </h1>

                    <p class="mt-4 text-gray-600">
                        {{ __('home.hero_subtitle') }}
                    </p>

                    <button class="mt-8 inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-white hover:bg-teal-700">
                        {{ __('home.hero_cta') }}
                    </button>
                </div>
            </div>
        </section>

        <section class="py-10">
            <div class="max-w-6xl mx-auto px-4 grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600 text-xl">📘</div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('home.cards.smart_courses.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('home.cards.smart_courses.body') }}</p>
                    <a href="#" class="mt-4 inline-flex items-center text-sm text-teal-600 hover:text-teal-700">
                        {{ __('home.cards.learn_more') }}
                    </a>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600 text-xl">❤️</div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('home.cards.hobby_assessment.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('home.cards.hobby_assessment.body') }}</p>
                    <a href="#" class="mt-4 inline-flex items-center text-sm text-teal-600 hover:text-teal-700">
                        {{ __('home.cards.learn_more') }}
                    </a>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 text-center">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600 text-xl">📋</div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('home.cards.holland_test.title') }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ __('home.cards.holland_test.body') }}</p>
                    <a href="#" class="mt-4 inline-flex items-center text-sm text-teal-600 hover:text-teal-700">
                        {{ __('home.cards.learn_more') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="max-w-4xl mx-auto px-4">
                <div class="flex flex-wrap justify-center gap-16 text-center text-teal-600 font-semibold text-2xl">
                    <div>
                        2
                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.assessment_types') }}</p>
                    </div>
                    <div>
                        30+
                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.career_paths') }}</p>
                    </div>
                    <div>
                        AI
                        <p class="text-sm font-normal text-gray-500">{{ __('home.stats.smart_matching') }}</p>
                    </div>
                </div>
            </div>
        </section>
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
