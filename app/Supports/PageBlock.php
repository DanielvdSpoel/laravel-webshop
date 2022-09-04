<?php

namespace App\Supports;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Collection;

class PageBlock
{
    protected string $name;
    protected string $label;
    protected string $icon;
    protected array $categories;
    protected array $fields;

    public function __construct(string $name, string $label, string $icon, array $categories, array $fields)
    {
        $this->name = $name;
        $this->label = $label;
        $this->icon = $icon;
        $this->categories = $categories;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getBuilderBlock(): Block
    {
        return Block::make($this->name)
            ->label($this->label)
            ->icon($this->icon)
            ->schema($this->fields);
    }


}
