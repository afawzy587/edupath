<header class="border-b bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between gap-4 py-4">
            <div class="flex items-center gap-2 text-teal-600 font-semibold">
                <a wire:navigate href="{{ route('landing-page') }}">
                    <span>{{ env('APP_NAME') }}</span>
                    <span class="text-lg">🎓</span>
                </a>
            </div>

            @php
                $isAssessments = request()->routeIs('student.assessments') || request()->is('*assessments*') || (isset($pageName) && $pageName === 'assessments');
                $isHobbies = request()->routeIs('student.hobbies') || request()->is('*hobbies*') || (isset($pageName) && $pageName === 'hobbies');
                $isCourses = request()->routeIs('student.courses') || request()->is('*courses*');
            @endphp
            <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-600">

                <a wire:navigate href="{{ route('student.assessments') }}"
                   @if ($isAssessments) aria-current="page" @endif
                   class="group inline-flex items-center gap-2 rounded-full px-3 py-2 transition hover:bg-teal-50 hover:text-teal-700 aria-[current=page]:bg-teal-600 aria-[current=page]:text-white">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-teal-100 text-teal-700 transition group-aria-[current=page]:bg-white/20 group-aria-[current=page]:text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16v16H4z" />
                            <path d="M4 9h16" />
                        </svg>
                    </span>
                    {{ __('home.nav.assessments') }}
                </a>
                <a wire:navigate href="{{ route('student.hobbies') }}"
                   @if ($isHobbies) aria-current="page" @endif
                   class="group inline-flex items-center gap-2 rounded-full px-3 py-2 transition hover:bg-teal-50 hover:text-teal-700 aria-[current=page]:bg-teal-600 aria-[current=page]:text-white">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-teal-100 text-teal-700 transition group-aria-[current=page]:bg-white/20 group-aria-[current=page]:text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 21s-6-4.5-8-8.5A4.5 4.5 0 0 1 12 6a4.5 4.5 0 0 1 8 6.5C18 16.5 12 21 12 21z" />
                        </svg>
                    </span>
                    {{ __('home.nav.hobbies') }}
                </a>
                <a wire:navigate href="{{ route('student.courses') }}"
                   @if ($isCourses) aria-current="page" @endif
                   class="group inline-flex items-center gap-2 rounded-full px-3 py-2 transition hover:bg-teal-50 hover:text-teal-700 aria-[current=page]:bg-teal-600 aria-[current=page]:text-white">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-teal-100 text-teal-700 transition group-aria-[current=page]:bg-white/20 group-aria-[current=page]:text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 4h14v16H5z" />
                            <path d="M8 4v16" />
                        </svg>
                    </span>
                    {{ __('home.nav.courses') }}
                </a>
            </nav>

            <details class="relative">
                <summary class="list-none cursor-pointer flex items-center gap-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-teal-100 text-teal-700 text-sm font-semibold">
                        {{ strtoupper(mb_substr(auth()->user()->name ?? 'FA', 0, 2)) }}
                    </span>
                </summary>
                <div class="absolute end-0 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        {{ __('home.menu.profile') }}
                    </a>
                    <form method="POST" action="{{ route('student.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-start px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            {{ __('home.menu.logout') }}
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</header>
