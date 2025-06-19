<x-filament::page>
    <div class="container mx-auto p-6" x-data="{ showManual: false }">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mb-6">Driver Dashboard</h1>

        @if($activeRide)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Active Ride: {{ $activeRide->bus->name }}
                </h2>
                <div class="flex flex-wrap items-center mb-4">
                    <button wire:click="stopRide"
                      style="background-color: #d81d1d; color: white;"
                        class="mr-4 px-4 py-2 border border-red-600 text-red-600 rounded hover:bg-red-600 hover:text-white dark:border-red-600 dark:text-red-600 dark:hover:bg-red-600 dark:hover:text-white">
                        End Ride
                        
                    </button>
                    <div>
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">Last Known Location:</p>
                        <p id="location" class="text-lg text-gray-900 dark:text-gray-100">
                            {{ $activeRide->current_lat ?? 'N/A' }},
                            {{ $activeRide->current_lng ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <!-- Share My Location (auto) -->
                    <button
                        id="share-location-btn"
                        type="button"
                        onclick="startTracking()"
                        class="px-4 py-2 border text-black dark:text-white rounded hover:bg-blue-700 transition"
                        style="background-color: #1d4ed8; color: white;"
                    >
                        Share My Location
                    </button>
                    <!-- Manual Entry Toggle -->
                    <button
                        type="button"
                        x-on:click="showManual = !showManual"
                        x-bind:class="showManual ? 'bg-orange-700' : 'bg-orange-600'"
                        class="px-4 py-2 border text-black  dark:text-white rounded hover:bg-orange-700 transition"
                         style="background-color: #1dd88d; color: white;"
                    >
                        <span x-text="showManual ? 'Hide Manual Entry' : 'Manual Location Entry'"></span>
                    </button>
                </div>
                <!-- Manual Location Input Form -->
                <form x-show="showManual" x-transition wire:submit.prevent="submitManualLocation" class="mt-4 space-y-2">
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Latitude</label>
                        <input type="text" wire:model.defer="manualLat" class="border rounded px-2 py-1 w-40" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Longitude</label>
                        <input type="text" wire:model.defer="manualLng" class="border rounded px-2 py-1 w-40" required>
                    </div>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                        Update Location
                    </button>
                </form>
            </div>
            <script>
                let watchId = null;
                function startTracking() {
                    if (navigator.geolocation) {
                        document.getElementById('share-location-btn').disabled = true;
                        watchId = navigator.geolocation.watchPosition(function(position) {
                            let lat = position.coords.latitude;
                            let lng = position.coords.longitude;
                            @this.call('updateLocation', lat, lng);
                            document.getElementById('location').innerText = lat + ', ' + lng;
                        }, function(error) {
                            alert('Error getting location: ' + error.message);
                        }, {
                            enableHighAccuracy: true,
                            maximumAge: 0,
                            timeout: 5000
                        });
                    } else {
                        alert('Geolocation is not supported by this browser.');
                    }
                }
            </script>
        @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Assigned Buses
                </h2>
                @if($buses->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Bus Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($buses as $bus)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-800 dark:text-gray-100">
                                            {{ $bus->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button wire:click="startRide({{ $bus->id }})"
                                                  style="background-color: #1dd823; color: white;"
                                                class="px-4 py-2 border border-green-600 text-green-600 rounded hover:bg-green-600 hover:text-white dark:border-green-600 dark:text-green-600 dark:hover:bg-green-600 dark:hover:text-white">
                                                Start Ride
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-lg text-gray-800 dark:text-gray-100">No assigned buses found.</p>
                @endif
            </div>
        @endif
    </div>
</x-filament::page>