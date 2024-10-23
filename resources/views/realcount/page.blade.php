@extends('layouts.dashboard.app')
@section('content')
    <div class="page-inner">
        <div class="page-header">
        <h3 class="fw-bold mb-3">Realcount System</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
            <a href="#">
                <i class="icon-home"></i>
            </a>
            </li>
            <li class="separator">
            <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
            <a href="#">Base</a>
            </li>
            <li class="separator">
            <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
            <a href="#">Realcount System</a>
            </li>
        </ul>
        </div>
        <div class="card">
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
        </div>
        <div class="row row-demo-grid">
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #7FFF00;">
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #0e0f0f;">Suara Masuk : {{ $vote }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #FF00FF;">
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #0e0f0f;">TPS Masuk : {{ $tps }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #DAA520;">
                    <div class="card-body">
                        <h5 class="card-title text-center" style="color: #0e0f0f;">Candidate : {{ $candidate }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; background-color: #FF4500;">
                    <div class="card-body">
                        <h5 class="card-title text-center" id="time-display" style="color: #0e0f0f;"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateTime() {
            const options = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const now = new Date().toLocaleTimeString('id-ID', options);
            document.getElementById('time-display').textContent = 'Pukul : ' + now + ' WIB';
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