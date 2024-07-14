@extends('layouts.app')

@section('content')

    @php
        $user = auth()->user();
        $name = 'Administrator';

        if ($user->tipe == 'konselor') {
            $name = $user->konselor->nama_konselor;
        } elseif ($user->tipe == 'siswa') {
            $name = $user->siswa->nama_lengkap;
        } elseif ($user->tipe == 'orangtua') {
            $name = $user->orangtua->nama;
        } elseif ($user->tipe == 'kepala_sekolah') {
            $name = $user->kepala_sekolah->nama;
        }
    @endphp

    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-primary overflow-hidden mb-0">
                        <div class="position-absolute bottom-0" style="opacity: 0.15;">
                            <img src="assets/images/effect-pattern/pattern-2.svg" alt="" class="img-fluid">
                        </div>
                        <div class="card-body position-relative">
                            <h6 class="text-white fs-md fw-medium mt-4">Selamat Datang {{ $name }}</h6>
                            <p class="text-white-75"></p>
                        </div>
                    </div>
                </div>
            </div>
            @if ($user->tipe != 'siswa')
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="fs-md text-muted mb-4">Total Siswa</p>
                                <h3 class="mb-n3"><span class="counter-value"
                                        data-target="{{ $siswa->count() }}">{{ number_format($siswa->count()) }}</span></h3>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="fs-md text-muted mb-4">Total Konselor</p>
                                <h3 class="mb-n3"><span class="counter-value"
                                        data-target="{{ $konselor->count() }}">{{ number_format($konselor->count()) }}</span>
                                </h3>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($user->tipe == 'admin' || $user->tipe == 'kepala_sekolah')
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Siswa yang melakukan konsultasi</h5>
                            </div>
                            <div class="card-body">
                                <div id="column_chart" data-colors='["--tb-danger", "--tb-primary", "--tb-success"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Data Bk Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <table id="example"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle mt-2"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Siswa</th>
                                            <th>Konselor</th>
                                            <th>Tanggal BK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bk as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ strtoupper($item->jenis) }}</td>
                                                <td>{{ $item->siswa->nama_lengkap }} - {{ $item->siswa->nik }}</td>
                                                <td>{{ $item->konselor->nama_konselor }} - {{ $item->konselor->nip }}</td>
                                                <td>{{ date('d-m-Y H:i', strtotime($item->tgl_bk)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div><!--end col-->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@push('scripts')
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script>
        function getChartColorsArray(e) {
            var t = document.getElementById(e);
            if (t) {
                t = t.dataset.colors;
                if (t)
                    return JSON.parse(t).map((e) => {
                        var t = e.replace(/\s/g, "");
                        return t.includes(",") ?
                            2 === (e = e.split(",")).length ?
                            `rgba(${getComputedStyle(
                document.documentElement
              ).getPropertyValue(e[0])}, ${e[1]})` :
                            t :
                            getComputedStyle(document.documentElement).getPropertyValue(t) || t;
                    });
                console.warn("data-colors attribute not found on: " + e);
            }
        }
        var chartColumnChart = "",
            chartColumnDatatalabelChart = "",
            chartColumnStackedChart = "",
            chartColumnStacked100Chart = "",
            columnGroupedStackedChart = "",
            columnDumbbellChart = "",
            chartColumnMarkersChart = "",
            chartColumnRotateLabelsChart = "",
            chartNagetiveValuesChart = "",
            chartBarChart = "",
            chartNagetiveValuesChart = "",
            chartColumnDistributedChart = "",
            chartColumnGroupLabelsChart = "";

        var laki = "{{ json_encode($laki) }}";
        laki = laki.replace('"', '');
        laki = laki.replace('[', '');
        laki = laki.replace(']', '');

        var perempuan = "{{ json_encode($perempuan) }}";
        perempuan = perempuan.replace('"', '');
        perempuan = perempuan.replace('[', '');
        perempuan = perempuan.replace(']', '');

        function loadCharts(laki, perempuan) {
            (e = getChartColorsArray("column_chart")) &&
            ((t = {
                chart: {
                    height: 350,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "45%",
                        endingShape: "rounded"
                    },
                },
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    show: !0,
                    width: 2,
                    colors: ["transparent"]
                },
                series: [{
                        name: "Laki-Laki",
                        data: laki.split(",")
                        // data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    },
                    {
                        name: "Perempuan",
                        data: perempuan.split(",")
                        // data: [74, 83, 102, 97, 86, 106, 93, 114, 94, 32, 41,]
                    },
                ],
                colors: e,
                xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "Mei",
                        "Jun",
                        "Jul",
                        "Agu",
                        "Sep",
                        "Okt",
                        "Nov",
                        "Des",
                    ],
                },
                yaxis: {
                    title: {
                        text: "Siswa"
                    }
                },
                grid: {
                    borderColor: "#f1f1f1"
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(e) {
                            return e + " siswa";
                        },
                    },
                },
            }),
            "" != chartColumnChart && chartColumnChart.destroy(),
            (chartColumnChart = new ApexCharts(
                document.querySelector("#column_chart"),
                t
            )).render());
        }

        loadCharts(laki, perempuan);
    </script>
@endpush
