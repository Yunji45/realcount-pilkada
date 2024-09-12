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
                fillColor: getColor(feature.properties.partai_color),
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
                click: function(e) {
                    const props = e.target.feature.properties;
                    const content = `
                        <b>${props.kelurahan_name}</b><br>
                        Partai: ${props.partai_name}<br>
                        Total Vote: ${props.total_vote_per_kelurahan_partai}
                    `;
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
                    "features": data.map(item => ({
                        "type": "Feature",
                        "properties": {
                            "kelurahan_name": item.kelurahan_name,
                            "kecamatan_name": item.kecamatan_name,
                            "kabupaten_name": item.kabupaten_name,
                            "provinsi_name": item.provinsi_name,
                            "partai_name": item.partai_name,
                            "partai_color": item.partai_color,
                            "total_vote_per_kelurahan_partai": item.total_vote_per_kelurahan_partai
                        },
                        "geometry": {
                            "type": "Point",
                            "coordinates": [parseFloat(item.longitude), parseFloat(item.latitude)]
                        }
                    }))
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
        const legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            div.innerHTML = '<h4>Legenda</h4>';
            return div;
        };

        legend.addTo(map);