<select id="electionSelect">
    <option value="">Pilih Pemilu</option>
    <!-- Dropdown diisi secara dinamis -->
</select>

<button id="searchButton">Cari</button>

<canvas id="votesChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Mengambil daftar pemilu untuk dropdown
    axios.get('/api/elections').then(response => {
        const elections = response.data;
        const electionSelect = document.getElementById('electionSelect');
        
        elections.forEach(election => {
            const option = document.createElement('option');
            option.value = election.id;
            option.textContent = election.name;
            electionSelect.appendChild(option);
        });
    });

    // Fungsi untuk mengambil suara berdasarkan pemilu
    function fetchVotesByElection(electionId) {
        axios.get('/api/votes-per-election', {
            params: { election_id: electionId }
        }).then(response => {
            const data = response.data;

            if (data.length === 0) {
                alert("Tidak ada data suara untuk pemilu ini.");
                return;
            }

            const labels = data.map(vote => `${vote.candidate_name} (${vote.partai_name})`);
            const votes = data.map(vote => vote.total_votes);

            // Update chart dengan data baru
            const ctx = document.getElementById('votesChart').getContext('2d');
            const votesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Suara',
                        data: votes,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    }

    // Event listener untuk tombol pencarian
    document.getElementById('searchButton').addEventListener('click', function() {
        const electionId = document.getElementById('electionSelect').value;
        if (electionId) {
            fetchVotesByElection(electionId);
        } else {
            alert("Pilih pemilu terlebih dahulu.");
        }
    });
</script>
