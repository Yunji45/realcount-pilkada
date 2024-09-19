const map = L.map('map').setView([-6.9320011, 107.5733367], 12);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://portofolio-ihya.netlify.app">Ihya Natik W</a>'
}).addTo(map);

// Kontrol informasi
const info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};

info.update = function (props) {
    const contents = props ? `<b>${props.kelurahan_name}</b>` : 'Pilih lokasi';
    this._div.innerHTML = `<h4>Detail Lokasi</h4>${contents}`;
};

info.addTo(map);

// Fungsi untuk menentukan warna marker berdasarkan warna partai
function getColor(partaiColor) {
    return partaiColor || '#FFEDA0'; // Default jika warna tidak ada
}

// Style fungsi
function style(feature) {
    return {
        radius: 8,
        fillColor: getColor(feature.properties.parties[0]?.partai_color),
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.8
    };
}

// Fungsi untuk meng-highlight lokasi
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

// Fungsi untuk mereset highlight
function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

// Fungsi untuk zoom ke fitur
function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}

// Fungsi untuk setiap fitur
function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: function (e) {
            const props = e.target.feature.properties;

            // Perhitungan persentase suara
            let content = `<b>${props.kelurahan_name}</b><br>`;
            if (props.parties && props.parties.length > 0) {
                content += `<ul>`;
                let totalVotes = 0;
                props.parties.forEach(party => {
                    totalVotes += party.total_votes;
                    content += `<li>Partai: ${party.partai_name}, Total Vote: ${party.total_votes}, Persentase: ${party.vote_percentage}%</li>`;
                });

                // Hitung persentase jika dpt ada
                let dpt = props.total_dpt || 0;
                let percentage = dpt > 0 ? ((totalVotes / dpt) * 100).toFixed(2) : 0;

                content += `</ul>`;
                content += `<p>Total Suara: ${totalVotes}<br>`;
                content += `Jumlah DPT: ${dpt}<br>`;
                content += `Persentase Suara: ${percentage}%</p>`;
            } else {
                content += `No party data available.`;
            }

            L.popup()
                .setLatLng(e.latlng)
                .setContent(content)
                .openOn(map);
        }
    });
}

// Ambil data dari API dan tambahkan ke peta
fetch('https://dpcgerindrakotabandung.com/api/map')
    .then(response => response.json())
    .then(data => {
        const geojsonData = {
            "type": "FeatureCollection",
            "features": data.map(item => {
                // Validasi koordinat
                const longitude = parseFloat(item.longitude);
                const latitude = parseFloat(item.latitude);

                // Jika latitude atau longitude bukan angka, abaikan data ini
                if (isNaN(longitude) || isNaN(latitude)) {
                    console.warn(`Invalid coordinates for kelurahan: ${item.kelurahan_name}`);
                    return null; // Abaikan fitur ini
                }

                return {
                    "type": "Feature",
                    "properties": {
                        "kelurahan_name": item.kelurahan_name,
                        "kecamatan_name": item.kecamatan_name,
                        "kabupaten_name": item.kabupaten_name,
                        "provinsi_name": item.provinsi_name,
                        "total_dpt": item.total_dpt,  // Total DPT per kelurahan
                        "parties": item.parties, // array partai yang sudah di-looping dari API
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [longitude, latitude]
                    }
                };
            }).filter(item => item !== null) // Filter data yang valid saja
        };

        const geojson = L.geoJson(geojsonData, {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, style(feature));
            },
            onEachFeature: onEachFeature
        }).addTo(map);
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

// Tambahkan kontrol legend jika diperlukan
const legend = L.control({ position: 'bottomright' });

legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'info legend');
    div.innerHTML = '<h4>Legenda</h4>';
    return div;
};

legend.addTo(map);

// Tambahkan kontrol pencarian ke peta
const geocoder = L.Control.Geocoder.nominatim();
L.Control.geocoder({
    geocoder: geocoder,
    placeholder: 'Cari kelurahan...'
}).addTo(map);
