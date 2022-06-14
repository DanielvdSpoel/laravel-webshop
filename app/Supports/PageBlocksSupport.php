<?php

namespace App\Supports;

use Filament\Forms\Components\KeyValue;

class PageBlocksSupport
{
    static function getBasicPageBlocks(): array
    {
        return [

        ];

    }

    static function getTranslationField(string $name): KeyValue
    {
        return KeyValue::make($name)
            ->label(__('forms.labels.' . $name))
            ->keyLabel(__('forms.labels.language'))
            ->valueLabel(__('forms.labels.value'))
            ->afterStateHydrated(function (KeyValue $component, $state) {
                if ($state) return;
                $default = collect([]);
                foreach (TranslationSupport::$availableLocales as $locale) {
                    $default->put($locale, "");
                }
                $component->state($default->toArray());
            })
            ->disableAddingRows()
            ->disableDeletingRows()
            ->disableEditingKeys()
            ->required();
    }


}
