@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filter</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('filter-laporan-siswa') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Siswa</label>
                                        <select class="form-control select2" name="siswa_id" required>
                                            <option value="">Pilih Siswa</option>
                                            @foreach ($siswa as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mt-4">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="from" required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>s/d</label>
                                        <input type="date" class="form-control" name="to" required>
                                        <button class="btn btn-primary mt-4" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 @if(!$filter) d-none @endif" id="cardLaporan">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Laporan Per Periode
                                @if ($filter)
                                    <br> Filter {{ date('d-m-Y', strtotime($from)) }} s/d {{ date('d-m-Y', strtotime($to)) }}
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong>  {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Sukses!</strong>  {{ Session::get('success'); }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle mt-2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nis</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Konselor</th>
                                        <th>Tanggal BK</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->siswa->nik }}</td>
                                                <td>{{ $item->siswa->nama_lengkap }}</td>
                                                <td><span class="badge bg-secondary">{{ strtoupper($item->jenis) }}</span></td>
                                                <td>{{ $item->konselor->nama_konselor }}</td>
                                                <td>{{ date('d-m-Y H:i:s', strtotime($item->tgl_bk)) }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @endif
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push("scripts")
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('.select2').select2();
    </script>
@endpush