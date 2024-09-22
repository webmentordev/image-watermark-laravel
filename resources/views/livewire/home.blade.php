<section class="h-screen flex items-center justify-center" x-data="{ opacity: {{ $opacity }} }">
    <form wire:submit.prevent="addWatermark" enctype="multipart/form-data" class="flex flex-col max-w-2xl w-full">
        @if ($image)
            <h1 class="text-2xl mb-3 text-white">Preview</h1>
            <div class="bg-contain bg-center flex items-center justify-center h-[600px] w-full bg-no-repeat"
                style="background-image: url({{ $image->temporaryUrl() }})">
                @if ($watermark)
                    <img src="{{ $watermark->temporaryUrl() }}" width="150px" :style="{ 'opacity': opacity / 100 }">
                @endif
            </div>
        @else
            <h1 class="mb-3 text-white font-semibold text-2xl" title="Unlimited Free Watermark Image Generator">
                Unlimited Free Watermark Image Generator</h1>
        @endif

        @session('error')
            <x-error message="{{ $value }}" />
        @endsession

        @if ($result)
            <h1 class="text-2xl mb-3 text-white">Result</h1>
            <h2 class="text-yellow-300 mb-2">Save it or you will never get the link again 😁</h2>
            <img class="mb-6 rounded-lg overflow-hidden" src="{{ $result }}">
        @endif

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Pick an image file (<span class="text-red-500">*</span> 2024KB
                Max)</label>
            <input type="file" id="image" wire:model="image"
                class="file-input file-input-bordered file-input-info w-full max-w-xs" accept="image/*" required />
            @error('image')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Pick your watermark (<span class="text-red-500">*</span>
                2024KB
                Max)</label>
            <input type="file" id="image" wire:model="watermark"
                class="file-input file-input-bordered file-input-info w-full max-w-xs" accept="image/*" required />
            @error('watermark')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Watermark Opacity (1 - 100)%</label>
            <input type="number" wire:model="opacity" x-model="opacity" max="100" min="1"
                placeholder="Opacity" class="input input-bordered w-full max-w-xs" />
            @error('opacity')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>
        <p class="text-yellow-300 mb-3">Final Result can be different from the preview</p>
        <button type="submit" class="btn btn-block mb-3" wire:loading.remove wire:target="addWatermark">Start
            processing</button>
        <button class="btn" wire:loading wire:target="addWatermark" disabled>
            <span class="loading loading-spinner"></span>
            loading
        </button>
    </form>
</section>
