const formatedItems = items
	.replaceAll("&#039;", "'")
	.replaceAll(":&quot;", ':"')
	.replaceAll("&quot;:", '":')
	.replaceAll(",&quot;", ',"')
	.replaceAll("&quot;,", '",')
	.replaceAll("{&quot;", '{"')
	.replaceAll("&quot;}", '"}');

const markerResults = JSON.parse(formatedItems);

// console.log(markerResults);

function createMarkers(markerResults, map) {
	for (let i = 0; i < markerResults.length; i++) {
		const latLng = new google.maps.LatLng(
			markerResults[i].latitude,
			markerResults[i].longitude
		);

		const contentString =
			'<div id="content" class="marker-card">' +
			`<a href="${markerResults[i].url}" target="_blank"><img src="${markerResults[i].image}" draggable="false"></a>` +
			`<a href="${markerResults[i].url}" target="_blank"><h3>${markerResults[i].name}</h3></a>` +
			"</div>";
		const infowindow = new google.maps.InfoWindow({
			content: contentString,
		});
		const marker = new google.maps.Marker({
			position: latLng,
			map,
			title: markerResults[i].name,
		});

		marker.addListener("click", () => {
			infowindow.open({
				anchor: marker,
				map,
				shouldFocus: false,
			});
		});
	}
}
// window.initMap = initMap;
// window.eqfeed_callback = eqfeed_callback;

// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.
function initMap() {
	const location = { lat: 42.290592, lng: 43.5610051 };
	let zoomSize = window.innerWidth > 991 ? 8 : 6.5;

	const map = new google.maps.Map(document.getElementById("map"), {
		zoom: zoomSize,
		center: location,
	});
	createMarkers(markerResults, map);
}

// window.initMap = initMap;
