<?php

namespace App\Console\Commands;

use App\Models\Convert;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Database after every 12 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeThreshold = Carbon::now()->subHours(12);
        Image::where('created_at', '<', $timeThreshold)->chunkById(100, function ($images) {
            foreach ($images as $imageItem) {
                Storage::disk('local')->delete($imageItem->image);
                Storage::disk('local')->delete($imageItem->watermark);
                Storage::disk('local')->delete($imageItem->watermarked_image);
                $imageItem->delete();
            }
        });
        Convert::where('created_at', '<', $timeThreshold)->chunkById(100, function ($images) {
            foreach ($images as $imageItem) {
                Storage::disk('local')->delete($imageItem->image);
                Storage::disk('local')->delete($imageItem->converted_image);
                $imageItem->delete();
            }
        });
    }
}
