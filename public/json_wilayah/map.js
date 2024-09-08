        // const map = L.map('map').setView([-7.314931134411498, 108.43086308707107], 8);
        // const map = L.map('map').setView([-6.9854865,109.3917492], 8);
        const map = L.map('map').setView([-6.9320011,107.5733367], 12)

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://portofolio-ihya.netlify.app">Ihya Natik W</a>'
        }).addTo(map);

        // Control that shows state info on hover
        const info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function (props) {
            const contents = props ? `<b>${props.name}</b>` : 'Bandung';
            this._div.innerHTML = `<h4>Area Coverage</h4>${contents}`;
        };

        info.addTo(map);

        // Get color depending on some property value
        function getColor(d) {
            return d > 1000 ? '#800026' :
                d > 500 ? '#BD0026' :
                d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                d > 20 ? '#FEB24C' :
                d > 10 ? '#FED976' : '#FFEDA0';
        }

        // function style(feature) {
        //     return {
        //         weight: 2,
        //         opacity: 1,
        //         color: 'white',
        //         dashArray: '3',
        //         fillOpacity: 0.7,
        //         fillColor: getColor(feature.properties.density || 0) // Assuming density is not available, default to 0
        //     };
        // }
        function style(feature) {
            // Menentukan warna berdasarkan properti name
            let fillColor;
            if (feature.properties.name.includes("Kabupaten")) {
                fillColor = 'blue'; // Warna untuk kabupaten
            } else {
                fillColor = 'red'; // Warna untuk kota
            }
            
            return {
                radius: 8, // Ukuran titik
                fillColor: fillColor, // Warna titik
                color: "#000", // Warna garis tepi
                weight: 1, // Ketebalan garis tepi
                opacity: 1, // Opasitas garis tepi
                fillOpacity: 0.8 // Opasitas dari pengisian area
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
                        paslon 1: ${props.rajal}<br>
                        paslon 2: ${props.ranap}<br>
                        paslon 3: ${props.khitan}<br>
                    `;
                    L.popup()
                        .setLatLng(e.latlng)
                        .setContent(content)
                        .openOn(map);
                }
            });
        }

        const geojsonData = {
            "type": "FeatureCollection",
            "features": [
                
                  {
                    "type": "Feature",
                    "id": "19",
                    "properties": {
                      "name": "Kota Bandung",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        107.61251076914903,
                        -6.914801616473682
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "61",
                    "properties": {
                      "name": "Kota Surakarta",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.81891675856923,
                        -7.568604772280054
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "62",
                    "properties": {
                      "name": "Kota Tegal",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.13913152721034,
                        -6.857902234359486
                      ],
                      "type": "Point"
                    }
                  }
                // Tambahkan fitur lainnya dengan cara yang sama
            ]
        };
        

        const geojson = L.geoJson(geojsonData, {
            style,
            onEachFeature
        }).addTo(map);

        map.attributionControl.addAttribution('Data Kunjungan &copy; <a href="http://klinikmitradelima.com/">test</a>');

        const legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
            const labels = [];
            let from, to;

            for (let i = 0; i < grades.length; i++) {
                from = grades[i];
                to = grades[i + 1];

                labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
            }

            div.innerHTML = labels.join('<br>');
            return div;
        };

        legend.addTo(map);

        // Add search control
        const searchControl = new L.Control.Search({
            layer: geojson,
            propertyName: 'name',
            marker: false,
            moveToLocation: function(latlng, title, map) {
                // Zoom the map to the searched location
                map.setView(latlng, 12); // Adjust zoom level as needed
            }
        });

        searchControl.on('search:locationfound', function(e) {
            e.layer.setStyle({
                weight: 3,
                color: '#0f0',
                dashArray: '',
                fillOpacity: 0.7
            });
            if (e.layer._popup) e.layer.openPopup();
        }).on('search:collapsed', function(e) {
            geojson.eachLayer(function(layer) {
                geojson.resetStyle(layer);
            });
        });

        map.addControl(searchControl);