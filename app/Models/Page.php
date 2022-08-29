<?php

namespace App\Models;

use App\Traits\HasTranslatableContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory, HasTranslations, HasTranslatableContent;

    public array $translatable = ['name', 'slug'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_visible',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PageType::class, 'page_type_id');
    }

    public $translatableContent = [
        'button_text',
        'section_title',
        'section_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];
}
