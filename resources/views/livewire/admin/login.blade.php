<div class="min-h-screen bg-slate-50">
    <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10">
        <div class="grid w-full gap-8 lg:grid-cols-[1.2fr_1fr]">
            <div class="hidden flex-col justify-center rounded-3xl border border-teal-100 bg-gradient-to-br from-white via-white to-teal-50 p-10 lg:flex">
                <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.login.portal') }}</p>
                <h1 class="mt-3 text-3xl font-bold text-gray-900">{{ __('admin.login.headline') }}</h1>
                <p class="mt-4 text-sm text-gray-600">
                    {{ __('admin.login.subhead') }}
                </p>
                <div class="mt-8 grid gap-4">
                    <div class="rounded-2xl border border-teal-100 bg-white px-4 py-4 shadow-sm">
                        <p class="text-sm font-semibold text-gray-900">{{ __('admin.login.insight_title') }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ __('admin.login.insight_body') }}</p>
                    </div>
                    <div class="rounded-2xl border border-teal-100 bg-white px-4 py-4 shadow-sm">
                        <p class="text-sm font-semibold text-gray-900">{{ __('admin.login.workflow_title') }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ __('admin.login.workflow_body') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.login.welcome_badge') }}</p>
                    <h2 class="mt-2 text-2xl font-bold text-gray-900">{{ __('admin.login.title') }}</h2>
                    <p class="mt-2 text-sm text-gray-500">{{ __('admin.login.subtitle') }}</p>
                </div>

                <form wire:submit.prevent="login" class="mt-8 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('auth.login.email') }}
                        </label>
                        <input
                            type="email"
                            wire:model.defer="email"
                            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200"
                            placeholder="{{ __('admin.login.email_placeholder') }}"
                        >
                        @error('email')
                            <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('auth.login.password') }}
                        </label>
                        <input
                            type="password"
                            wire:model.defer="password"
                            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200"
                        >
                        @error('password')
                            <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" wire:model.defer="remember" class="h-4 w-4 rounded border-gray-300">
                        {{ __('admin.login.remember') }}
                    </label>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-teal-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-teal-700"
                    >
                        <span wire:loading.remove>
                            {{ __('auth.login.submit') }}
                        </span>
                        <span wire:loading>
                            {{ __('auth.login.loading') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
