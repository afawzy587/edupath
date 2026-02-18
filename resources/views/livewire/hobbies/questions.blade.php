<div>
    @auth
        @include('partials.app-header')
        <section class="bg-slate-50 py-12">
            <div class="max-w-4xl mx-auto px-4">
                <div id="save-toast" class="fixed right-6 top-6 z-50 hidden rounded-lg bg-teal-600 px-4 py-3 text-sm text-white shadow-lg" role="status" aria-live="polite">
                    {{ __('hobbies.save_success') }}
                </div>

                <div class="text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ __('hobbies.title') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('hobbies.subtitle') }}
                    </p>
                </div>

                <div class="mt-6 flex items-center justify-between text-sm text-gray-500">
                    <span>{{ __('hobbies.progress') }}</span>
                    <span>{{ $this->currentCount }}/{{ $total }}</span>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-teal-500" style="width: {{ $this->progressPercent }}%"></div>
                </div>

                <div class="mt-8 space-y-4">
                    @foreach ($questions as $index => $question)
                        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                            <p class="font-semibold text-gray-800">
                                {{ ($page - 1) * $perPage + $index + 1 }}. {{ $question['title'] }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach (trans('hobbies.options') as $value => $label)
                                    @php
                                        $isSelected = ($answers[$question['id']] ?? null) === (int) $value;
                                    @endphp
                                    <button
                                        type="button"
                                        wire:click="selectOption({{ $question['id'] }}, {{ $value }})"
                                        class="rounded-full border px-3 py-1 text-xs transition {{ $isSelected ? 'border-teal-600 bg-teal-600 text-white' : 'border-gray-200 text-gray-600 hover:border-teal-200 hover:bg-teal-50 hover:text-teal-700' }}"
                                    >
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex items-center justify-between">
                    <button
                        type="button"
                        wire:click="previousPage"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-5 py-2 text-sm {{ $page <= 1 ? 'text-gray-400' : 'text-gray-700 hover:bg-gray-50' }}"
                        @if ($page <= 1) disabled @endif
                    >
                        ← {{ __('hobbies.previous') }}
                    </button>
                    @if ($page * $perPage >= $total)
                        <button
                            type="button"
                            wire:click="saveHobbies"
                            class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-5 py-2 text-sm text-white hover:bg-teal-700"
                        >
                            {{ __('hobbies.save') }}
                        </button>
                    @else
                        <button
                            type="button"
                            wire:click="nextPage"
                            class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-5 py-2 text-sm text-white hover:bg-teal-700"
                        >
                            {{ __('hobbies.next') }} →
                        </button>
                    @endif
                </div>
                @error('page')
                    <p class="mt-4 text-sm text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>
        </section>
    @endauth

    @guest
        <section class="bg-gradient-to-b from-teal-50 to-white py-20">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('hobbies.login_title') }}</h1>
                <p class="text-gray-600 mt-4">{{ __('hobbies.login_subtitle') }}</p>
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700">
                    {{ __('hobbies.login_cta') }}
                </a>
            </div>
        </section>
    @endguest
</div>
