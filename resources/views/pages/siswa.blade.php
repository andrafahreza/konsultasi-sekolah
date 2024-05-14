@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data Siswa</h5>
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
                                        <th>Nama</th>
                                        <th>Tempat, Tgl Lahir</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->siswa->nama_lengkap }}</td>
                                            <td>{{ $item->siswa->tempat_lahir }}, {{ date('d-m-Y', strtotime($item->siswa->tgl_lahir)) }}</td>
                                            <td>{{ $item->siswa->alamat }}</td>
                                            <td>{{ $item->siswa->telepon }}</td>
                                            <td>
                                                @if (auth()->user()->tipe == "admin")
                                                    <button type="button" class="btn btn-secondary" onclick="edit({{ $item->id }})" id="btnEdit">Edit</button>
                                                    <a href="{{ route('orang-tua', [$item->id]) }}" class="btn btn-warning"> List Orang Tua</a>
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

    <div class="modal fade modalSiswa" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('siswa-simpan') }}" method="POST" id="formSiswa">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Tambah Siswa</h5>
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
                                <label>Nik <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="nik" id="nik" required>
                            </div>
                            <div class="col-md-4">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                            </div>
                            <div class="col-md-4">
                                <label>Agama <span class="text-danger">*</span></label>
                                <select class="form-control" name="agama" id="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat" id="alamat" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Golongan Darah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="golongan_darah" id="golongan_darah" required>
                            </div>
                            <div class="col-md-4">
                                <label>Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon" id="telepon" required>
                            </div>
                            <div class="col-md-4">
                                <label>Sekolah Asal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Diterima sebagai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="diterima_sebagai" id="diterima_sebagai" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tahun diterima <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="tahun_terima" id="tahun_terima" required>
                            </div>
                            <div class="col-md-4">
                                <label>Hobi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hobi" id="hobi" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Nama Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_ayah" id="nama_ayah" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tempat Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tempat_lahir_ayah" id="tempat_lahir_ayah" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tgl_lahir_ayah" id="tgl_lahir_ayah" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Pekerjaan Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah" required>
                            </div>
                            <div class="col-md-4">
                                <label>Agama Ayah <span class="text-danger">*</span></label>
                                <select class="form-control" name="agama_ayah" id="agama_ayah" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Nama Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_ibu" id="nama_ibu" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Tempat Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tempat_lahir_ibu" id="tempat_lahir_ibu" required>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tgl_lahir_ibu" id="tgl_lahir_ibu" required>
                            </div>
                            <div class="col-md-4">
                                <label>Pekerjaan Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Agama Ibu <span class="text-danger">*</span></label>
                                <select class="form-control" name="agama_ibu" id="agama_ibu" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Alamat Orang Tua <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat_ortu" id="alamat_ortu" required>
                            </div>
                            <div class="col-md-4">
                                <label>Telepon Orang Tua <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon_ortu" id="telepon_ortu" required>
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
            $('#formSiswa')[0].reset();
            $('#errorMessage').addClass('d-none');
            $("#formSiswa :input").prop("disabled", false);
            $('.modalSiswa').modal('toggle');
        })

        function edit(id) {
            $('#formSiswa')[0].reset();
            var url = "{{ route('show-siswa') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('.modalSiswa').modal('toggle');
                        $('#errorMessage').addClass('d-none');
                        $("#formSiswa :input").prop("disabled", false);

                        const data = response.data;
                        $('#formSiswa')[0].reset();
                        $('#formSiswa').attr("action", "{{ route('siswa-simpan') }}" + "/" + data.id);
                        $('#nik').val(data.siswa.nik);
                        $('#nama_lengkap').val(data.siswa.nama_lengkap);
                        $('#tempat_lahir').val(data.siswa.tempat_lahir);
                        $('#tgl_lahir').val(data.siswa.tgl_lahir);
                        $('#agama').val(data.siswa.agama);
                        $('#alamat').val(data.siswa.alamat);
                        $('#golongan_darah').val(data.siswa.golongan_darah);
                        $('#telepon').val(data.siswa.telepon);
                        $('#sekolah_asal').val(data.siswa.sekolah_asal);
                        $('#diterima_sebagai').val(data.siswa.diterima_sebagai);
                        $('#tahun_terima').val(data.siswa.tahun_terima);
                        $('#hobi').val(data.siswa.hobi);
                        $('#nama_ayah').val(data.siswa.nama_ayah);
                        $('#tempat_lahir_ayah').val(data.siswa.tempat_lahir_ayah);
                        $('#tgl_lahir_ayah').val(data.siswa.tgl_lahir_ayah);
                        $('#pekerjaan_ayah').val(data.siswa.pekerjaan_ayah);
                        $('#agama_ayah').val(data.siswa.agama_ayah);
                        $('#nama_ibu').val(data.siswa.nama_ibu);
                        $('#tempat_lahir_ibu').val(data.siswa.tempat_lahir_ibu);
                        $('#tgl_lahir_ibu').val(data.siswa.tgl_lahir_ibu);
                        $('#pekerjaan_ibu').val(data.siswa.pekerjaan_ibu);
                        $('#agama_ibu').val(data.siswa.agama_ibu);
                        $('#alamat_ortu').val(data.siswa.alamat_ortu);
                        $('#telepon_ortu').val(data.siswa.telepon_ortu);
                    } else {
                        $("#formSiswa :input").prop("disabled", true);
                        $('#errorMessage').removeClass('d-none');
                        $('#spanError').text(response.message);
                    }
                },
                error: function(response) {
                    $("#formSiswa :input").prop("disabled", true);
                    $('#errorMessage').removeClass('d-none');
                    $('#spanError').text(response.message);
                }
            });
        }
    </script>
@endpush
