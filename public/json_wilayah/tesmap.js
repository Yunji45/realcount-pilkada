// Inisialisasi peta
const map = L.map('map').setView([-6.9320011, 107.5733367], 12);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://portofolio-ihya.netlify.app">DPC Gerindra</a>'
}).addTo(map);

// Kontrol informasi
const info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};

info.update = function (props) {
    const contents = props ? `<b>${props.kelurahan_name}</b>` : 'Nama Lokasi';
    this._div.innerHTML = `<h4></h4>${contents}`;
};

info.addTo(map);

// Fungsi untuk mendapatkan warna marker berdasarkan warna partai
function getColor(partaiColor) {
    return partaiColor || '#FFEDA0'; // Default jika warna tidak ada
}

// Fungsi style
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
let geojson; // Definisikan geojson secara global

function resetHighlight(e) {
    if (geojson) {
        geojson.resetStyle(e.target);
    }
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
            let content = `<b>${props.kelurahan_name}</b>`;
            content += `<b> (RW : ${props.rw})</b><br>`;
            if (props.parties && props.parties.length > 0) {
                content += `<ul>`;
                let totalVotes = 0;
                props.parties.forEach(party => {
                    totalVotes += party.total_votes;
                    content += `<li>Partai: ${party.partai_name}, Total Vote: ${party.total_votes}, Persentase: ${party.vote_percentage}%</li>`;
                });
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
                const longitude = parseFloat(item.longitude);
                const latitude = parseFloat(item.latitude);
                if (isNaN(longitude) || isNaN(latitude)) {
                    console.warn(`Invalid coordinates for kelurahan: ${item.kelurahan_name}`);
                    return null; 
                }
                return {
                    "type": "Feature",
                    "properties": {
                        "kelurahan_name": item.kelurahan_name,
                        "kecamatan_name": item.kecamatan_name,
                        "kabupaten_name": item.kabupaten_name,
                        "provinsi_name": item.provinsi_name,
                        "total_dpt": item.total_dpt,
                        "parties": item.parties,
                        "rw": item.rw,
                    },
                    "geometry": {
                        "type": "Point",
                        "coordinates": [longitude, latitude]
                    }
                };
            }).filter(item => item !== null)
        };
        geojson = L.geoJson(geojsonData, {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, style(feature));
            },
            onEachFeature: onEachFeature
        }).addTo(map);
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

// Ambil warna partai dari API
const partiesColors = [];

// Ambil data dari API untuk warna partai
fetch('https://dpcgerindrakotabandung.com/api/color-partai')
    .then(response => response.json())
    .then(data => {
        data.forEach(party => {
            partiesColors.push({
                name: party.name,
                color: party.color
            });
        });

        // Panggil fungsi untuk membuat legenda
        createLegend(partiesColors);
    })
    .catch(error => {
        console.error('Error fetching party colors:', error);
    });

// Fungsi untuk membuat legenda berdasarkan partiesColors
function createLegend(colors) {
    const legend = L.control({ position: 'bottomright' });

    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = '<h4>Warna Partai </h4>';

        colors.forEach(party => {
            div.innerHTML += `
                <div class="party-card">
                    <i style="background:${party.color};"></i>
                    <span>${party.name}</span>
                </div>
            `;
        });

        return div;
    };

    legend.addTo(map);
}

// Tambahkan kontrol pencarian ke peta
const geocoder = L.Control.Geocoder.nominatim();
L.Control.geocoder({
    geocoder: geocoder,
    placeholder: 'Cari kelurahan...'
}).addTo(map);