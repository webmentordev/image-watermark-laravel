<?php

namespace App\Livewire;

use Imagick;
use Exception;
use App\Models\Convert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class Converter extends Component
{
    use WithFileUploads;

    public $images = null, $converted = [], $type = "png";
    public $formats = [
        'png',
        'jpg',
        'jpeg',
        'webp',
        'avif',
        'ico',
        'eps',
        'odd',
        'psd',
        'tiff',
        'ps'
    ];

    public function rules()
    {
        return [
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['required', 'max:1024']
        ];
    }

    public function mount()
    {
        SEOMeta::setTitle("Unlimited Free Images Converter To Any Extension");
        SEOMeta::setDescription("Convert Unlimited Free Images to any extension for your business with Our Easy-to-Use Converter!");
        SEOMeta::setRobots("index, follow");
        SEOMeta::addMeta("apple-mobile-web-app-title", "MarkGroupHost");
        SEOMeta::addMeta("application-name", "MarkGroupHost");

        OpenGraph::setTitle("Unlimited Free Images Converter To Any Extension");
        OpenGraph::setDescription("Convert Unlimited Free Images to any extension for your business with Our Easy-to-Use Converter!");
        OpenGraph::addProperty("type", "SoftwareApplication");
        OpenGraph::addProperty("locale", "eu");

        TwitterCard::setTitle("Unlimited Free Images Converter To Any Extension");
        TwitterCard::setDescription("Convert Unlimited Free Images to any extension for your business with Our Easy-to-Use Converter!");

        JsonLd::setTitle("Unlimited Free Images Converter To Any Extension");
        JsonLd::setDescription("Convert Unlimited Free Images to any extension for your business with Our Easy-to-Use Converter!");
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
        if (!in_array($this->type, $this->formats)) {
            session()->flash('error', 'Please select correct image format');
            return;
        }
        try {
            $this->validate();
            foreach ($this->images as $singleImage) {
                $imagePath = $singleImage->store('converts');
                $img = new Imagick(storage_path('app/private/' . $imagePath));
                $img->setImageFormat($this->type);
                $convertedImage = 'converts/converted-' . rand(9, 999999) . '-'  . pathinfo($singleImage->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $this->type;
                $img->writeImage(storage_path('app/private/' . $convertedImage));
                $img->clear();
                $img->destroy();
                Convert::create([
                    'image' => $imagePath,
                    'converted_image' => $convertedImage,
                ]);
                $this->converted[] = [
                    'name' => $singleImage->getClientOriginalName(),
                    'url' => config('app.url') . '/storage/' . $convertedImage
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
