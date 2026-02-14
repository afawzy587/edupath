<div>
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
            @auth
                <form method="POST" action="{{ route('student.logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700">
                        {{ __('landing.logout') }}
                    </button>
                </form>
                @else
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700">
                    {{ __('landing.hero.cta') }}
                </a>
            @endauth

        </div>
    </section>

    <section id="features" class="py-16">
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto px-4">
            <div class="bg-white shadow rounded-xl p-6 text-center">
                <div class="text-3xl mb-3">📚</div>
                <h3 class="font-bold text-lg">{{ __('landing.features.smart_courses.title') }}</h3>
                <p class="text-gray-500 mt-2">
                    {{ __('landing.features.smart_courses.body') }}
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 text-center">
                <div class="text-3xl mb-3">❤️</div>
                <h3 class="font-bold text-lg">{{ __('landing.features.hobby_assessment.title') }}</h3>
                <p class="text-gray-500 mt-2">
                    {{ __('landing.features.hobby_assessment.body') }}
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-6 text-center">
                <div class="text-3xl mb-3">📋</div>
                <h3 class="font-bold text-lg">{{ __('landing.features.holland_test.title') }}</h3>
                <p class="text-gray-500 mt-2">
                    {{ __('landing.features.holland_test.body') }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 text-center">
        <div class="flex justify-center gap-20 text-teal-600 font-bold text-2xl">
            <div>
                2
                <p class="text-gray-500 text-sm font-normal">
                    {{ __('landing.stats.assessment_types') }}
                </p>
            </div>

            <div>
                30+
                <p class="text-gray-500 text-sm font-normal">
                    {{ __('landing.stats.career_paths') }}
                </p>
            </div>

            <div>
                AI
                <p class="text-gray-500 text-sm font-normal">
                    {{ __('landing.stats.smart_matching') }}
                </p>
            </div>
        </div>
    </section>
</div>
