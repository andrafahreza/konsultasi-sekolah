<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - Mentor Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/assets2/img/favicon.png" rel="icon">
    <link href="/assets2/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets2/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="/assets2/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Mentor
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="/assets2/img/logo.png" alt=""> -->
                <h1 class="sitename">Mentor</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.html" class="active">Home<br></a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Login</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="/assets2/img/hero-bg.jpg" alt="" data-aos="fade-in">

            <div class="container">
                <h2 data-aos="fade-up" data-aos-delay="100">Konsultasi<br>Siswa</h2>
                <p data-aos="fade-up" data-aos-delay="200">Membantu segala permasalahan yang dihadapi semua siswa</p>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                        <img src="/assets2/img/about.jpg" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                        <h3>Dipantau orang tua</h3>
                        <p class="fst-italic">
                            Orang tua dapat memantau konsultasi yang dilakukan oleh siswa dan konselor.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> <span>Privasi terjaga</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Mendapatkan solusi atas permasalahan</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Berkonsultasi dengan konselor berpengalaman</span></li>
                        </ul>
                    </div>

                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Counts Section -->
        <section id="counts" class="section counts light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-6 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $siswa->count() }}" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Siswa</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-6 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $konselor->count() }}" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Konselor</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section>

    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container copyright text-center mt-4">
            <p>© <span>2024</span> </p>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="/assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets2/vendor/php-email-form/validate.js"></script>
    <script src="/assets2/vendor/aos/aos.js"></script>
    <script src="/assets2/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/assets2/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="/assets2/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="/assets2/js/main.js"></script>

</body>

</html>
