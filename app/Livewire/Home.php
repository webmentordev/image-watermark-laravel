<?php

namespace App\Livewire;


use Imagick;
use Exception;
use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    use WithFileUploads;
    public $watermark, $image, $result, $opacity = 50, $ratio = 30;

    public function render()
    {
        return view('livewire.home');
    }

    public function addWatermark()
    {
        try {
            $this->validate([
                'image' => ['required', 'image', 'max:2024'],
                'watermark' => ['required', 'image', 'max:2024'],
                'opacity' => ['required', 'min:1', 'max:100'],
                'ratio' => ['required', 'min:1', 'max:100']
            ]);
            $imagePath = $this->image->store('images');
            $watermarkPath = $this->watermark->store('watermarks');
            $img = new Imagick(storage_path('app/private/' . $imagePath));
            $watermark = new Imagick(storage_path('app/private/' . $watermarkPath));
            $imgWidth = $img->getImageWidth();
            $imgHeight = $img->getImageHeight();
            $desiredWatermarkWidth = $imgWidth * ($this->ratio / 100);
            $aspectRatio = $watermark->getImageHeight() / $watermark->getImageWidth();
            $newWatermarkHeight = $desiredWatermarkWidth * $aspectRatio;
            $watermark->resizeImage($desiredWatermarkWidth, $newWatermarkHeight, Imagick::FILTER_LANCZOS, 1);
            $watermark->setImageAlphaChannel(Imagick::ALPHACHANNEL_SET);
            $watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, $this->opacity / 100, Imagick::CHANNEL_ALPHA);
            $x = ($imgWidth - $watermark->getImageWidth()) / 2;
            $y = ($imgHeight - $watermark->getImageHeight()) / 2;
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
