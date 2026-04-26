<aside class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('admin.sidebar.title') }}</p>
    <nav class="mt-4 space-y-2 text-sm text-gray-600">
        <a wire:navigate href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 13h8V3H3z" />
                    <path d="M13 21h8V11h-8z" />
                    <path d="M13 3h8v6h-8z" />
                    <path d="M3 17h8v4H3z" />
                </svg>
            </span>
            {{ __('admin.sidebar.dashboard') }}
        </a>
        <a wire:navigate href="{{ route('admin.courses.index') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.courses.*') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.courses.*') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 4h14v16H5z" />
                    <path d="M8 4v16" />
                </svg>
            </span>
            {{ __('admin.sidebar.courses') }}
        </a>
        <a wire:navigate href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.categories.*') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16" />
                    <path d="M4 12h16" />
                    <path d="M4 18h16" />
                </svg>
            </span>
            {{ __('admin.sidebar.categories') }}
        </a>
        <a wire:navigate href="{{ route('admin.questions.index') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.questions.*') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.questions.*') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 6h14" />
                    <path d="M5 12h14" />
                    <path d="M5 18h9" />
                </svg>
            </span>
            {{ __('admin.sidebar.questions') }}
        </a>
        <a wire:navigate href="{{ route('admin.landing-page-settings') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.landing-page-settings') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.landing-page-settings') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 8a5 5 0 0 1 0 8" />
                    <path d="M19 5a9 9 0 0 1 0 14" />
                    <path d="M3 12h.01" />
                    <path d="M7 12h.01" />
                    <path d="M11 12h.01" />
                </svg>
            </span>
            {{ __('admin.sidebar.landing_page') }}
        </a>
        <a wire:navigate href="{{ route('admin.holland-career-suggestions') }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.holland-career-suggestions') ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.holland-career-suggestions') ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </span>
            {{ __('admin.sidebar.holland_career') }}
        </a>
        <a wire:navigate href="{{ route('admin.reports.show', ['type' => 'hobbies']) }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.reports.show') && request()->route('type') === 'hobbies' ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.reports.show') && request()->route('type') === 'hobbies' ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="8.5" cy="7" r="4" />
                    <path d="M20 8v6" />
                    <path d="M23 11h-6" />
                </svg>
            </span>
            {{ __('admin.sidebar.hobbies_report') }}
        </a>
        <a wire:navigate href="{{ route('admin.reports.show', ['type' => 'assessments']) }}"
           class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ request()->routeIs('admin.reports.show') && request()->route('type') === 'assessments' ? 'bg-teal-600 text-white' : 'hover:bg-teal-50 hover:text-teal-700' }}">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-teal-700 {{ request()->routeIs('admin.reports.show') && request()->route('type') === 'assessments' ? 'bg-white/20 text-white' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16" />
                    <path d="M4 12h16" />
                    <path d="M4 18h8" />
                </svg>
            </span>
            {{ __('admin.sidebar.assessments_report') }}
        </a>
    </nav>
    <div class="mt-6 border-t border-gray-100 pt-4">
        <form method="POST" action="{{ route('student.logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm text-red-600 transition hover:bg-red-50">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg>
                </span>
                {{ __('admin.sidebar.logout') }}
            </button>
        </form>
    </div>
</aside>
