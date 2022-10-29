<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const TYPES = [
        [],
        [
            'name' => 'Header',
            'component_edit' => 'blocks-edit.header',
            'component_show' => 'blocks-show.header',
        ],
        [
            'name' => 'Text',
            'component_edit' => 'blocks-edit.text',
            'component_show' => 'blocks-show.text',
        ],
        [
            'name' => 'Image',
            'component_edit' => 'blocks-edit.header',
            'component_show' => 'blocks-show.header',
        ],
        [
            'name' => 'Multiply Choice',
            'component_edit' => 'blocks-edit.header',
            'component_show' => 'blocks-show.header',
        ],
        [
            'name' => 'Checkboxes',
            'component_edit' => 'blocks-edit.header',
            'component_show' => 'blocks-show.header',
        ],
        [
            'name' => 'Textbox',
            'component_edit' => 'blocks-edit.header',
            'component_show' => 'blocks-show.header',
        ],
    ];

    public function type()
    {
        return $this->BelongsTo(Type::class);
    }
}
