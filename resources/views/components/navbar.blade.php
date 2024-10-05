<nav class="w-full fixed top-0 left-0 z-50">
    <div class="max-w-[98%] m-auto w-full p-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-bold text-3xl">GroupHostMarker</a>
        <ul class="font-bold">
            <a href="{{ route('home') }}" class="px-4" wire:navigate>Watermarker</a>
            <a href="{{ route('converter') }}" class="px-4" wire:navigate>Converter</a>
            <a href="{{ route('remover') }}" class="pl-4" wire:navigate>BG Remover</a>
        </ul>
    </div>
</nav>
