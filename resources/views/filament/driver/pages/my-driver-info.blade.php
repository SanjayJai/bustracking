<x-filament::page>
    @if ($editing)
        <div class="w-full max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-10 mt-10">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800 dark:text-gray-100">
                Update Your Driver Profile
            </h2>
            <form wire:submit.prevent="save" class="space-y-6">
                {{ $this->form }}
                <div class="flex justify-center">
                    <x-filament::button type="submit" size="xl" class="w-1/2 text-lg">
                        Save
                    </x-filament::button>
                </div>
            </form>
        </div>
    @else
        <div class="w-full max-w-4xl mx-auto mt-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    {{ auth()->user()->name }} Driver Info
                </h2>
                <x-filament::button wire:click="edit" color="primary" size="xl" class="shadow">
                    Edit
                </x-filament::button>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Name</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Email</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Phone Number</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->driver?->phone_number ?? '-' }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Address</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->driver?->address ?? '-' }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">City</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->driver?->city ?? '-' }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Date of Birth</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->driver?->DOB ?? '-' }}</span>
                    </div>
                    <div class="py-4 px-6 flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">License Number</span>
                        <span class="text-lg text-gray-800 dark:text-gray-100">{{ auth()->user()->driver?->license_number ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-filament::page>