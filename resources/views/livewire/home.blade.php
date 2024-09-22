<section class="h-screen flex items-center justify-center">
    <form wire:submit.prevent="addWatermark" enctype="multipart/form-data" class="flex flex-col max-w-2xl w-full">
        @if ($image)
            <img class="mb-3 rounded-lg overflow-hidden" src="{{ $image->temporaryUrl() }}">
        @endif

        @session('error')
            <x-error message="{{ $value }}" />
        @endsession

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Pick an image file</label>
            <input type="file" id="image" wire:model="image"
                class="file-input file-input-bordered file-input-info w-full max-w-xs" accept="image/*" required />
            @error('image')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Pick your watermark</label>
            <input type="file" id="image" wire:model="watermark"
                class="file-input file-input-bordered file-input-info w-full max-w-xs" accept="image/*" required />
            @error('watermark')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-block mb-3" wire:loading.remove wire:target="addWatermark">Start
            processing</button>
        <button class="btn" wire:loading wire:target="addWatermark" disabled>
            <span class="loading loading-spinner"></span>
            loading
        </button>
    </form>
</section>
