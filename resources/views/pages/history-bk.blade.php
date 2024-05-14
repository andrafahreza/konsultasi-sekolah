@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">History BK</h5>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle mt-2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Siswa</th>
                                        <th>Konselor</th>
                                        <th>Tanggal BK</th>
                                        <th>Isi</th>
                                        <th>Tindakan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ strtoupper($item->jenis) }}</td>
                                            <td>{{ $item->siswa->nama_lengkap }} - {{ $item->siswa->nik }}</td>
                                            <td>{{ $item->konselor->nama_konselor }} - {{ $item->konselor->nip }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($item->tgl_bk)) }}</td>
                                            <td>
                                                @if ($item->isi == null)
                                                    -
                                                @else
                                                    {{ $item->isi }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->tindakan == null)
                                                    -
                                                @else
                                                    {{ $item->tindakan }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->tindakan == null)
                                                    <span class="badge bg-danger">Tidak melakukan konsultasi</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@push("styles")
    <link rel="stylesheet" href="/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" >
    <link rel="stylesheet" href="/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" >
    <link rel="stylesheet" href="/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@push("scripts")
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
@endpush
