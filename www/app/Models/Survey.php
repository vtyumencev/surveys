<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const IS_HIDDEN          = 0;
    public const IS_DRAFT           = 1;
    public const IS_PUBLISHED       = 2;
    public const IS_PROTECTED       = 3;
    public const IS_PENDING         = 4;

    public const RESERVED_SLUGS = [
        'dashboard',
        'login',
        'admin',
        'home',
        'register',
        'registration',
        'survey',
        'create',
        'edit',
        'reset-password',
        'forgot-password',
        'verify-email',
        'confirm-password',
        'email',
        'logout',
    ];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('position');
    }

    public function scopeIsDraft($query)
    {   
        return $query->where('status_id', $this::IS_DRAFT);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();

            $slug = Str::slug($model->title);

            if (in_array($slug, static::RESERVED_SLUGS)) {
                $slug = 'survey-' . $slug;
            }

            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }
}
