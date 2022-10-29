<?php

namespace App\Http\Livewire;

use App\Models\Block;
use App\Models\Page;
use App\Models\Survey;
use App\Models\Type;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Builder extends Component
{

    public $survey;

    public $draft_id;

    public $currentPagePosition = 1;

    protected $queryString = ['draft_id'];

    protected $listeners = [
        'surveyUpdated',
        'newBlockAdded'
    ];

    protected $rules = [
        'survey.title' => 'required',
        'survey.slug' => 'required',
    ];

    public function mount()
    {
        $this->survey = Survey::where('uuid', $this->draft_id)
            ->firstOrFail();
    }

    public function updated()
    {
        $validatedData = $this->validate([
            'survey.title' => 'required|min:2|max:255',
            'survey.slug' => [
                'required',
                'min:2',
                'max:255',
                'Regex:/^[\d\w\-\_]+$/u',
                'unique:surveys,slug,' . $this->survey->id,
                Rule::notIn(Survey::RESERVED_SLUGS),
            ],
        ],
        [
            'survey.slug.not_in' => 'This slug is reserved.'
        ]);

        $this->survey->save();
    }

    public function newBlockAdded($typeID, $position)
    {
        $this->createBlock($typeID, $position);
    }

    public function createBlock($typeID, $position = null)
    {
        if (isset($position)) {
            Block::where('page_id', $this->survey->pages[$this->currentPagePosition - 1]->id)
                ->where('position', '>', $position)
                ->increment('position');
        } else {
            $position = 0;
        }
        $block = Block::create([
            'title' => '',
            'survey_id' => $this->survey->id,
            'page_id' => $this->survey->pages[$this->currentPagePosition - 1]->id,
            'type_id' => $typeID,
            'position' => $position + 1,
        ]);

        //$this->survey->pages[$this->currentPagePosition - 1]->blocks()->save($block);
        $this->emit('refreshPage');
    }

    public function deleteBlock($id)
    {
        Block::findOrFail($id)->delete();
        $this->page->refresh();
        //$this->emitUp('surveyUpdated');
    } 

    public function createPage()
    {
        Page::where('survey_id', $this->survey->id)
            ->where('position', '>', $this->currentPagePosition)
            ->increment('position');

        $page = Page::create([
            'survey_id' => $this->survey->id,
            'position' => $this->currentPagePosition + 1,
        ]);

        $this->currentPagePosition = $this->currentPagePosition + 1;

        $this->survey = Survey::findOrFail($this->survey->id);
    }

    public function duplicateCurrentPage()
    {
        Page::where('survey_id', $this->survey->id)
            ->where('position', '>', $this->currentPagePosition)
            ->increment('position');

        $duplicatePage = $this->survey->pages[$this->currentPagePosition - 1]->replicate();
        $duplicatePage->title = $duplicatePage->title . ' - Copy';
        $duplicatePage->position = $this->currentPagePosition + 1;
        $duplicatePage->save();

        $this->currentPagePosition = $duplicatePage->position;
        $this->survey = $duplicatePage->survey;

        //dd($this->currentPagePosition);
    }

    public function removeCurrentPage()
    {
        if (count($this->survey->pages) === 1) {
            return;
        }

        $this->survey->pages[$this->currentPagePosition - 1]->delete();
        $this->survey = Survey::findOrFail($this->survey->id);
        $this->currentPagePosition = count($this->survey->pages);

        $this->_updatePagePositions();
    }

    public function render()
    {
        return view('livewire.builder');
    }

    protected function _updatePagePositions()
    {
        foreach ($this->survey->pages as $key => $page) {
            $page->position = $key + 1;
            $page->save();
        }
    }

    public function surveyUpdated()
    {
        $this->survey->touch();
    }
}
