<?php

namespace App\Livewire;

use App\Models\Convert;
use Imagick;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class Converter extends Component
{
    use WithFileUploads;

    public $images = null, $converted = [], $type = "png";

    public function rules()
    {
        return [
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['required', 'image', 'min:1024']
        ];
    }

    public function render()
    {
        return view('livewire.converter');
    }

    public function updated()
    {
        $this->validate();
    }

    public function convertImages()
    {
        try {
            $this->validate();
            foreach ($this->images as $singleImage) {
                $imagePath = $singleImage->store('converts');
                $img = new Imagick(storage_path('app/private/' . $imagePath));
                $img->setImageFormat($this->type);
                $convertedImage = 'converts/converted_' . pathinfo($singleImage->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $this->type;
                $img->writeImage(storage_path('app/private/' . $convertedImage));
                $img->clear();
                $img->destroy();
                $imageRecord = Convert::create([
                    'image' => $imagePath,
                    'converted_image' => $convertedImage,
                ]);
                $this->converted[] = [
                    'name' => $singleImage->getClientOriginalName(),
                    'url' => config('app.url') . '/storage/' . $imageRecord->converted_image
                ];
            }
            session()->flash('success', 'All images have been converted!');
        } catch (Exception $e) {
            Log::error('Converting error: ' . $e->getMessage());
            $errorMessage = 'An error occurred during conversion. Please check the file formats and sizes, and try again. Error details: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
        }
    }
}
