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
    public $watermark, $image, $result;

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
            $img = new Imagick(storage_path('app/' . $imagePath));
            $watermark = new Imagick(storage_path('app/' . $watermarkPath));
            $imgWidth = $img->getImageWidth();
            $imgHeight = $img->getImageHeight();
            $watermarkWidth = $watermark->getImageWidth();
            $watermarkHeight = $watermark->getImageHeight();
            $x = $imgWidth - $watermarkWidth - 10;
            $y = $imgHeight - $watermarkHeight - 10;
            $img->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);
            $watermarkedImagePath = 'images/watermarked_' . $this->image->getClientOriginalName();
            $img->writeImage(storage_path('app/' . $watermarkedImagePath));
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


        // $this->validate([
        //     'image' => ['required', 'max:2024', 'image'],
        //     'watermark' => ['required', 'max:2024', 'image']
        // ]);

        // $imagePath = $this->image->store('images');

        // $image = Image::create([
        //     'image' => $this->image->store('image'),
        //     'watermark' => $this->watermark->store('watermark'),
        // ]);

        // session()->flash('success', $image);
    }
}
