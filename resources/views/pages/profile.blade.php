@extends('layouts.app')

@section('content')
    <div class="row learning-dash-row">
        <div class="col-xxl">
            <div class="row">
                <div class="col-lg-12">
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
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">Ganti Photo Profil</div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('ganti-photo') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>Upload Photo</label>
                                        <input type="file" class="form-control" name="photo" required>
                                        <button type="submit" class="btn btn-primary mt-4">Ganti Photo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">Ganti Password</div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('ganti-password') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Password Lama</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>Password baru</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>Konfirmasi Password baru</label>
                                        <input type="password" class="form-control" name="konfirmasi_password" required>
                                        <button type="submit" class="btn btn-primary mt-4">Ubah Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('simpan-profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    @if (auth()->user()->tipe == "siswa" || auth()->user()->tipe == "konselor")
                                        <div class="col-md-4">
                                            <label>NIP / NIS</label>
                                            <input class="form-control" type="text" disabled value="{{ auth()->user()->tipe == 'siswa' ? auth()->user()->siswa->nik : auth()->user()->konselor->nip }}">
                                        </div>
                                    @endif
                                    <div class="col-md-4">
                                        <label>Nama</label>
                                        <input class="form-control" type="text" name="nama" value="{{ $nama }}">
                                    </div>
                                    @if (auth()->user()->tipe != "admin")
                                        <div class="col-md-4">
                                            <label>Agama</label>
                                            <select class="form-control" name="agama" required>
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam" @if ($agama == "Islam") selected @endif>Islam</option>
                                                <option value="Kristen" @if ($agama == "Kristen") selected @endif>Kristen</option>
                                                <option value="Hindu" @if ($agama == "Hindu") selected @endif>Hindu</option>
                                                <option value="Buddha" @if ($agama == "Buddha") selected @endif>Buddha</option>
                                                <option value="Konghucu" @if ($agama == "Konghucu") selected @endif>Konghucu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 @if (auth()->user()->tipe == "siswa" || auth()->user()->tipe == "konselor") mt-4 @endif">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" name="alamat" required value="{{ $alamat }}">
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <label>Telepon</label>
                                            <input type="text" class="form-control" name="telepon" required value="{{ $telepon }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="mt-4 btn btn-primary" type="submit">Ubah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--end col-->
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
