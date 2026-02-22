<div class="min-h-screen flex items-center justify-center bg-gray-50">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-teal-600">
                {{ __('auth.brand') }}
            </h1>
        </div>

        <!-- Card -->
        <div class="bg-white shadow rounded-xl p-8">

            <h2 class="text-center text-lg font-bold">
                {{ __('auth.login.welcome') }}
            </h2>

            <p class="text-center text-gray-500 text-sm mb-6">
                {{ __('auth.login.subtitle') }}
            </p>

            <form wire:submit.prevent="login" class="space-y-4">

                <!-- Email -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.login.email') }}
                    </label>

                    <input
                        type="email"
                        wire:model.defer="email"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                        placeholder="{{ __('auth.login.email_placeholder') }}"
                    >

                    @error('email')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.login.password') }}
                    </label>

                    <input
                        type="password"
                        wire:model.defer="password"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                    >

                    @error('password')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition"
                >
                    <span wire:loading.remove>
                        {{ __('auth.login.submit') }}
                    </span>

                    <span wire:loading>
                        {{ __('auth.login.loading') }}
                    </span>
                </button>

            </form>

            <!-- Register Link -->
            <p class="text-center text-sm text-gray-500 mt-6">
                {{ __('auth.login.no_account') }}
                <a wire:navigate href="{{ route('student.register') }}" class="text-teal-600 font-semibold">
                    {{ __('auth.login.create_account') }}
                </a>
            </p>

        </div>
    </div>

</div>
