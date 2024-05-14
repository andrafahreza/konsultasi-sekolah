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
                            <h5 class="card-title mb-0">Data Kepala Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('simpan-kepala-sekolah') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>NIP</label>
                                        <input class="form-control" type="text" name="nip" value="@if (!empty($data)) {{ $data->nip }} @endif" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Username</label>
                                        <input class="form-control" type="text" name="username" value="@if (!empty($data)) {{ $data->pengguna->username }} @endif" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Password </label>
                                        <input class="form-control" type="password" name="password">
                                        <span class="text-danger">Catatan: </span> Jangan diisi bila tidak ingin mengubah password
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label>Nama Lengkap</label>
                                        <input class="form-control" type="text" name="nama" value="@if (!empty($data)) {{ $data->nama }} @endif" required>
                                    </div>
                                    <div class="col-md-4 mt-4">
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
                                    <div class="col-md-4 mt-4">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="alamat" required value="{{ $alamat }}">
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" name="telepon" required value="{{ $telepon }}">
                                    </div>
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
