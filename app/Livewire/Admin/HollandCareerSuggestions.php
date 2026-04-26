<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\HollandCareerSuggestion;
use Livewire\Component;

class HollandCareerSuggestions extends Component
{
    public array $items = [];

    public bool $showForm = false;

    public array $newItem = [
        'code' => '',
        'title' => '',
        'description' => '',
        'majors' => '',
        'sort_order' => 0,
    ];

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

    public function add(): void
    {
        $this->validate([
            'newItem.code' => 'required|string|size:1|unique:holland_career_suggestions,code',
            'newItem.title' => 'required|string|max:255',
            'newItem.description' => 'required|string',
            'newItem.majors' => 'required|string',
            'newItem.sort_order' => 'required|integer|min:0',
        ], [], [
            'newItem.code' => __('admin.holland_career.code_label'),
            'newItem.title' => __('admin.holland_career.title_label'),
            'newItem.description' => __('admin.holland_career.description_label'),
            'newItem.majors' => __('admin.holland_career.majors_label'),
            'newItem.sort_order' => __('admin.holland_career.sort_label'),
        ]);

        HollandCareerSuggestion::create($this->newItem);

        $this->reset('newItem');
        $this->showForm = false;
        $this->loadItems();

        $this->dispatch('notify', message: __('admin.holland_career.add_success'));
    }

    public function delete(int $id): void
    {
        $suggestion = HollandCareerSuggestion::find($id);

        if (! $suggestion) {
            return;
        }

        $suggestion->delete();
        $this->loadItems();

        $this->dispatch('notify', message: __('admin.holland_career.delete_success'));
    }

    public function render()
    {
        return view('livewire.admin.holland-career-suggestions')
            ->layout('layouts.app')
            ->layoutData(['pageName' => 'admin-holland-career-suggestions']);
    }
}

