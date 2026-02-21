<header class="border-b border-gray-100 bg-white">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-wrap items-center justify-between gap-4 py-4">
            <div class="flex items-center gap-2 text-teal-600 font-semibold">
                <a wire:navigate href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span>{{ env('APP_NAME') }}</span>
                    <span class="text-lg">🛠️</span>
                </a>
            </div>

            <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                <a wire:navigate href="{{ route('admin.dashboard') }}"
                   class="group inline-flex items-center gap-2 rounded-full px-3 py-2 transition hover:bg-teal-50 hover:text-teal-700 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : '' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-teal-100 text-teal-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : '' }}">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 13h8V3H3z" />
                            <path d="M13 21h8V11h-8z" />
                            <path d="M13 3h8v6h-8z" />
                            <path d="M3 17h8v4H3z" />
                        </svg>
                    </span>
                    Dashboard
                </a>
                <a wire:navigate href="{{ route('landing-page') }}"
                   class="inline-flex items-center gap-2 rounded-full px-3 py-2 transition hover:bg-gray-100 hover:text-gray-800">
                    Back to Site
                </a>
            </nav>

            <details class="relative">
                <summary class="list-none cursor-pointer flex items-center gap-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-teal-100 text-teal-700 text-sm font-semibold">
                        {{ strtoupper(mb_substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                    </span>
                </summary>
                <div class="absolute end-0 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg">
                    <span class="block px-4 py-2 text-xs text-gray-500">
                        Admin account
                    </span>
                    <form method="POST" action="{{ route('student.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-start px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</header>
