<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\HollandCareerSuggestion;
use Livewire\Component;

class HollandCareerSuggestions extends Component
{
    public array $items = [];

    public function mount(): void
    {
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $this->items = HollandCareerSuggestion::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn (HollandCareerSuggestion $item) => [
                'id' => $item->id,
                'code' => $item->code,
                'title' => $item->title,
                'description' => $item->description,
                'majors' => $item->majors,
                'sort_order' => $item->sort_order,
            ])
            ->toArray();
    }

    public function save(int $index): void
    {
        $data = $this->items[$index] ?? null;

        if (! $data) {
            return;
        }

        $suggestion = HollandCareerSuggestion::find($data['id']);

        if (! $suggestion) {
            return;
        }

        $suggestion->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'majors' => $data['majors'],
            'sort_order' => $data['sort_order'],
        ]);

        $this->dispatch('notify', message: __('admin.holland_career.save_success'));
    }

    public function render()
    {
        return view('livewire.admin.holland-career-suggestions')
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-holland-career-suggestions']);
    }
}

