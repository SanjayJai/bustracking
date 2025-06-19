<x-layouts.app :title="__('Bus List')">
    <div class="flex flex-col gap-4 rounded-xl">
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Bus List</h1>

            <!-- Filter Form -->
            <form method="GET" class="mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bus Name</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full mt-1 rounded border-gray-300 dark:bg-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">AC Type</label>
                    <select name="ac_type" class="w-full mt-1 rounded border-gray-300 dark:bg-gray-800 dark:text-white">
                        <option value="">All</option>
                        <option value="AC" {{ request('ac_type') == 'AC' ? 'selected' : '' }}>AC</option>
                        <option value="Non-AC" {{ request('ac_type') == 'Non-AC' ? 'selected' : '' }}>Non-AC</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Route</label>
                    <select name="route_id" class="w-full mt-1 rounded border-gray-300 dark:bg-gray-800 dark:text-white">
                        <option value="">All Routes</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }}>
                                {{ $route->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 md:col-span-3 text-right">
                    <button type="submit" class="mt-2 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </form>

            <!-- Bus Table -->
            @if($buses->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">AC Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Route</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($buses as $bus)
                                <tr>
                                    <td class="px-6 py-4">
                                        @if($bus->image)
                                            <img src="{{ asset('storage/' . $bus->image) }}"
                                                 alt="{{ $bus->name }}"
                                                 class="h-[250px] w-[250px] object-cover rounded-xl border">
                                        @else
                                            <span class="text-gray-500">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $bus->name }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $bus->ac_type }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $bus->route->name ?? 'N/A' }}</td>
                                    <td>
    <a href="{{ route('track.bus', $bus->id) }}"
       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Join
    </a>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $buses->appends(request()->query())->links() }}
                </div>
            @else
                <p class="text-lg text-gray-800 dark:text-gray-100">No buses found.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
