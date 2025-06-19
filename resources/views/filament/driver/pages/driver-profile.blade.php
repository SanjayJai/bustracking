<x-filament::page>
    <form wire:submit.prevent="save" class="space-y-4 max-w-xl">
        {{ $this->form }}
        <x-filament::button type="submit">
            Save
        </x-filament::button>
    </form>
</x-filament::page>
