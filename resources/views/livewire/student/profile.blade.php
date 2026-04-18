<div>
    @auth
        @include('partials.app-header')

        <section class="bg-slate-50 py-10">
            <div class="mx-auto max-w-6xl space-y-8 px-4">
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ __('profile.title') }}</h1>
                            <p class="mt-1 text-sm text-gray-500">{{ __('profile.subtitle') }}</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            <div>{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.holland.title') }}</h2>

                    @if($hollandChartScores->isNotEmpty())
                        <div class="mt-5 grid gap-6 lg:grid-cols-2">
                            <div class="space-y-3">
                                @foreach($hollandChartScores as $domain)
                                    <div>
                                        <div class="mb-1 flex items-center justify-between text-sm">
                                            <span class="font-medium text-gray-700">{{ $domain['name'] }}</span>
                                            <span class="font-semibold text-teal-700">{{ $domain['percent'] }}%</span>
                                        </div>
                                        <div class="h-2 w-full rounded-full bg-gray-100">
                                            <div class="h-2 rounded-full bg-teal-500" style="width: {{ $domain['percent'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="rounded-xl border border-gray-100 p-4">
                                @php
                                    $centerX = 130;
                                    $centerY = 130;
                                    $radius = 95;
                                    $steps = 6;
                                    $angles = [];
                                    for ($i = 0; $i < $steps; $i++) {
                                        $angles[] = deg2rad(-90 + ($i * 60));
                                    }

                                    $gridLevels = [20, 40, 60, 80, 100];
                                    $polygonPoints = function (int $percent) use ($angles, $centerX, $centerY, $radius): string {
                                        $r = $radius * ($percent / 100);
                                        return collect($angles)->map(function ($angle) use ($centerX, $centerY, $r): string {
                                            $x = $centerX + (cos($angle) * $r);
                                            $y = $centerY + (sin($angle) * $r);
                                            return round($x, 2) . ',' . round($y, 2);
                                        })->implode(' ');
                                    };

                                    $values = collect($hollandHexData)->pad(6, ['percent' => 0, 'name' => ''])->values();
                                    $dataPoints = collect($angles)->map(function ($angle, $index) use ($values, $centerX, $centerY, $radius): string {
                                        $percent = (int) ($values[$index]['percent'] ?? 0);
                                        $r = $radius * ($percent / 100);
                                        $x = $centerX + (cos($angle) * $r);
                                        $y = $centerY + (sin($angle) * $r);
                                        return round($x, 2) . ',' . round($y, 2);
                                    })->implode(' ');
                                @endphp
                                <svg viewBox="0 0 260 260" class="mx-auto h-64 w-64">
                                    @foreach($gridLevels as $level)
                                        <polygon points="{{ $polygonPoints($level) }}" fill="none" stroke="#d1d5db" stroke-width="1" />
                                    @endforeach

                                    @foreach($angles as $angle)
                                        <line
                                            x1="{{ $centerX }}"
                                            y1="{{ $centerY }}"
                                            x2="{{ round($centerX + (cos($angle) * $radius), 2) }}"
                                            y2="{{ round($centerY + (sin($angle) * $radius), 2) }}"
                                            stroke="#e5e7eb"
                                            stroke-width="1"
                                        />
                                    @endforeach

                                    <polygon points="{{ $dataPoints }}" fill="rgba(20, 184, 166, 0.28)" stroke="#0d9488" stroke-width="2" />

                                    @foreach($values as $index => $value)
                                        @php
                                            $labelAngle = $angles[$index];
                                            $labelRadius = $radius + 20;
                                            $labelX = round($centerX + (cos($labelAngle) * $labelRadius), 2);
                                            $labelY = round($centerY + (sin($labelAngle) * $labelRadius), 2);
                                        @endphp
                                        <text x="{{ $labelX }}" y="{{ $labelY }}" text-anchor="middle" class="fill-gray-600" style="font-size: 10px;">
                                            {{ $value['name'] ?? '' }}

                                        </text>
                                    @endforeach
                                </svg>
                            </div>
                        </div>

                        <div class="mt-6 rounded-xl border border-teal-100 bg-teal-50 p-4 text-sm text-gray-700">
                            @php $topInterest = $summary['top_interest']; @endphp
                            @if($topInterest)
                                <div class="font-semibold text-teal-800">{{ __('profile.holland.interpretation_title') }}</div>
                                <p class="mt-1">{{ __('profile.holland.interpretation_text', ['domain' => $topInterest['name']]) }}</p>
{{--                                <p class="mt-1">{{ __('profile.holland.career_text', ['domain' => $topInterest['name']]) }}</p>--}}
                            @endif
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">{{ __('profile.empty_assessment') }}</p>
                    @endif
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.hobbies.title') }}</h2>

                    @if($hobbiesChartScores->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach($hobbiesChartScores as $domain)
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-sm">
                                        <span class="font-medium text-gray-700">{{ $domain['name'] }}</span>
                                        <span class="font-semibold text-cyan-700">{{ $domain['percent'] }}%</span>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-cyan-500" style="width: {{ $domain['percent'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            <div class="mb-2 text-sm font-semibold text-gray-800">{{ __('profile.hobbies.top_3') }}</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($hobbyTopThree as $item)
                                    <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700">
                                        {{ $item['name'] }} ({{ $item['percent'] }}%)
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">{{ __('profile.empty_hobbies') }}</p>
                    @endif
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.summary.title') }}</h2>
                    <div class="mt-3 grid gap-3 md:grid-cols-2">
                        <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4 text-sm">
                            <div class="font-semibold text-indigo-800">{{ __('profile.summary.interests') }}</div>
                            <div class="mt-1 text-gray-700">{{ $summary['top_interest']['name'] ?? __('profile.not_enough_data') }}</div>
                        </div>
                        <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm">
                            <div class="font-semibold text-emerald-800">{{ __('profile.summary.hobbies') }}</div>
                            <div class="mt-1 text-gray-700">{{ $summary['top_hobby']['name'] ?? __('profile.not_enough_data') }}</div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.behavior.title') }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ __('profile.behavior.subtitle') }}</p>

                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $behavior['total_views'] }}</div>
                            <div class="text-xs text-gray-500">{{ __('profile.behavior.views') }}</div>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $behavior['total_likes'] }}</div>
                            <div class="text-xs text-gray-500">{{ __('profile.behavior.likes') }}</div>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $behavior['total_watch_minutes'] }}</div>
                            <div class="text-xs text-gray-500">{{ __('profile.behavior.watch_minutes') }}</div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                        <span class="rounded-full bg-teal-50 px-3 py-1 text-teal-700">{{ __('profile.behavior.most_watched') }}: {{ $behavior['most_watched'] ?? __('profile.not_enough_data') }}</span>
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-amber-700">{{ __('profile.behavior.most_time') }}: {{ $behavior['most_time_spent'] ?? __('profile.not_enough_data') }}</span>
                        <span class="rounded-full bg-rose-50 px-3 py-1 text-rose-700">{{ __('profile.behavior.most_liked') }}: {{ $behavior['most_liked'] ?? __('profile.not_enough_data') }}</span>
                    </div>

                    <div class="mt-5 grid gap-4 lg:grid-cols-2">
                        <div class="rounded-xl border border-gray-100 p-4">
                            <h3 class="mb-3 text-sm font-semibold text-gray-800">{{ __('profile.behavior.watch_chart') }}</h3>
                            <div class="space-y-3">
                                @forelse($behavior['watch_chart'] as $item)
                                    @php $maxWatch = max(1, collect($behavior['watch_chart'])->max('value')); @endphp
                                    <div>
                                        <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                            <span>{{ $item['name'] }}</span>
                                            <span>{{ $item['value'] }} {{ __('profile.behavior.minutes') }}</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-gray-100">
                                            <div class="h-2 rounded-full bg-orange-400" style="width: {{ (int) round(($item['value'] / $maxWatch) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500">{{ __('profile.no_behavior_data') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-100 p-4">
                            <h3 class="mb-3 text-sm font-semibold text-gray-800">{{ __('profile.behavior.views_chart') }}</h3>
                            <div class="space-y-3">
                                @forelse($behavior['views_chart'] as $item)
                                    @php $maxViews = max(1, collect($behavior['views_chart'])->max('value')); @endphp
                                    <div>
                                        <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                            <span>{{ $item['name'] }}</span>
                                            <span>{{ $item['value'] }}</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-gray-100">
                                            <div class="h-2 rounded-full bg-teal-500" style="width: {{ (int) round(($item['value'] / $maxViews) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500">{{ __('profile.no_behavior_data') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.development.title') }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ __('profile.development.subtitle') }}</p>

                    <div class="mt-4 flex gap-2">
                        <button
                            type="button"
                            wire:click="setComparisonTab('interests')"
                            @class([
                                'rounded-full px-4 py-2 text-sm font-semibold',
                                'bg-blue-600 text-white' => $comparisonTab === 'interests',
                                'bg-gray-100 text-gray-700' => $comparisonTab !== 'interests',
                            ])
                        >
                            {{ __('profile.development.interests_tab') }}
                        </button>
                        <button
                            type="button"
                            wire:click="setComparisonTab('hobbies')"
                            @class([
                                'rounded-full px-4 py-2 text-sm font-semibold',
                                'bg-blue-600 text-white' => $comparisonTab === 'hobbies',
                                'bg-gray-100 text-gray-700' => $comparisonTab !== 'hobbies',
                            ])
                        >
                            {{ __('profile.development.hobbies_tab') }}
                        </button>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full overflow-hidden rounded-xl border border-gray-100 text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-center text-xs uppercase tracking-wide text-gray-500">
                                    <th class="px-3 py-3">{{ __('profile.development.domain') }}</th>
                                    <th class="px-3 py-3 text-blue-700">{{ __('profile.development.blue_col') }}</th>
{{--                                    <th class="px-3 py-3 text-green-700">{{ __('profile.development.green_col') }}</th>--}}
                                    <th class="px-3 py-3 text-yellow-700">{{ __('profile.development.yellow_col') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($comparisonRows as $row)
                                    <tr>
                                        <td class="px-3 py-3 font-medium text-gray-800">{{ $row['name'] }}</td>
                                        <td class="px-3 py-3">
                                            <div class="rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">{{ $row['blue_percent'] }}%</div>
                                        </td>
{{--                                        <td class="px-3 py-3">--}}
{{--                                            <div class="rounded bg-green-50 px-2 py-1 text-xs text-green-700">--}}
{{--                                                {{ $row['green_percent'] }}% · {{ __('profile.development.enrolled') }} {{ $row['enrolled_count'] }} · {{ __('profile.development.comments') }} {{ $row['completed_count'] }}--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
                                        <td class="px-3 py-3">
                                            <div class="rounded bg-yellow-50 px-2 py-1 text-xs text-yellow-700">
                                                {{ $row['yellow_percent'] }}% · {{ __('profile.behavior.views') }} {{ $row['views_count'] }} · {{ __('profile.behavior.likes') }} {{ $row['likes_count'] }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">{{ __('profile.no_comparison_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endauth

    @guest
        <section class="bg-gradient-to-b from-teal-50 to-white py-20">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('courses.login_title') }}</h1>
                <p class="mt-4 text-gray-600">{{ __('courses.login_subtitle') }}</p>
                <a wire:navigate href="{{ route('student.login') }}" class="mt-8 inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-white hover:bg-teal-700">
                    {{ __('courses.login_cta') }}
                </a>
            </div>
        </section>
    @endguest
</div>
