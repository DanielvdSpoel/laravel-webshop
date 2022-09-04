<?php

namespace App\Supports;

use App\Models\PageType;
use Closure;
use Filament\Forms\Components\Builder;
use Illuminate\Support\Collection;

class PageBlockManager
{

    private Collection $blocks;

    public function __construct()
    {
        $this->blocks = collect([]);
    }

    public function addBlock(PageBlock $block): self
    {
        $this->blocks->push($block);
        return $this;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function getBlocksInCategories(array $categories): Collection
    {
        return $this->blocks->filter(function (PageBlock $block) use ($categories) {

            return count(array_intersect($block->getCategories(), $categories)) > 0;
        });
    }

    static function getContentBuilder(string $pageType, Collection $blocks): Builder
    {
        return Builder::make($pageType . '_content')
            ->label(__('forms.labels.content'))
            ->schema(function () use ($blocks) {
                return $blocks->map(function (PageBlock $block) {
                    return $block->getBuilderBlock();
                })->toArray();
            })
            ->hidden(function (Closure $get) use ($pageType) {
                $type = PageType::where('name', $pageType)->first();
                return $get('type_id') != $type->id;
            });
    }

}
