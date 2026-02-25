<header class="border-b bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between gap-4 py-3">
            <a wire:navigate href="{{ route('landing-page') }}" class="inline-flex items-center gap-2 text-teal-600 font-semibold">
                <span>{{ env('APP_NAME') }}</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 7l9-4 9 4-9 4-9-4z" />
                    <path d="M12 11v6" />
                    <path d="M5 10v4c0 2 3 4 7 4s7-2 7-4v-4" />
                </svg>
            </a>

            @php
                $isExplore = request()->routeIs('landing-page') || request()->is('/') || (isset($pageName) && $pageName === 'landing');
                $isAssessments = request()->routeIs('student.assessments') || request()->is('*assessments*') || (isset($pageName) && $pageName === 'assessments');
                $isHobbies = request()->routeIs('student.hobbies') || request()->is('*hobbies*') || (isset($pageName) && $pageName === 'hobbies');
                $isCourses = request()->routeIs('student.courses') || request()->is('*courses*');
            @endphp
            <nav class="flex flex-1 flex-wrap items-center justify-center gap-6 text-sm text-gray-600">
                <a wire:navigate href="{{ route('student.assessments') }}"
                   @if ($isAssessments) aria-current="page" @endif
                   class="inline-flex items-center gap-2 transition hover:text-teal-700 aria-[current=page]:text-teal-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16" />
                        <path d="M4 12h10" />
                        <path d="M4 18h16" />
                        <path d="M16 12l2 2 3-3" />
                    </svg>
                    {{ __('home.nav.assessments') }}
                </a>
                <a wire:navigate href="{{ route('student.hobbies') }}"
                   @if ($isHobbies) aria-current="page" @endif
                   class="inline-flex items-center gap-2 transition hover:text-teal-700 aria-[current=page]:text-teal-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 21s-6-4.5-8-8.5A4.5 4.5 0 0 1 12 6a4.5 4.5 0 0 1 8 6.5C18 16.5 12 21 12 21z" />
                    </svg>
                    {{ __('home.nav.hobbies') }}
                </a>
                <a wire:navigate href="{{ route('student.courses') }}"
                   @if ($isCourses) aria-current="page" @endif
                   class="inline-flex items-center gap-2 transition hover:text-teal-700 aria-[current=page]:text-teal-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 4h14v16H5z" />
                        <path d="M8 4v16" />
                    </svg>
                    {{ __('home.nav.courses') }}
                </a>



                <a wire:navigate href="{{ route('landing-page') }}"
                   @if ($isExplore) aria-current="page" @endif
                   class="inline-flex items-center gap-2 transition hover:text-teal-700 aria-[current=page]:text-teal-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M14.8 9.2l-2.3 6-6-2.3 6-2.3 2.3-1.4z" />
                    </svg>
                    {{ __('home.nav.explore') }}
                </a>
                @if (auth()->user()?->isAdmin())
                    <a wire:navigate href="{{ route('admin.dashboard') }}"
                       class="inline-flex items-center gap-2 transition hover:text-gray-800">
                        {{ __('home.nav.admin') }}
                    </a>
                @endif
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
