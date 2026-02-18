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
                {{ __('auth.register.title') }}
            </h2>

            <p class="text-center text-gray-500 text-sm mb-6">
                {{ __('auth.register.subtitle') }}
            </p>

            <form wire:submit.prevent="register" class="space-y-4">

                <!-- Name -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.name') }}
                    </label>

                    <input
                        type="text"
                        wire:model.defer="name"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                        placeholder="{{ __('auth.register.name_placeholder') }}"
                    >

                    @error('name')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.email') }}
                    </label>

                    <input
                        type="email"
                        wire:model.defer="email"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                        placeholder="{{ __('auth.register.email_placeholder') }}"
                    >

                    @error('email')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- School -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.school') }}
                    </label>

                    <input
                        type="text"
                        wire:model.defer="school"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                        placeholder="{{ __('auth.register.school_placeholder') }}"
                    >

                    @error('school')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.gender') }}
                    </label>

                    <select
                        wire:model.defer="gender"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                    >
                        <option value="male">{{ __('auth.register.gender_male') }}</option>
                        <option value="female">{{ __('auth.register.gender_female') }}</option>
                    </select>

                    @error('gender')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Age -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.age') }}
                    </label>

                    <select
                        wire:model.defer="age"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500"
                    >
                        <option value="nine">{{ __('auth.register.age_nine') }}</option>
                        <option value="eleven">{{ __('auth.register.age_eleven') }}</option>
                    </select>

                    @error('age')
                    <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm mb-1">
                        {{ __('auth.register.password') }}
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
                        {{ __('auth.register.submit') }}
                    </span>

                    <span wire:loading>
                        {{ __('auth.register.loading') }}
                    </span>
                </button>

            </form>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-500 mt-6">
                {{ __('auth.register.have_account') }}
                <a wire:navigate href="{{ route('student.login') }}" class="text-teal-600 font-semibold">
                    {{ __('auth.register.login') }}
                </a>
            </p>

        </div>
    </div>

</div>
