@extends('layouts.dashboard.app')
@section('content')
    <div class="page-inner">
        <div class="row text-center">
            <div class="col-md-2 offset-md-1">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;font-size:20px;font-we">{{ $total_votes }}</h3>
                        <p style="color: black;font-size:15px">Suara Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;font-size:20px;font-we">{{ $total_tps }}</h3>
                        <p style="color: black;font-size:15px">TPS Masuk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;font-size:20px;font-we">{{ $total_candidates }}</h3>
                        <p style="color: black;font-size:15px">Kandidat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;font-size:20px;font-we">{{ $total_dpt }}</h3>
                        <p style="color: black;font-size:15px">DPT</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card" style="background-color: #eee8aa;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: black;font-size:20px;font-we" id="time-display">17:05:20</h3>
                        <p style="color: black;font-size:15px">Pukul</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elections and candidates section -->
        <div class="mt-4">
            <div class="card">
                <h3 class="text-center mt-3 mb-3">LIVE QUICK COUNT</h3>
                <div class="container">
                    <!-- Loop over each election -->
                    @foreach ($candidates_by_election as $electionId => $election)
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4>{{ $election['election_name'] }}</h4>
                                </div>
                                <div class="row text-center">
                                    <!-- Loop over each candidate -->
                                    @foreach ($election['candidates'] as $candidate)
                                    <div class="col-md-3" style="margin: 0.9%">
                                        <div class="card"
                                            style="background-color: #FFF; border: 2px solid {{ $candidate['candidate']['partai']['color'] ?? '#000' }};">
                                            <div class="card-body p-0">
                                                <!-- Candidate Image -->
                                                @if (!empty($candidate['candidate']['photo']))
                                                    <img src="{{ asset($candidate['candidate']['photo']) }}"
                                                        alt="{{ $candidate['candidate']['name'] }}" class="img-fluid"
                                                            style="height: 5%; object-fit: cover; width: 100%;">
                                                @else
                                                    <img src="{{ asset('template/assets/img/user-1.png') }}"
                                                        alt="{{ $candidate['candidate']['name'] }}"
                                                            style="height: 5%; object-fit: cover; width: 100%;">
                                                @endif

                                                <!-- Vote information -->
                                                <div class="p-3 text-center"
                                                    style="background-color: {{ $candidate['candidate']['partai']['color'] ?? 'black' }}; color: white;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0">{{ $candidate['total_votes'] }} Suara</p>
                                                        <h2 class="mb-0">{{ number_format(($candidate['total_votes'] / $total_dpt) * 100, 2) }}%</h2>
                                                    </div>
                                                    <hr>
                                                    <p class="mb-0 mt-2" style="font-weight: bold;font-size:20px">{{ $candidate['candidate']['name'] }}</p>
                                                </div>
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

    <script>
        function updateTime() {
            const options = {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const now = new Date().toLocaleTimeString('id-ID', options);
            document.getElementById('time-display').textContent = now + ' WIB';
        }

        function autoRefresh() {
            setTimeout(function() {
                location.reload();
            }, 60000); //setiap 1 menit sekali
        }
        setInterval(updateTime, 1000);
        updateTime();
        autoRefresh();
    </script>
@endsection
