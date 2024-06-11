<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-theme="default" data-topbar="light" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <section
        class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="row g-0 align-items-center">

                            <!--end col-->
                            <div class="col-xxl-12 mx-auto">
                                <div class="card mb-0 border-0 shadow-none mb-0">
                                    <div class="card-body p-sm-5 m-lg-4">
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong>  {{ $errors->first() }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <div class="text-center mt-5">
                                            <h5 class="fs-3xl">Daftar Akun</h5>
                                            <p class="text-muted">Silahkan isi data diri anda untuk mendaftar</p>
                                        </div>
                                        <div class="p-2 mt-5">
                                            <form action="{{ route('proses-daftar') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nik" class="form-label">Nik <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="number" class="form-control" id="nik" name="nik" placeholder="Masukkan nik" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama lengkap" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukkan tanggal lahir" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <select class="form-control" name="agama" id="agama" required>
                                                                    <option value="">Pilih Agama</option>
                                                                    <option value="Islam">Islam</option>
                                                                    <option value="Kristen">Kristen</option>
                                                                    <option value="Hindu">Hindu</option>
                                                                    <option value="Buddha">Buddha</option>
                                                                    <option value="Konghucu">Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="golongan_darah" class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="golongan_darah" name="golongan_darah" placeholder="Masukkan golongan darah" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan telepon" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="sekolah_asal" class="form-label">Sekolah Asal <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" placeholder="Masukkan sekolah asal" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tahun_terima" class="form-label">Tahun Diterima <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="number" class="form-control" id="tahun_terima" name="tahun_terima" placeholder="Masukkan tahun diterima" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="hobi" class="form-label">Hobi <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="hobi" name="hobi" placeholder="Masukkan hobi" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nama_ayah" class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukkan nama ayah" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah" placeholder="Masukkan tempat lahir ayah" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tgl_lahir_ayah" class="form-label">Tanggal Lahir Ayah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="date" class="form-control" id="tgl_lahir_ayah" name="tgl_lahir_ayah" placeholder="Masukkan tanggal lahir ayah" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Masukkan pekerjaan ayah" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="agama_ayah" class="form-label">Agama Ayah <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <select class="form-control" name="agama_ayah" id="agama_ayah" required>
                                                                    <option value="">Pilih Agama</option>
                                                                    <option value="Islam">Islam</option>
                                                                    <option value="Kristen">Kristen</option>
                                                                    <option value="Hindu">Hindu</option>
                                                                    <option value="Buddha">Buddha</option>
                                                                    <option value="Konghucu">Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nama_ibu" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukkan nama ibu" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu" placeholder="Masukkan tempat lahir ibu" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="tgl_lahir_ibu" class="form-label">Tanggal Lahir Ibu <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="date" class="form-control" id="tgl_lahir_ibu" name="tgl_lahir_ibu" placeholder="Masukkan tanggal lahir ibu" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Masukkan pekerjaan ibu" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="agama_ibu" class="form-label">Agama Ibu <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <select class="form-control" name="agama_ibu" id="agama_ibu" required>
                                                                    <option value="">Pilih Agama</option>
                                                                    <option value="Islam">Islam</option>
                                                                    <option value="Kristen">Kristen</option>
                                                                    <option value="Hindu">Hindu</option>
                                                                    <option value="Buddha">Buddha</option>
                                                                    <option value="Konghucu">Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="alamat_ortu" class="form-label">Alamat Orang Tua <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="alamat_ortu" name="alamat_ortu" placeholder="Masukkan alamat orang tua" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="telepon_ortu" class="form-label">Telepon orang Tua <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="telepon_ortu" name="telepon_ortu" placeholder="Masukkan telepon orang tua" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <center>
                                                        <button class="btn btn-primary" type="submit">Daftar</button>
                                                    </center>
                                                </div>

                                                <div class="text-center mt-5">
                                                    <p class="mb-o">
                                                        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">Login</a>
                                                    </p>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/js/plugins.js"></script>



    <script src="/assets/js/pages/password-addon.init.js"></script>

    <!--Swiper slider js-->
    <script src="/assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- swiper.init js -->
    <script src="/assets/js/pages/swiper.init.js"></script>

</body>



</html>
