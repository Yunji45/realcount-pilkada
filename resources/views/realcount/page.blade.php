@extends('layouts.dashboard.app')
@section('content')
    <div class="page-inner">
        <div class="row text-center">
            <div class="col-md-2 offset-md-1">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;">{{ $total_votes }}</h3>
                        <p style="color: black;">Suara Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;">{{ $total_tps }}</h3>
                        <p style="color: black;">TPS Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;">{{ $total_candidates }}</h3>
                        <p style="color: black;">Kandidat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;">1.887.881</h3>
                        <p style="color: black;">DPT</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;" id="time-display">17:05:20</h3>
                        <p style="color: black;">Pukul</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title mt-3 text-center">HASIL PERHITUNGAN CEPAT</h4><br>
                <div class="row row-demo-grid justify-content-center">
                    @foreach ($candidateId as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                        <div class="card" style="width: 100%;">
                            <img src="{{ Storage::url($item->candidate->photo) }}" class="card-img-top" alt="Logo Partai">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    {{ $item->candidate->name ?? $item->candidate->partai->name ?? 'Tidak Ada Nama' }}
                                </h5> <!-- Asumsikan Anda memiliki atribut 'name' -->
                                <p class="card-text">{{ $item->total_votes }} Suara</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> --}}
        {{-- <div class="card">
            <div class="card-body">
                <div class="container">
                    <h3 class="text-center">Pemilihan Walikota Dan Wakil Walikota</h3>
                    <div class="row text-center">
                        <!-- Kandidat 1 -->
                        <div class="col-md-3">
                            <div class="card" style="background-color: #ff4d4d;">
                                <img src="path_to_image1.jpg" class="card-img-top" alt="Kandidat 1" style="height: 150px; width: auto; margin: 10px auto;">
                                <div class="card-body">
                                    <p class="card-text" style="color: white;">188.788 Suara</p>
                                    <h2 style="color: white;">10%</h2>
                                    <p>Nama Kandidat</p>
                                </div>
                            </div>
                        </div>
                        <!-- Kandidat 2 -->
                        <div class="col-md-3">
                            <div class="card" style="background-color: #ffd700;">
                                <img src="path_to_image2.jpg" class="card-img-top" alt="Kandidat 2" style="height: 150px; width: auto; margin: 10px auto;">
                                <div class="card-body">
                                    <p class="card-text" style="color: white;">962.900 Suara</p>
                                    <h2 style="color: white;">52%</h2>
                                    <p>Nama Kandidat</p>
                                </div>
                            </div>
                        </div>
                        <!-- Kandidat 3 -->
                        <div class="col-md-3">
                            <div class="card" style="background-color: #4682b4;">
                                <img src="path_to_image3.jpg" class="card-img-top" alt="Kandidat 3" style="height: 150px; width: auto; margin: 10px auto;">
                                <div class="card-body">
                                    <p class="card-text" style="color: white;">362.900 Suara</p>
                                    <h2 style="color: white;">18%</h2>
                                    <p>Nama Kandidat</p>
                                </div>
                            </div>
                        </div>
                        <!-- Kandidat 4 -->
                        <div class="col-md-3">
                            <div class="card" style="background-color: #ffcc00;">
                                <img src="path_to_image4.jpg" class="card-img-top" alt="Kandidat 4" style="height: 150px; width: auto; margin: 10px auto;">
                                <div class="card-body">
                                    <p class="card-text" style="color: white;">462.900 Suara</p>
                                    <h2 style="color: white;">20%</h2>
                                    <p>Nama Kandidat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h3 class="text-center">QUICK COUNT</h3>
                    <div class="row text-center">
                        @foreach ($candidates_by_election as $electionId => $election)
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Election ID: {{ $electionId }}</h4>
                                    </div>
                                    <div class="row text-center">
                                        @foreach ($election['candidates'] as $candidate)
                                            <div class="col-md-3">
                                                <div class="card" style="background-color: black;">
                                                    <img src="{{ asset($candidate['candidate']['photo']) }}" class="card-img-top" alt="{{ $candidate['candidate']['name'] }}" style="height: 150px; width: auto; margin: 10px auto;">
                                                    <div class="card-body">
                                                        <p class="card-text" style="color: white;">{{ $candidate['total_votes'] }} Suara</p>
                                                        <h2 style="color: white;">{{ number_format(($candidate['total_votes'] / $total_votes) * 100, 2) }}%</h2>
                                                        <p style="color: white;">{{ $candidate['candidate']['name'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <script>
        function updateTime() {
            const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const now = new Date().toLocaleTimeString('id-ID', options);
            document.getElementById('time-display').textContent = now + ' WIB';
        }
        function autoRefresh() {
            setTimeout(function(){
                location.reload();
            }, 60000); //setiap 1 menit sekali
        }
        setInterval(updateTime, 1000);
        updateTime();
        autoRefresh();
    </script>
    
@endsection