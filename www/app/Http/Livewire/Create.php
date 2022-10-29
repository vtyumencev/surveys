<?php

namespace App\Http\Livewire;

use App\Models\Block;
use App\Models\Page;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public $title;

    protected $rules = [
        'title' => 'min:2|max:255'
    ];

    public function mount()
    {
        
    }

    public function render()
    {
        $drafts = Survey::isDraft()->orderBy('created_at', 'DESC')->get();
        return view('livewire.create', compact('drafts'));
    }

    public function submit()
    {
        $this->validate();
        
        $survey = Survey::create([
            'title' => $this->title,
            'lang' => 'en',
            'author_id' => Auth::id()
        ]);

        $page = Page::create([
            'survey_id' => $survey->id,
            'position' => 1,
        ]);

        $block = Block::create([
            'title' => 'First block',
            'page_id' => $page->id,
            'survey_id' => $survey->id,
            'type_id' => 1,
            'position' => 1,
        ]);

        $blocks = [ $block ];

        $page->blocks()->saveMany($blocks);

        return redirect()->route('surveys.create-with-draft', $survey->uuid);
    }

    public function deleteDraft($id)
    {
        Survey::findOrFail($id)->delete();
        $this->emit('draftDeleted', $id);
    }

    public function restoreDraft($id)
    {
        Survey::withTrashed()->findOrFail($id)->restore();
        $this->emit('draftRestored', $id);
    }
}
