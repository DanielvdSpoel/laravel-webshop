<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Redirect extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['source', 'destination'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'redirectable_id',
        'redirectable_type',
        'destination',
        'source',
        'status_code',
    ];

    public function redirectable(): MorphTo
    {
        return $this->morphTo();
    }
}
