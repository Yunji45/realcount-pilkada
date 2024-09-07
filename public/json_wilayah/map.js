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
                    "id": "01",
                    "properties": {
                        "name": "Kabupaten Bandung",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [107.517155331259, -7.024827110631676],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "02",
                    "properties": {
                        "name": "Kabupaten Bandung Barat",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,

                    },
                    "geometry": {
                        "coordinates": [107.51728506531941, -6.838105634266569],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "03",
                    "properties": {
                        "name": "Kabupaten Bekasi",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [107.15963127433463, -6.311956714428291],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "04",
                    "properties": {
                        "name": "Kabupaten Bogor",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [106.84752682519485, -6.478762977759217],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "05",
                    "properties": {
                        "name": "Kabupaten Ciamis",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [108.35059587220877, -7.3224231370126205],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "06",
                    "properties": {
                        "name": "Kabupaten Cianjur",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [107.14461084095444, -6.8101680432524745],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "07",
                    "properties": {
                        "name": "Kabupaten Cirebon",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [108.48177685508222, -6.75789284348771],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "08",
                    "properties": {
                        "name": "Kabupaten Garut",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [107.89582147466808, -7.20691206664803],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "09",
                    "properties": {
                        "name": "Kabupaten Indramayu",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [108.32465514049773, -6.323465631759092],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "10",
                    "properties": {
                        "name": "Kabupaten Karawang",
                        "paslon 1": 1,
                        "paslon 2": 2,
                        "paslon 1": 3,
                    },
                    "geometry": {
                        "coordinates": [107.30732619090094, -6.304372704635185],
                        "type": "Point"
                    }
                },
                {
                    "type": "Feature",
                    "id": "11",
                    "properties": {
                      "name": "Kabupaten Kuningan"
                    },
                    "geometry": {
                      "coordinates": [
                        108.48292791527012,
                        -6.9745807882884066
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "12",
                    "properties": {
                      "name": "Kabupaten Majalengka"
                    },
                    "geometry": {
                      "coordinates": [
                        108.22340475314621,
                        -6.830628428300017
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "13",
                    "properties": {
                      "name": "Kabupaten Pangandaran"
                    },
                    "geometry": {
                      "coordinates": [
                        108.6491777443353,
                        -7.679536213418928
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "14",
                    "properties": {
                      "name": "Kabupaten Purwakarta"
                    },
                    "geometry": {
                      "coordinates": [
                        107.4434812364434,
                        -6.55004446741026
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "15",
                    "properties": {
                      "name": "Kabupaten Subang"
                    },
                    "geometry": {
                      "coordinates": [
                        107.7590027106653,
                        -6.563905884250829
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "16",
                    "properties": {
                      "name": "Kabupaten Sukabumi"
                    },
                    "geometry": {
                      "coordinates": [
                        106.521503364419,
                        -6.970197752286907
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "17",
                    "properties": {
                      "name": "Kabupaten Sumedang"
                    },
                    "geometry": {
                      "coordinates": [
                        107.92482390351495,
                        -6.842805171857918
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "18",
                    "properties": {
                      "name": "Kabupaten Tasikmalaya"
                    },
                    "geometry": {
                      "coordinates": [
                        108.11027572495988,
                        -7.349905462018427
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "19",
                    "properties": {
                      "name": "Kota Bandung"
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
                    "id": "20",
                    "properties": {
                      "name": "Kota Banjar"
                    },
                    "geometry": {
                      "coordinates": [
                        108.54082578118948,
                        -7.3739364868403925
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "21",
                    "properties": {
                      "name": "Kota Bekasi"
                    },
                    "geometry": {
                      "coordinates": [
                        106.99076148511642,
                        -6.245193240862605
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "22",
                    "properties": {
                      "name": "Kota Bogor"
                    },
                    "geometry": {
                      "coordinates": [
                        106.8105833006532,
                        -6.606274388704861
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "23",
                    "properties": {
                      "name": "Kota Cimahi"
                    },
                    "geometry": {
                      "coordinates": [
                        107.54389787491084,
                        -6.8738182334588345
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "24",
                    "properties": {
                      "name": "Kota Cirebon"
                    },
                    "geometry": {
                      "coordinates": [
                        108.55969232396421,
                        -6.710640306588189
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "25",
                    "properties": {
                      "name": "Kota Depok"
                    },
                    "geometry": {
                      "coordinates": [
                        106.81556288793149,
                        -6.40666438417351
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "26",
                    "properties": {
                      "name": "Kota Sukabumi"
                    },
                    "geometry": {
                      "coordinates": [
                        106.9257630531983,
                        -6.91055698020017
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id":"27",
                    "properties": {
                      "name":"Kota Tasikmalaya"
                    },
                    "geometry": {
                      "coordinates": [
                        108.22039015567833,
                        -7.3219025115428025
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "28",
                    "properties": {
                      "name": "Kabupaten Banjarnegara",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.6947869656887,
                        -7.394491264523737
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "29",
                    "properties": {
                      "name": "Kabupaten Purwokerto",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.24385004727094,
                        -7.423089762344276
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "30",
                    "properties": {
                      "name": "Kabupaten Batang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.73064324885297,
                        -6.9041653912403405
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "31",
                    "properties": {
                      "name": "Kabupaten Blora",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        111.4130945303487,
                        -6.967090589616362
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "32",
                    "properties": {
                      "name": "Kabupaten Boyolali",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.59934539934858,
                        -7.530475136468397
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "33",
                    "properties": {
                      "name": "Kabupaten Brebes",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.0357827264533,
                        -6.867148945293735
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "34",
                    "properties": {
                      "name": "Kabupaten Cilacap",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.01304427923861,
                        -7.713279802113917
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "35",
                    "properties": {
                      "name": "Kabupaten Demak",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.63583725655155,
                        -6.8899939062878985
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "36",
                    "properties": {
                      "name": "Kabupaten Grobogan",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.91619133201579,
                        -7.080849967780793
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "37",
                    "properties": {
                      "name": "Kabupaten Jepara",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.66550219818964,
                        -6.59073447692343
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "38",
                    "properties": {
                      "name": "Kabupaten Karanganyar",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.93711905085502,
                        -7.586189645620806
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "39",
                    "properties": {
                      "name": "Kabupaten Kebumen",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.65583624030063,
                        -7.671243849357708
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "40",
                    "properties": {
                      "name": "Kabupaten Kendal",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.20169007664992,
                        -6.919692499256854
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "41",
                    "properties": {
                      "name": "Kabupaten Klaten",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.60222710797427,
                        -7.701411610587627
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "42",
                    "properties": {
                      "name": "Kabupaten Kudus",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.84022904850212,
                        -6.805029007637728
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "43",
                    "properties": {
                      "name": "Kabupaten Magelang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.22012892064913,
                        -7.592696673102097
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "44",
                    "properties": {
                      "name": "Kabupaten Pati",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        111.0286597548644,
                        -6.750821120330031
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "45",
                    "properties": {
                      "name": "Kabupaten Pekalongan",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.5781032109224,
                        -7.031784433197615
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "46",
                    "properties": {
                      "name": "Kabupaten Pemalang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.38398331171959,
                        -6.885708485749774
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "47",
                    "properties": {
                      "name": "Kabupaten Purbalingga",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.36129933741972,
                        -7.383089795111488
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "48",
                    "properties": {
                      "name": "Kabupaten Purworejo",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.00472132520304,
                        -7.713439631702386
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "49",
                    "properties": {
                      "name": "Kabupaten Rembang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        111.33940558478224,
                        -6.7067667843707
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "50",
                    "properties": {
                      "name": "Kabupaten Semarang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.40907511140489,
                        -7.133067479354892
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "51",
                    "properties": {
                      "name": "Kabupaten Sragen",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        111.02168903469618,
                        -7.4223697157326
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "52",
                    "properties": {
                      "name": "Kabupaten Sukoharjo",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.84054963609606,
                        -7.6792559775820735
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "53",
                    "properties": {
                      "name": "Kabupaten Tegal",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.13626280766704,
                        -6.982344837493798
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "54",
                    "properties": {
                      "name": "Kabupaten Temanggung",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.17655558718411,
                        -7.312748964621505
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "55",
                    "properties": {
                      "name": "Kabupaten Wonogiri",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.92034561338954,
                        -7.804537707899698
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "56",
                    "properties": {
                      "name": "Kabupaten Wonosobo",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.90374203455013,
                        -7.358575975761525
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "57",
                    "properties": {
                      "name": "Kota Magelang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.21599965188642,
                        -7.473787517854859
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "58",
                    "properties": {
                      "name": "Kota Pekalongan",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        109.66425548902441,
                        -6.880195706516375
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "59",
                    "properties": {
                      "name": "Kota Salatiga",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.50084949880176,
                        -7.321836419509324
                      ],
                      "type": "Point"
                    }
                  },
                  {
                    "type": "Feature",
                    "id": "60",
                    "properties": {
                      "name": "Kota Semarang",
                      "marker-color": "#f70202",
                      "marker-symbol": "circle"
                    },
                    "geometry": {
                      "coordinates": [
                        110.41924704949332,
                        -6.970914920675057
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