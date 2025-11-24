<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rent USDT</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="../auth/app/dist/app.css" />
    <link rel="stylesheet" href="../auth/app/dist/magnific-popup.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- End Style CSS -->

    <link rel="shortcut icon" href="assets/images/logo/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="assets/images/logo/logo.png" />
    <link rel="stylesheet" href="../auth/assets/style.css">
</head>

<body class="body header-fixed home-2">
    <!-- Header -->

    <!-- PageTitle -->
    <!-- End PageTitle -->
    <hr>
    <section class="register login">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-text center">
                        <h3 class="heading">Admin RENT'USDT</h3>
                        <p class="desc fs-20">
                            Welcome back! Log In now to start trading
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="flat-tabs">
                        <div class="content-tab">
                            <div class="content-inner">
                                <!-- Session Status -->
                                @if ($errors->any())
                                <div>
                                    <ul>
                                        @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form method="POST" action="{{ route('admin.login.submit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email/ID</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Please fill in the email form." />
                                    </div>
                                    <div class="form-group s1">
                                        <label>Password </label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Please enter a password." />
                                    </div>

                                    <div class="form-group form-check">
                                        {{-- <div>
                                            <input type="checkbox" name="remember" class="form-check-input" />
                                            <label class="form-check-label">Remember Me</label>
                                        </div> --}}
                                        {{-- @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                        @endif --}}
                                    </div>

                                    <button type="submit" class="btn-action">Login</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <script src="../auth/app/js/aos.js"></script>
    <script src="../auth/app/js/jquery.min.js"></script>
    <script src="../auth/app/js/jquery.easing.js"></script>
    <script src="../auth/app/js/popper.min.js"></script>
    <script src="../auth/app/js/bootstrap.min.js"></script>
    <script src="../auth/app/js/app.js"></script>
    <script src="../auth/app/js/jquery.peity.min.js"></script>
    <script src="../auth/app/js/Chart.bundle.min.js"></script>
    <script src="../auth/app/js/apexcharts.js"></script>
    <script src="../auth/app/js/switchmode.js"></script>
    <script src="../auth/app/js/jquery.magnific-popup.min.js"></script>

    <script src="../auth/app/js/chart.js"></script>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,

            thumbs: {
                swiper: swiper,
            },
        });

        var swiper3 = new Swiper(".swiper-partner", {
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 60,
                },
            },
            slidesPerView: 4,
        });
    </script>