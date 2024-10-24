<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LifeSure - Life Insurance Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('front content/lib/animate/animate.min.css') }}" />
    <link href="{{ asset('front content/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front content/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('front content/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('front content/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid topbar px-0 px-lg-4 bg-light py-2 d-none d-lg-block">
        <div class="container">
            <div class="row gx-0 align-items-center">
                <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <div class="border-end border-primary pe-3">
                            <a href="#" class="text-muted small"><i
                                    class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        </div>
                        <div class="ps-3">
                            <a href="mailto:example@gmail.com" class="text-muted small"><i
                                    class="fas fa-envelope text-primary me-2"></i>example@gmail.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-flex justify-content-end">
                        <div class="d-flex border-end border-primary pe-3">
                            <a class="btn p-0 text-primary me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn p-0 text-primary me-3" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn p-0 text-primary me-3" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="btn p-0 text-primary me-0" href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <div class="dropdown ms-3">
                            <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown"><small><i
                                        class="fas fa-globe-europe text-primary me-2"></i> English</small></a>
                            <div class="dropdown-menu rounded">
                                <a href="#" class="dropdown-item">English</a>
                                <a href="#" class="dropdown-item">Bangla</a>
                                <a href="#" class="dropdown-item">French</a>
                                <a href="#" class="dropdown-item">Spanish</a>
                                <a href="#" class="dropdown-item">Arabic</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="#" class="navbar-brand p-0">
                    <h1 class="text-primary mb-0"><i class="fab fa-slack me-2"></i> LifeSure</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-0 mx-lg-auto">
                        <a href="{{ route('FrontHome') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ route('front.entreprise.index') }}" class="nav-item nav-link">mes entreprises</a>
                        <a href="{{ route('front.showPlans') }}" class="nav-item nav-link">mes abonnement</a>
                        <a href="{{ route('centres.front') }}" class="nav-item nav-link">Centres</a>
                        <a href="blog.html" class="nav-item nav-link">Blog</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                <span class="dropdown-toggle">Evenement</span>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('evenementFront.index') }}" class="dropdown-item">Liste des
                                    événements</a>
                                <a href="{{ route('evenementFront.myEvents') }}" class="dropdown-item">Mes
                                    Participations</a>
                            </div>
                        </div>

                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                        <li class="nav-item dropdown">
                            <a class="nav-icon" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">{{ count($expiringContracts ?? []) }}</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    {{ count($expiringContracts ?? []) }} New Notifications
                                </div>
                                @if (!empty($expiringContracts))


                                    <div class="list-group">
                                        @forelse($expiringContracts as $contract)
                                            <a href="/contracts/{{ $contract['contract_id'] }}"
                                                class="list-group-item">
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-2">
                                                        <i class="text-warning" data-feather="bell"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="text-dark">Contract expiring for
                                                            {{ $contract['entreprise'] }}</div>
                                                        <div class="text-muted small mt-1">Signed on:
                                                            {{ $contract['signature_date'] }}</div>
                                                        <div class="text-muted small mt-1">Expires on:
                                                            {{ $contract['expiration_date'] }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-muted">No expiring contracts.</div>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                        </li>
                        <!-- Logout form -->
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-item nav-link"
                                style="border: none; background: none; cursor: pointer;">
                                Logout
                            </button>
                        </form>
                        <div class="nav-btn px-3">
                            <button class="btn-search btn btn-primary btn-md-square rounded-circle flex-shrink-0"
                                data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                    class="fas fa-search"></i></button>
                            <a href="#" class="btn btn-primary rounded-pill py-2 px-4 ms-3 flex-shrink-0">Get a
                                Quote</a>

                            <!-- Displaying subscription status -->
                            <span class="subscription-status">
                                @if (!empty($statusData) && isset($statusData['status']))
                                    @switch($statusData['status'])
                                        @case('trial')
                                            <span class="text-warning">
                                                {{ $statusData['message'] ?? 'Your free trial ends in ' . $statusData['days_remaining'] . ' days' }}
                                            </span>
                                        @break

                                        @case('active')
                                            <span class="text-success">
                                                {{ $statusData['message'] ?? 'Active Plan: ' . ucfirst($statusData['plan']) . '. Your subscription ends in ' . $statusData['days_remaining'] . ' days.' }}
                                            </span>
                                        @break

                                        @case('pending')
                                            <span class="text-info">
                                                {{ $statusData['message'] ?? 'Your abonnement will be active in ' . $statusData['days_until_active'] . ' days.' }}
                                            </span>
                                        @break

                                        @case('expired')
                                            <span class="text-danger">
                                                {{ $statusData['message'] ?? 'Your subscription has expired.' }}
                                            </span>
                                        @break

                                        @default
                                            <span class="text-danger">Unknown subscription status.</span>
                                    @endswitch
                                @else
                                    <span class="text-danger">No Subscription Info Available</span>
                                @endif
                            </span>

                        </div>



                    </div>
                </div>
                <div class="d-none d-xl-flex flex-shrink-0 ps-4">
                    <a href="#" class="btn btn-light btn-lg-square rounded-circle position-relative wow tada"
                        data-wow-delay=".9s">
                        <i class="fa fa-phone-alt fa-2x"></i>
                        <div class="position-absolute" style="top: 7px; right: 12px;">
                            <span><i class="fa fa-comment-dots text-secondary"></i></span>
                        </div>
                    </a>
                    <div class="d-flex flex-column ms-3">
                        <span>Call to Our Experts</span>
                        <a href="tel:+ 0123 456 7890"><span class="text-dark">Free: + 0123 456 7890</span></a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center bg-primary">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="btn bg-light border nput-group-text p-3"><i
                                class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->



    <!-- Modal Search End -->
    @yield('content')
    @yield('entreprise_content')




    @include('FrontOffice.LayoutFront.footer')


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front content/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('front content/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('front content/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('front content/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('front content/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('front content/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('back content/js/app.js') }}"></script>


    <!-- Template Javascript -->
    <script src="{{ asset('front content/js/main.js') }}"></script>
</body>

</html>
