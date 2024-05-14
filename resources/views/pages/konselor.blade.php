@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data Konselor</h5>
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
                                        <th>Username</th>
                                        <th>Nip</th>
                                        <th>Nama</th>
                                        <th>Agama</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->konselor->nip }}</td>
                                            <td>{{ $item->konselor->nama_konselor }}</td>
                                            <td>{{ $item->konselor->agama_konselor }}</td>
                                            <td>{{ $item->konselor->alamat_konselor }}</td>
                                            <td>{{ $item->konselor->telepon_konselor }}</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
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

    <div class="modal fade modalKonselor" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('konselor-simpan') }}" method="POST" id="formKonselor">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Tambah Konselor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errorMessage d-none">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>  <span id="spanError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nip <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="nip" id="nip" required>
                            </div>
                            <div class="col-md-4">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_konselor" id="nama_konselor" required>
                            </div>
                            <div class="col-md-4">
                                <label>Agama <span class="text-danger">*</span></label>
                                <select class="form-control" name="agama_konselor" id="agama_konselor" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat_konselor" id="alamat_konselor" required>
                            </div>
                            <div class="col-md-4">
                                <label>Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon_konselor" id="telepon_konselor" required>
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

    <script>
        $('#btnTambah').on('click', function() {
            $('#formKonselor')[0].reset();
            $('#errorMessage').addClass('d-none');
            $("#formKonselor :input").prop("disabled", false);
            $('.modalKonselor').modal('toggle');
        })

        function edit(id) {
            $('#formKonselor')[0].reset();
            var url = "{{ route('show-konselor') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('.modalKonselor').modal('toggle');
                        $('#errorMessage').addClass('d-none');
                        $("#formKonselor :input").prop("disabled", false);

                        const data = response.data;
                        $('#formKonselor')[0].reset();
                        $('#formKonselor').attr("action", "{{ route('konselor-simpan') }}" + "/" + data.id);
                        $('#nip').val(data.konselor.nip);
                        $('#nama_konselor').val(data.konselor.nama_konselor);
                        $('#agama_konselor').val(data.konselor.agama_konselor);
                        $('#alamat_konselor').val(data.konselor.alamat_konselor);
                        $('#telepon_konselor').val(data.konselor.telepon_konselor);
                    } else {
                        $("#formKonselor :input").prop("disabled", true);
                        $('#errorMessage').removeClass('d-none');
                        $('#spanError').text(response.message);
                    }
                },
                error: function(response) {
                    $("#formKonselor :input").prop("disabled", true);
                    $('#errorMessage').removeClass('d-none');
                    $('#spanError').text(response.message);
                }
            });
        }
    </script>
@endpush
