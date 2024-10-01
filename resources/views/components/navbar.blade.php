<nav class="w-full fixed top-0 left-0 z-50">
    <div class="max-w-[98%] m-auto w-full p-4 flex items-center justify-between">
        <a href="{{ route('home') }}">Watermarker</a>
        <ul class="font-bold">
            <a href="{{ route('home') }}" class="px-4" wire:navigate>Home</a>
            <a href="{{ route('home') }}" class="px-4" wire:navigate>Watermarker</a>
            <a href="{{ route('converter') }}" class="pl-4" wire:navigate>Converter</a>
        </ul>
    </div>
</nav>
