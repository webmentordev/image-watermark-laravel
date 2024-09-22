<?php

namespace App\Livewire;


use Imagick;
use Exception;
use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class Home extends Component
{
    use WithFileUploads;
    public $watermark, $image, $result;

    public function mount()
    {
        SEOMeta::setTitle('Home');
        SEOMeta::setDescription('This is my page description');
        SEOMeta::setCanonical('https://codecasts.com.br/lesson');

        OpenGraph::setDescription('This is my page description');
        OpenGraph::setTitle('Home');
        OpenGraph::setUrl('http://current.url.com');
        OpenGraph::addProperty('type', 'articles');

        TwitterCard::setTitle('Homepage');
        TwitterCard::setSite('@LuizVinicius73');

        JsonLd::setTitle('Homepage');
        JsonLd::setDescription('This is my page description');
        JsonLd::addImage('https://codecasts.com.br/img/logo.jpg');
    }
    public function render()
    {
        return view('livewire.home');
    }

    public function addWatermark()
    {
        try {
            $this->validate([
                'image' => ['required', 'image', 'max:2024'],
                'watermark' => ['required', 'image', 'max:2024']
            ]);
            $imagePath = $this->image->store('images');
            $watermarkPath = $this->watermark->store('watermarks');
            $img = new Imagick(storage_path('app/private/' . $imagePath));
            $watermark = new Imagick(storage_path('app/private/' . $watermarkPath));
            $imgWidth = $img->getImageWidth();
            $imgHeight = $img->getImageHeight();
            $watermarkWidth = $watermark->getImageWidth();
            $watermarkHeight = $watermark->getImageHeight();
            $x = ($imgWidth - $watermarkWidth) / 2;
            $y = ($imgHeight - $watermarkHeight) / 2;
            $img->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);
            $watermarkedImagePath = 'images/watermarked_' . $this->image->getClientOriginalName();
            $img->writeImage(storage_path('app/private/' . $watermarkedImagePath));
            $img->clear();
            $img->destroy();
            $watermark->clear();
            $watermark->destroy();
            $imageRecord = Image::create([
                'image' => $imagePath,
                'watermark' => $watermarkPath,
                'watermarked_image' => $watermarkedImagePath,
            ]);
            $this->result = config('app.url') . '/storage/' . $imageRecord->watermarked_image;
            session()->flash('success', 'Watermark applied successfully!');
        } catch (Exception $e) {
            Log::error('Watermarking error: ' . $e->getMessage());
            $errorMessage = 'An error occurred while applying the watermark. ';
            $errorMessage .= 'Please check the file formats and sizes, and try again. ';
            $errorMessage .= 'Error details: ' . $e->getMessage();
            session()->flash('error', $errorMessage);
        }
    }
}
