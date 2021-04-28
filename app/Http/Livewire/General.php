<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;
use Livewire\WithFileUploads;

class General extends Component
{
    use WithFileUploads;


    public $data = [
        'icon' => 'icon-settings',
        'title' => 'Paramètres',
        'subtitle' => 'Paramètres Généraux',
    ];

    public $appVars;

    public $logo;
    public $icon;

    public function mount()
    {
        $this->histo = new Astuce();

        $this->appVars = $this->histo->getAppVars();
    }

    public function changeVars()
    {
        $path = base_path('.env');

        if (isset($this->appVars['name'])) {
            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    'APP_NAME=' . config('app.name'),
                    'APP_NAME=' . $this->appVars['name'],
                    file_get_contents($path)
                ));
            }
        }

        if ($this->logo) {
            $this->validate([
                'logo' => 'image|max:1024'
            ]);
            $imageName = 'logo.png';

            $this->logo->storeAs('public/images', $imageName);
        }

        if ($this->icon) {
            $this->validate([
                'icon' => 'image|max:1024'
            ]);
            $imageName = 'icon.png';

            $this->icon->storeAs('public/images', $imageName);
        }

        $this->dispatchBrowserEvent('updateSetting');
    }


    public function render()
    {
        return view('livewire.general', [
            'page' => 'setting',
        ])->layout('layouts.app');
    }
}
