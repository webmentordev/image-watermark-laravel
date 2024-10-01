<section class="min-h-screen h-full py-12 px-4 flex items-center justify-center">
    <form wire:submit.prevent="convertImages" enctype="multipart/form-data" class="flex flex-col max-w-2xl w-full">

        @if (count($converted))
            @foreach ($converted as $convert)
                <div class="p-3 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-between w-full mb-4">
                    <p class="w-[530px]">{{ $convert['name'] }}</p>
                    <a href="{{ $convert['url'] }}" download
                        class="py-2 px-4 bg-yellow-300 text-black font-semibold rounded-lg">Download</a>
                </div>
            @endforeach
        @else
            <h1 class="mb-4 dark:text-white font-semibold text-3xl text-center" title="Unlimited Free Images Converter">
                Unlimited Free Images Converter</h1>
        @endif

        @session('error')
            <x-error message="{{ $value }}" />
        @endsession

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="image">Pick images (<span class="text-red-500">*</span>
                1024KB
                each)</label>
            <input type="file" id="image" wire:model.live="images" multiple
                class="file-input file-input-bordered file-input-info w-full" accept="image/*" required />
            @error('images')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="w-full mb-4 flex flex-col">
            <label class="label-text mb-1" for="type">Pick type to convert @if ($type)
                    {{ $type }}
                @endif
            </label>
            <select class="select select-success w-full" wire:model.live="type">
                <option value="png" disabled selected>PNG</option>
                @foreach ($formats as $format)
                    <option value="{{ strtolower($format) }}">{{ strtoupper($format) }}</option>
                @endforeach
            </select>
            @error('type')
                <p class="text-red-600 py-2">{{ $message }}</p>
            @enderror
        </div>

        <p class="dark:text-yellow-300 text-blue-700 mb-3">Please download your images right after conversion
        </p>

        <button type="submit"
            class="btn btn-block mb-3 dark:hover:bg-blue-600 dark:hover:text-white bg-black text-white dark:bg-white dark:text-black"
            wire:loading.remove wire:target="convertImages">Start
            converting</button>
        <button class="btn bg-black text-black dark:bg-white dark:text-black" wire:loading wire:target="convertImages"
            disabled>
            <span class="loading loading-spinner"></span>
            converting
        </button>
    </form>
</section>
