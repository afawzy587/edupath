<div>
    @auth
        @include('partials.app-header')

        @if (session()->has('success'))
            <div class="flash-success fixed left-4 right-4 top-4 z-50 max-w-sm px-4 sm:left-auto sm:right-4">
                <div class="rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-teal-800 shadow-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <section class="bg-white py-12">
            <div class="mx-auto max-w-3xl px-4">
                <div class="text-center">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        {{ $course->name }}
                    </h1>
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
                                    @if($course->video)
                                        <div class="mx-auto mb-4 overflow-hidden rounded-lg border border-gray-200">
                                            <video class="h-full w-full" controls playsinline src="{{ $course->video_path }}"></video>
                                        </div>
                                    @endif
                                    @if($course->image)
                                        <img
                                            src="{{ $course->image_path }}"
                                            alt="{{ $course->name }}"
                                            class="mx-auto h-50 w-50 rounded-lg object-cover"

                                        >
                                    @endif
                                    @if(!$course->video && !$course->image)
                                        <svg class="mx-auto h-6 w-6 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M4 6.5c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2V18c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V6.5z" />
                                            <path d="M9 4v16" />
                                        </svg>
                                    @endif
                                    <p class="mt-2 mx-auto max-w-2xl break-words">{{ $course->description }}</p>
                            </div>



                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-gray-700">{{ __('courses.comments') }}</h2>
                        <div class="mt-2 rounded-xl border border-gray-100 bg-white px-4 py-4 shadow-sm">
                            <textarea
                                wire:model.defer="reviewBody"
                                rows="3"
                                class="w-full resize-none border-0 bg-transparent text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-0"
                                placeholder="{{ __('courses.comment_placeholder') }}"
                            ></textarea>
                            @error('reviewBody')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-3 flex items-center justify-between">
                                <button
                                    type="button"
                                    wire:click="saveReview"
                                    class="inline-flex items-center justify-center rounded-lg bg-teal-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-teal-600"
                                >
                                    {{ $userReview ? __('courses.update') : __('courses.send') }}
                                </button>
                                @if ($userReview)
                                    <button
                                        type="button"
                                        wire:click="deleteReview"
                                        class="text-xs font-semibold text-gray-500 transition hover:text-red-600"
                                    >
                                        {{ __('courses.delete') }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 space-y-4">
                            @forelse ($reviews as $review)
                                <div class="rounded-xl border border-gray-100 bg-white px-4 py-3 shadow-sm">
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>{{ $review->user?->name ?? __('courses.anonymous') }}</span>
                                        <div class="flex items-center gap-2">
                                            @if (auth()->check() && $review->user_id === auth()->id())
                                                <span class="rounded-full bg-teal-50 px-2 py-0.5 text-[10px] font-semibold text-teal-700">
                                                    {{ __('courses.your_review') }}
                                                </span>
                                            @endif
                                            <span>{{ $review->created_at?->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-700">{{ $review->body }}</p>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">
                                    {{ __('courses.no_reviews') }}
                                </div>
                            @endforelse
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
