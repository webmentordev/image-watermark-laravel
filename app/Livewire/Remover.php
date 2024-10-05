<?php

namespace App\Livewire;

use Imagick;
use App\Models\Removal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class Remover extends Component
{
    use WithFileUploads;

    public $images = null, $removals = [];

    public function rules()
    {
        return [
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['required', 'max:1024']
        ];
    }

    public function mount()
    {
        SEOMeta::setTitle("Unlimited Free Images Background Remover");
        SEOMeta::setDescription("Unlimited Free Images background remover of any image for your business with Our Easy-to-Use Converter!");
        SEOMeta::setRobots("index, follow");
        SEOMeta::addMeta("apple-mobile-web-app-title", "MarkGroupHost");
        SEOMeta::addMeta("application-name", "MarkGroupHost");

        OpenGraph::setTitle("Unlimited Free Images Background Remover");
        OpenGraph::setDescription("Unlimited Free Images background remover of any image for your business with Our Easy-to-Use Converter!");
        OpenGraph::addProperty("type", "SoftwareApplication");
        OpenGraph::addProperty("locale", "eu");

        TwitterCard::setTitle("Unlimited Free Images Background Remover");
        TwitterCard::setDescription("Unlimited Free Images background remover of any image for your business with Our Easy-to-Use Converter!");

        JsonLd::setTitle("Unlimited Free Images Background Remover");
        JsonLd::setDescription("Unlimited Free Images background remover of any image for your business with Our Easy-to-Use Converter!");
    }

    public function render()
    {
        return view('livewire.remover');
    }

    public function updated()
    {
        $this->validate();
    }

    public function removeBG()
    {
        try {
            $this->validate();

            foreach ($this->images as $singleImage) {
                $imagePath = $singleImage->store('bg_removed');
                $img = new \Imagick(storage_path('app/private/' . $imagePath));
                $cornerColor = $img->getImagePixelColor(0, 0)->getColor();
                $cornerColorString = sprintf('rgb(%d,%d,%d)', $cornerColor['r'], $cornerColor['g'], $cornerColor['b']);
                $fuzz = 0.1 * \Imagick::getQuantumRange()['quantumRangeLong'];
                $img->transparentPaintImage($cornerColorString, 0.0, $fuzz, false);
                $img->setImageAlphaChannel(\Imagick::ALPHACHANNEL_ACTIVATE);
                $img->setBackgroundColor(new \ImagickPixel('transparent'));
                $bgremovedImage = 'bg_removed/bg-removed-' . rand(9, 999999) . '-' . pathinfo($singleImage->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $this->type;
                $img->writeImage(storage_path('app/private/' . $bgremovedImage));
                $img->clear();
                $img->destroy();
                Removal::create([
                    'image' => $imagePath,
                    'bg_removed_image' => $bgremovedImage,
                ]);
                $this->removals[] = [
                    'name' => $singleImage->getClientOriginalName(),
                    'url' => config('app.url') . '/storage/' . $bgremovedImage
                ];
            }

            session()->flash('success', 'Background removed from all images!');
        } catch (\Exception $e) {
            Log::error('BGRemoval error: ' . $e->getMessage());
            $errorMessage = 'An error occurred during background removal. Please check the file formats and sizes, and try again. Error details: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
        }
    }
}
