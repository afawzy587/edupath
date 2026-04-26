<div class="min-h-screen bg-slate-50">
    @include('partials.admin-header')

    <main class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[220px_1fr] lg:items-start">
            @include('partials.admin-sidebar')

            <div class="space-y-8">
                {{-- Header --}}
                <div class="rounded-3xl border border-teal-100 bg-gradient-to-r from-white via-white to-teal-50 px-6 py-8 md:px-8">
                    <p class="text-sm font-semibold uppercase tracking-wide text-teal-600">{{ __('admin.landing_page.badge') }}</p>
                    <h1 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">{{ __('admin.landing_page.title') }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('admin.landing_page.subtitle') }}</p>
                </div>

                {{-- Video Settings Card --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.landing_page.video_section_title') }}</h2>
                    </div>

                    {{-- Current Video --}}
                    @if ($currentVideo)
                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-sm font-medium text-gray-700 mb-3">{{ __('admin.landing_page.current_video') }}</p>
                            <div class="rounded-lg overflow-hidden border border-gray-200">
                                <video class="w-full max-h-64" controls src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($currentVideo) }}"></video>
                            </div>
                            <form method="POST" action="{{ route('admin.landing-page-settings.destroy') }}" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-100 transition"
                                    onclick="return confirm('{{ __('admin.landing_page.confirm_delete') }}')">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <path d="M10 11v6"/>
                                        <path d="M14 11v6"/>
                                    </svg>
                                    {{ __('admin.landing_page.delete_video') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-4 rounded-xl border border-dashed border-gray-200 bg-gray-50 px-6 py-8 text-center text-sm text-gray-500">
                            {{ __('admin.landing_page.no_video') }}
                        </div>
                    @endif

                    {{-- Upload Form --}}
                    <form method="POST" action="{{ route('admin.landing-page-settings.update') }}" enctype="multipart/form-data" class="mt-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ __('admin.landing_page.video_label') }}</label>
                            <input type="file" name="video" accept="video/mp4,video/quicktime,video/webm,video/ogg" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-teal-700 hover:file:bg-teal-100">
                            <p class="mt-2 text-xs text-gray-400">{{ __('admin.landing_page.video_help') }}</p>
                            @error('video')
                                <span class="mt-2 block text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-teal-700 transition">
                                {{ __('admin.landing_page.upload') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

