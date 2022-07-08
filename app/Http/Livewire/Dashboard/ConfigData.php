<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\CPU\imageManager;
use App\Models\WebConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigData extends Component
{
    public $listeners = ['save', 'update', 'delete'];
    use WithFileUploads;
    protected $user;

    public $search;
    public $total_show = 10;

    public $config;
    public $id_config;
    public $web_name;
    public $logo;
    public $photo;
    public $value;

    public function render()
    {
        return view('livewire.dashboard.config-data');
    }

    protected $messages = [
        'web_name.required' => 'Please input web name',
        'logo.required' => 'Please select logo',
    ];

    protected $rules = [
        'web_name' => 'required|string',
        'logo' => 'required',
    ];

    public function mount()
    {
        $this->web_name = helpers::config('web_name')->first()->value;
        $this->photo = helpers::config('web_logo')->first();
    }

    public function save()
    {
    }

    public function update()
    {
        $this->validate($this->rules, $this->messages);
        // WebConfig::updateOrInsert(['name' => 'web_name'], ['value' => $this->web_name]);
        $oldName = WebConfig::where('name', 'web_name')->first();
        $oldName->value = $this->web_name;
        $dir = 'company';

        if (isset($this->logo)) {
            $logo = helpers::config('web_logo')->first();

            $imgLogo = imageManager::update('company/', $logo, 'png', $this->logo);

            $old_image = $logo['value'];

            if ($logo->value !== null) {
                if (File::exists(public_path($old_image))) {
                    unlink(public_path($old_image));
                }
            }

            if ($this->logo != null) {
                $imageName = Carbon::now()->toDateString().'-'.uniqid().'.'.'.png';

                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                $url = $this->logo->store('storage/'.$dir);
            } else {
                $url = 'def.png';
            }
            WebConfig::updateOrInsert(['name' => 'web_logo'], [
                'value' => $url,
            ]);
        }

        $oldName->save();

        $this->emit('refresh');

        return session()->flash('success', 'Successfully updated web config');
    }

    public function delete()
    {
    }
}
