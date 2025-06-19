<x-layouts.app :title="'Tracking ' . $bus->name">
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Tracking {{ $bus->name }}</h2>

        <div id="map" style="height: 500px;" class="rounded border"></div>

        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
            const busLat = {{ $ride->current_lat ?? 'null' }};
            const busLng = {{ $ride->current_lng ?? 'null' }};

            if (!busLat || !busLng) {
                alert("Bus location not available.");
            } else {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Initialize map
                    const map = L.map('map').setView([userLat, userLng], 14);

                    // OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    // Icons
                    const userIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                        iconSize: [32, 32],
                        iconAnchor: [16, 32]
                    });

                    const busIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/190/190601.png',
                        iconSize: [40, 40],
                        iconAnchor: [20, 40]
                    });

                    // Markers
                    const userMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map)
                        .bindPopup("You are here").openPopup();

                    const busMarker = L.marker([busLat, busLng], { icon: busIcon }).addTo(map)
                        .bindPopup("{{ $bus->name }}");

                    // OSRM Routing API (FREE)
                    const routeUrl = `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${busLng},${busLat}?overview=full&geometries=geojson`;

                    fetch(routeUrl)
                        .then(res => res.json())
                        .then(data => {
                            const route = data.routes[0];
                            const distanceKm = (route.distance / 1000).toFixed(2);
                            const etaMin = Math.round(route.duration / 60);

                            // Draw path
                            const coords = route.geometry.coordinates.map(([lng, lat]) => [lat, lng]);
                            L.polyline(coords, { color: 'blue', weight: 4 }).addTo(map);

                            // Update bus popup
                            const popup = `
                                <b>Bus: {{ $bus->name }}</b><br>
                                Distance: ${distanceKm} km<br>
                                ETA: ${etaMin} min
                            `;
                            busMarker.bindPopup(popup).openPopup();

                            // Optional info below map
                            const info = document.createElement('div');
                            info.className = 'mt-4 p-3 bg-gray-100 rounded border';
                            info.innerHTML = `<strong>ETA:</strong> ${etaMin} min | <strong>Distance:</strong> ${distanceKm} km`;
                            document.querySelector('.p-4').appendChild(info);
                        })
                        .catch(err => {
                            console.error("Route error:", err);
                        });

                }, () => {
                    alert("Please allow location access to track.");
                });
            }
        </script>
    </div>
</x-layouts.app>
