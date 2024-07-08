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
                <div class="col-lg-6">
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
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="nik" class="form-label">Nik <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="number" class="form-control" id="nik" name="nik" placeholder="Masukkan nik" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="confirm_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                                            <div class="position-relative ">
                                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Masukkan Password" required>
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
