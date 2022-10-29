<div>
    <x-text-input class="block w-full" wire:model="block.content" type="text" />
    @error('block.content') <div class="text-sm text-red-400">{{ $message }}</div> @enderror
</div>
