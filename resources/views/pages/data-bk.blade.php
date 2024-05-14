@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data BK</h5>
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

                            <button type="button" class="btn btn-primary" id="btnTambah">+ Tambah</button> <br><br>

                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle mt-2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Siswa</th>
                                        <th>Konselor</th>
                                        <th>Tanggal BK</th>
                                        <th>Batas Waktu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ strtoupper($item->jenis) }}</td>
                                            <td>{{ $item->siswa->nama_lengkap }} - {{ $item->siswa->nik }}</td>
                                            <td>{{ $item->konselor->nama_konselor }} - {{ $item->konselor->nip }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($item->tgl_bk)) }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($item->batas_waktu)) }}</td>
                                            <td>
                                                @if (auth()->user()->tipe == "admin")
                                                    <button type="button" class="btn btn-secondary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                    <button type="button" class="btn btn-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
                                                @else
                                                    @if (strtotime(date('Y-m-d H:i:s')) >= strtotime(date($item->tgl_bk)))
                                                        <a href="{{ route('start-chat', [$item->id]) }}" class="btn btn-warning">Mulai</a>
                                                    @else
                                                        <span class="badge bg-secondary">Belum dapat memulai konsultasi</span>
                                                    @endif
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

    <div class="modal fade modalBk" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <form action="{{ route('data-bk-simpan') }}" method="POST" id="formBk">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Data BK</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errorMessage d-none">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>  <span id="spanError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Jenis <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis" id="jenis" required>
                                    <option value="">Pilih Jenis Konsultasi</option>
                                    <option value="bully">Bully</option>
                                    <option value="konsultasi">Konsultasi</option>
                                </select>
                            </div>
                            @if (auth()->user()->tipe != "siswa")
                                <div class="col-md-6 mt-4">
                                    <label>Siswa <span class="text-danger">*</span></label><br>
                                    <select class="form-control select2" name="siswa_id" id="siswa_id" style="width: 100%" required>
                                        <option value="">Pilih Siswa</option>
                                        @foreach ($siswa as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_lengkap }} - {{ $item->nik }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="siswa_id" value="{{ auth()->user()->siswa->id }}">
                            @endif
                            @if (auth()->user()->tipe != "konselor")
                                <div class="col-md-6 mt-4">
                                    <label>Konselor <span class="text-danger">*</span></label><br>
                                    <select class="form-control select2" name="konselor_id" id="konselor_id" style="width: 100%" required>
                                        <option value="">Pilih Konselor</option>
                                        @foreach ($konselor as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_konselor }} - {{ $item->nip }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="konselor_id" value="{{ auth()->user()->konselor->id }}">
                            @endif
                            <div class="col-md-6 mt-4">
                                <label>Tanggal BK <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="tgl_bk" id="tgl_bk" required>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label>Batas Waktu <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="batas_waktu" id="batas_waktu" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Hapus Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menghapus data ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('data-bk-hapus') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="hapus_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
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
        $('.select2').select2({
            dropdownParent: $(".modalBk")
        });

        $('#btnTambah').on('click', function() {
            $('#formBk')[0].reset();
            $('#errorMessage').addClass('d-none');
            $('.modalBk').modal('toggle');
        })

        function edit(id) {
            $('#formBk')[0].reset();
            var url = "{{ route('show-data-bk') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('.modalBk').modal('toggle');
                        $('#errorMessage').addClass('d-none');

                        const data = response.data;
                        $('#formBk')[0].reset();
                        $('#formBk').attr("action", "{{ route('data-bk-simpan') }}" + "/" + data.id);
                        $('#jenis').val(data.jenis);
                        $('#siswa_id').val(data.siswa_id).trigger('change');
                        $('#konselor_id').val(data.konselor_id).trigger('change');
                        $('#tgl_bk').val(data.tgl_bk);
                        $('#batas_waktu').val(data.batas_waktu);
                    } else {
                        $('#errorMessage').removeClass('d-none');
                        $('#spanError').text(response.message);
                    }
                },
                error: function(response) {
                    $('#errorMessage').removeClass('d-none');
                    $('#spanError').text(response.message);
                }
            });
        }

        function hapus(id) {
            $('#hapus_id').val(id);
            $('.hapus').modal('toggle');
        }
    </script>
@endpush
