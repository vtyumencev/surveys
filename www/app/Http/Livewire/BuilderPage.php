<?php

namespace App\Http\Livewire;

use App\Models\Block;
use App\Models\Page;
use Livewire\Component;

class BuilderPage extends Component
{

    public $page;
    
    public $showPageTitle;

    protected $rules = [
        'page.title' => 'nullable'
    ];

    protected $listeners = ['refreshPage' => '$refresh'];

    public function mount(Page $page)
    {
        $this->page = $page;
    }

    public function updated()
    {
        $this->emitUp('surveyUpdated');
        $this->page->save();
    }

    public function render()
    {
        return view('livewire.builder-page');
    }

    public function deleteBlock($id)
    {
        Block::findOrFail($id)->delete();
        $this->page->refresh();
        $this->_updateBlockPositions();
        $this->emitUp('surveyUpdated');
    } 

    protected function _updateBlockPositions()
    {
        foreach ($this->page->blocks as $key => $block) {
            $block->position = $key + 1;
            $block->save();
        }
    }
}
