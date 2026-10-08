<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-600 text-white shadow-xs">
                        <flux:icon name="shield-check" class="size-5" />
                    </span>
                    <h1 class="cafe-page-title">{{ __('Audit Logs') }}</h1>
                </div>
                <p class="cafe-page-subtitle">{{ __('A chronological record of changes made across the system') }}</p>
            </div>
        </div>

        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <flux:field class="lg:col-span-1">
                    <flux:input wire:model.live="search" placeholder="{{ __('Search event, entity, user...') }}" icon="magnifying-glass" />
                </flux:field>
                <flux:field>
                    <flux:select wire:model.live="eventFilter">
                        <flux:select.option value="">{{ __('All events') }}</flux:select.option>
                        @foreach($events as $event)
                            <flux:select.option value="{{ $event }}">{{ $event }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
                <flux:field>
                    <flux:input type="date" wire:model.live="dateFrom" label="{{ __('From') }}" />
                </flux:field>
                <flux:field>
                    <flux:input type="date" wire:model.live="dateTo" label="{{ __('To') }}" />
                </flux:field>
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            @if($logs->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 dark:bg-slate-900/40 dark:text-slate-300">
                        <flux:icon name="shield-check" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No audit entries found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Changes made across the system will appear here.') }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Date') }}</th>
                                <th class="cafe-th">{{ __('Event') }}</th>
                                <th class="cafe-th">{{ __('Entity') }}</th>
                                <th class="cafe-th">{{ __('Actor') }}</th>
                                <th class="cafe-th">{{ __('Changes') }}</th>
                                <th class="cafe-th">{{ __('IP Address') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($logs as $log)
                                @php
                                    $eventStyles = [
                                        'created' => ['cls' => 'border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300', 'dot' => 'bg-emerald-500', 'icon' => 'check-circle'],
                                        'stock_in' => ['cls' => 'border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300', 'dot' => 'bg-emerald-500', 'icon' => 'arrow-down-circle'],
                                        'updated' => ['cls' => 'border-sky-200/80 bg-sky-50 text-sky-700 dark:border-sky-800/40 dark:bg-sky-950/70 dark:text-sky-300', 'dot' => 'bg-sky-500', 'icon' => 'pencil-square'],
                                        'adjustment' => ['cls' => 'border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300', 'dot' => 'bg-amber-500', 'icon' => 'adjustments-horizontal'],
                                        'archived' => ['cls' => 'border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300', 'dot' => 'bg-rose-500', 'icon' => 'archive-box'],
                                        'stock_out' => ['cls' => 'border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300', 'dot' => 'bg-rose-500', 'icon' => 'arrow-up-circle'],
                                    ];
                                    $s = $eventStyles[$log->event] ?? ['cls' => 'border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300', 'dot' => 'bg-stone-400', 'icon' => 'clock'];
                                    $entityName = \Illuminate\Support\Str::afterLast(class_basename($log->auditable_type), '\\');
                                @endphp
                                <tr class="cafe-tr">
                                    <td class="cafe-td whitespace-nowrap">
                                        <div class="text-[#0D3326] dark:text-emerald-100">{{ $log->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-stone-400 dark:text-emerald-300/50">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="cafe-td">
                                        <span class="cafe-status-pill {{ $s['cls'] }}">
                                            <flux:icon name="{{ $s['icon'] }}" class="size-3" />
                                            {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="cafe-td">
                                        <div class="flex items-center gap-2">
                                            <span class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-[#F2EFEA] text-stone-500 dark:bg-emerald-950/50 dark:text-emerald-300">
                                                <flux:icon name="document" class="size-3.5" />
                                            </span>
                                            <div>
                                                <div class="font-mono text-xs font-medium text-stone-700 dark:text-stone-200">{{ $entityName }}</div>
                                                <div class="text-xs text-stone-400 dark:text-emerald-300/50">#{{ $log->auditable_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cafe-td">
                                        <div class="flex items-center gap-2">
                                            <span class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-[11px] font-bold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                                {{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}
                                            </span>
                                            <span class="text-stone-600 dark:text-stone-300">{{ $log->user?->name ?? __('System') }}</span>
                                        </div>
                                    </td>
                                    <td class="cafe-td">
                                        @if($log->old_values || $log->new_values)
                                            <details class="group">
                                                <summary class="cursor-pointer inline-flex items-center gap-1.5 rounded-lg border border-[#EFEAE3] bg-[#FAF8F5] px-2.5 py-1 text-xs font-medium text-stone-600 hover:text-emerald-800 dark:border-emerald-900/30 dark:bg-emerald-950/40 dark:text-emerald-300 dark:hover:text-emerald-200">
                                                    <flux:icon name="arrow-path" class="size-3" />
                                                    {{ $log->old_values ? count($log->old_values) : 0 }} → {{ $log->new_values ? count($log->new_values) : 0 }} {{ __('fields') }}
                                                </summary>
                                                <pre class="mt-2 max-w-sm overflow-x-auto rounded-xl border border-[#EFEAE3] bg-stone-50 p-3 text-xs text-stone-700 dark:border-emerald-900/30 dark:bg-emerald-950/30 dark:text-emerald-300">{{ json_encode(['old' => $log->old_values, 'new' => $log->new_values], JSON_PRETTY_PRINT) }}</pre>
                                            </details>
                                        @else
                                            <span class="text-xs text-stone-400 dark:text-emerald-300/40">—</span>
                                        @endif
                                    </td>
                                    <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $log->ip_address ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-t border-[#F1EDE6] px-4 py-4 dark:border-emerald-950/30">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>