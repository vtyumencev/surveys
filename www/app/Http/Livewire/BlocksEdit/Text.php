<?php

namespace App\Http\Livewire\BlocksEdit;

use Livewire\Component;

class Text extends Component
{
    public $block;

    protected $rules = [
        'block.content' => 'nullable'
    ];

    public function mount($block)
    {
        $this->block = $block;
    }

    public function updated()
    {
        $this->block->save();
        $this->emitUp('surveyUpdated');
    }

    public function render()
    {
        return view('livewire.blocks-edit.text');
    }
}
