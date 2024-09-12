const map = L.map('map').setView([-6.9320011, 107.5733367], 12);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://portofolio-ihya.netlify.app">Ihya Natik W</a>'
}).addTo(map);
const info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};

info.update = function (props) {
    const contents = props ? `<b>${props.name}</b>` : 'Pilih wilayah';
    this._div.innerHTML = `<h4>Informasi TPS</h4>${contents}`;
};

info.addTo(map);

// Get color based on vote count (optional)
function getColor(d) {
    return d > 1000 ? '#800026' :
           d > 500  ? '#BD0026' :
           d > 200  ? '#E31A1C' :
           d > 100  ? '#FC4E2A' :
           d > 50   ? '#FD8D3C' :
           d > 20   ? '#FEB24C' :
           d > 10   ? '#FED976' : '#FFEDA0';
}
function style(feature) {
    return {
        radius: 8,
        fillColor: getColor(feature.properties.vote_count),
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.8
    };
}
function highlightFeature(e) {
    const layer = e.target;

    layer.setStyle({
        weight: 5,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    layer.bringToFront();

    info.update(layer.feature.properties);
}
function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}
function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}
function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: function(e) {
            const props = e.target.feature.properties;
            const content = `
                <b>${props.name}</b><br>
                Kandidat: ${props.candidate}<br>
                Partai: ${props.partai}<br>
                Jumlah Suara: ${props.vote_count}
            `;
            L.popup()
                .setLatLng(e.latlng)
                .setContent(content)
                .openOn(map);
        }
    });
}
// Fetch the vote data from API
axios.get('https://dpcgerindrakotabandung.com/api/map').then(response => {
    const votesData = response.data;

    const geojsonData = {
        "type": "FeatureCollection",
        "features": votesData.map(vote => ({
            "type": "Feature",
            "properties": {
                "name": vote.polling_place_name,
                "candidate": vote.candidate_name,
                "partai": vote.partai_name,
                "vote_count": vote.vote_count,
                "partai_color": vote.partai_color,
                "marker-color": "#ed0707",
                "marker-size": "medium",
                "marker-symbol": "circle-stroked"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [vote.longitude, vote.latitude]
            },
        }))
    };

    const geojson = L.geoJson(geojsonData, {
        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, style(feature));
        },
        onEachFeature: onEachFeature
    }).addTo(map);
});

const legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'info legend');
    const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
    let labels = [];
    let from, to;

    for (let i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];

        labels.push(
            `<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`
        );
    }

    div.innerHTML = labels.join('<br>');
    return div;
};

legend.addTo(map);
