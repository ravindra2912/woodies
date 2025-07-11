function getUserLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			(position) => {
				// return position;
				
				console.log(`Latitude: ${position.coords.latitude}, Longitude: ${position.coords.longitude}`);
				return { lat: position.coords.latitude, lon: position.coords.longitude };
			},
			(error) => {
				// return null;
				console.error('Error getting location:', error.message);
			}
		);
	} else {
		console.error('Geolocation is not supported by this browser.');
	}
}

async function getLatLongOnAddress_OS(address) {
	const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&addressdetails=1`;

	try {
		const response = await fetch(url);
		const data = await response.json();

		if (data.length > 0) {
			const location = data[0];
			console.log(`Latitude: ${location.lat}, Longitude: ${location.lon}`);
			return { lat: location.lat, lon: location.lon };
		} else {
			console.error('No results found');
			return null;
		}
	} catch (error) {
		console.error('Error fetching the API:', error);
		return null;
	}
}


// Google Maps API
async function getLatLongOnAddress_google(address) {
	const apiKey = 'YOUR_GOOGLE_API_KEY'; // Replace with your API key
	const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;

	try {
		const response = await fetch(url);
		const data = await response.json();

		if (data.status === 'OK') {
			const location = data.results[0].geometry.location;
			console.log(`Latitude: ${location.lat}, Longitude: ${location.lng}`);
			return location;
		} else {
			console.error('Geocoding failed:', data.status);
		}
	} catch (error) {
		console.error('Error fetching the API:', error);
	}
}