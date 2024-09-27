<section class="min-h-screen h-full py-12 flex items-center justify-center" x-data="{ opacity: {{ $opacity }}, ratio: {{ $ratio }} }">
    <form wire:submit.prevent="addWatermark" enctype="multipart/form-data" class="flex flex-col max-w-2xl w-full">
        @if (!$result)
            @if ($image)
                <h1 class="text-3xl mb-3 font-semibold dark:text-white">Preview</h1>
                <div class="bg-contain bg-center flex items-center justify-center h-[600px] w-full bg-no-repeat"
                    style="background-image: url({{ $image->temporaryUrl() }})">
                    @if ($watermark)
                        <img src="{{ $watermark->temporaryUrl() }}"
                            :style="{ opacity: opacity / 100, width: ratio + '%' }">
                    @endif
                </div>
            @else
                <h1 class="mb-4 dark:text-white font-semibold text-3xl text-center"
                    title="Unlimited Free Watermark Image Generator">
                    Unlimited Free Watermark Image Generator</h1>
            @endif
        @endif
        @session('error')
            <x-error message="{{ $value }}" />
        @endsession

        @if ($result)
            <h1 class="text-3xl mb-3 dark:text-white font-semibold">Generated Image</h1>
            <h2 class="dark:text-yellow-300 text-blue-700 mb-2">Save it or you will never get the link again 😁</h2>
            <img class="mb-6 rounded-lg overflow-hidden" src="{{ $result }}">
        @endif

        <div class="grid grid-cols-2 gap-6">
            <div class="w-full mb-4 flex flex-col">
                <label class="label-text mb-1" for="image">Pick an image file (<span class="text-red-500">*</span>
                    2024KB
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
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div class="w-full mb-4 flex flex-col">
                <label class="label-text mb-1" for="image">Watermark Opacity (1 - 100)%</label>
                <input type="number" wire:model="opacity" x-model="opacity" max="100" min="1"
                    placeholder="Opacity" class="input input-bordered w-full max-w-xs" />
                @error('opacity')
                    <p class="text-red-600 py-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full mb-4 flex flex-col">
                <label class="label-text mb-1" for="image">Watermark Ratio (1 - 100)%</label>
                <input type="number" wire:model="ratio" x-model="ratio" max="100" min="1"
                    placeholder="Opacity" class="input input-bordered w-full max-w-xs" />
                @error('ratio')
                    <p class="text-red-600 py-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <p class="dark:text-yellow-300 text-blue-700 mb-3">Final Result can be different from the preview
        </p>
        <button type="submit"
            class="btn btn-block mb-3 dark:hover:bg-blue-600 dark:hover:text-white bg-black text-black dark:bg-white dark:text-black"
            wire:loading.remove wire:target="addWatermark">Start
            processing</button>
        <button class="btn bg-black text-black dark:bg-white dark:text-black" wire:loading wire:target="addWatermark"
            disabled>
            <span class="loading loading-spinner"></span>
            loading
        </button>
    </form>
</section>
