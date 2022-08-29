<?php

namespace App\Http\Livewire\MediaPicker;

use Filament\Forms\Components\Group;
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
            Group::make()
                ->schema([

                ])
                ->columns(['md' => 2, 'lg' => 3])
        ];
    }


    public function render()
    {
        return view('livewire.media-picker.upload-media');
    }
}
