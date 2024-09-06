<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Pilkada | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('template/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('template/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/kaiadmin.mins.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            @include('layouts.dashboard.partials.sidebar')
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                @include('layouts.dashboard.partials.navbar')
            </div>

            <div class="container">
                @yield('content')
            </div>

            <footer class="footer">
                @include('layouts.dashboard.partials.footer')
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('template/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('template/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('template/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('template/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('template/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('template/assets/js/kaiadmin.min.js') }}"></script>
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Doughnut Chart 1
        var doughnutChart1 = document.getElementById("doughnutChart1").getContext("2d");

        var myDoughnutChart1 = new Chart(doughnutChart1, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: ["#f3545d", "#fdaf4b", "#1d7af3"],
                }],
                labels: ["Red", "Yellow", "Blue"],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
            },
        });

        // Doughnut Chart 2
        var doughnutChart2 = document.getElementById("doughnutChart2").getContext("2d");

        var myDoughnutChart2 = new Chart(doughnutChart2, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [15, 25, 35],
                    backgroundColor: ["#4bc0c0", "#565656", "#ffcd56"],
                }],
                labels: ["Cyan", "Gray", "Yellow"],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
            },
        });
    </script>

    <script>
        var multipleBarChart = document
            .getElementById("multipleBarChart")
            .getContext("2d");

        var myMultipleBarChart = new Chart(multipleBarChart, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [{
                        label: "First time visitors",
                        backgroundColor: "#59d05d",
                        borderColor: "#59d05d",
                        data: [95, 100, 112, 101, 144, 159, 178, 156, 188, 190, 210, 245],
                    },
                    {
                        label: "Visitors",
                        backgroundColor: "#fdaf4b",
                        borderColor: "#fdaf4b",
                        data: [
                            145, 256, 244, 233, 210, 279, 287, 253, 287, 299, 312, 356,
                        ],
                    },
                    {
                        label: "Pageview",
                        backgroundColor: "#177dff",
                        borderColor: "#177dff",
                        data: [
                            185, 279, 273, 287, 234, 312, 322, 286, 301, 320, 346, 399,
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                title: {
                    display: true,
                    text: "Traffic Stats",
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                    }, ],
                    yAxes: [{
                        stacked: true,
                    }, ],
                },
            },
        });
    </script>




</body>

</html>
