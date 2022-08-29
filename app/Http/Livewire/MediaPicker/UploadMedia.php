<?php

namespace App\Http\Livewire\MediaPicker;

use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class UploadMedia extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Group::make()
                ->schema([
                    MediaUpload::make('filename')
                        ->label('File')
                        ->preserveFilenames(config('filament-curator.preserve_file_names'))
                        ->maxWidth(config('filament-curator.max_width'))
                        ->minSize(config('filament-curator.min_size'))
                        ->maxSize(config('filament-curator.max_size'))
                        ->rules(config('filament-curator.rules'))
                        ->acceptedFileTypes(config('filament-curator.accepted_file_types'))
                        ->directory(config('filament-curator.directory', 'images'))
                        ->disk(config('filament-curator.disk', 'public'))
                        ->required()
                        ->maxFiles(1)
                        ->panelAspectRatio('16:9')
                        ->columnSpan(['md' => 1, 'lg' => 2]),

                ])
                ->columns(['md' => 2, 'lg' => 3])
        ];
    }


    public function render()
    {
        return view('livewire.media-picker.upload-media');
    }
}
