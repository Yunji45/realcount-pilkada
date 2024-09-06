<div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
      </div>
    </div>
    <div class="row row-card-no-pd">
      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>Koordinator</b></h6>
                <p class="text-muted">All Customs Value</p>
              </div>
              <h4 class="text-info fw-bold">$170</h4>
            </div>
            <div class="progress progress-sm">
              <div
                class="progress-bar bg-info w-75"
                role="progressbar"
                aria-valuenow="75"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="text-muted mb-0">Change</p>
              <p class="text-muted mb-0">75%</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>Total Revenue</b></h6>
                <p class="text-muted">All Customs Value</p>
              </div>
              <h4 class="text-success fw-bold">$120</h4>
            </div>
            <div class="progress progress-sm">
              <div
                class="progress-bar bg-success w-25"
                role="progressbar"
                aria-valuenow="25"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="text-muted mb-0">Change</p>
              <p class="text-muted mb-0">25%</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>New Orders</b></h6>
                <p class="text-muted">Fresh Order Amount</p>
              </div>
              <h4 class="text-danger fw-bold">15</h4>
            </div>
            <div class="progress progress-sm">
              <div
                class="progress-bar bg-danger w-50"
                role="progressbar"
                aria-valuenow="50"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="text-muted mb-0">Change</p>
              <p class="text-muted mb-0">50%</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>New Users</b></h6>
                <p class="text-muted">Joined New User</p>
              </div>
              <h4 class="text-secondary fw-bold">12</h4>
            </div>
            <div class="progress progress-sm">
              <div
                class="progress-bar bg-secondary w-25"
                role="progressbar"
                aria-valuenow="25"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <p class="text-muted mb-0">Change</p>
              <p class="text-muted mb-0">25%</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Chart 1</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="doughnutChart1" style="width: 50%; height: 50%"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Chart 2</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="doughnutChart2" style="width: 50%; height: 50%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Chart 3</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="multipleBarChart" style="width: 50%; height: 50%"></canvas>
                </div>
            </div>
        </div>
    </div>


  </div>
