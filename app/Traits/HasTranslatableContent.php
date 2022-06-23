<?php

namespace App\Traits;

trait HasTranslatableContent {

    public function setContentAttribute($data): void
    {
        $locale = $this->getLocale();

        // Check if there is already content, otherwise use empty array
        $content = $this->attributes['content'] ?? [];

        // Checks if content needs decoding
        if(is_string($content)){
            $content = json_decode($content, true);
        }

        // Loop over new data values as row for edit page
        foreach($data as $key => &$row) {

            // Loop over all fields that are translatable
            foreach($this->translatableContent as $name){

                // Check if translatable value is already defined
                if(isset($row['data'][$name])){
                    $c = $content[$key]['data'][$name] ?? [];

                    $c[$locale] = $row['data'][$name];

                    $row['data'][$name] = $c;
                }

            }
        }

        // For create page immediately set content
        $this->attributes['content'] = json_encode($data);
    }

    public function getContentAttribute(): array
    {
        $locale = $this->getLocale();

        $data = json_decode($this->attributes['content'] ?? '[]', true);

        $translatableContent = $this->translatableContent;

        $data = array_map(function($row) use($locale, $translatableContent) {
            foreach($translatableContent as $name){
                if(isset($row['data'][$name])){
                    $row['data'][$name] = $row['data'][$name][$locale] ?? '';
                }
            }
            return $row;
        }, $data);

        return $data;
    }
}
