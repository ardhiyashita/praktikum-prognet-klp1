<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        <!-- Favicon
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        -->
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/projekStyle.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/shop/css/styles2.css') }}" rel="stylesheet" />
        <script src="jquery/jquery.js"></script>
        <script type="text/javascript" src='js/bootstrap.min.js'></script>
        <link rel="stylesheet" href="css/bootstrap.css" />
        @yield('css')

    
    </head>
    <body>
        <!-- Navigation-->
        <div class="wrapper ">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('landing-page-user') }}">Home</a></li>
                    <li class="nav-item dropdown">
                            <a class="fa fa-bell nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach (Auth::guard('web')->user()->unreadNotifications as $notification)
                                    <li><a class="dropdown-item" href="{{ url('userreadnotification') }}/{{ $notification->id }}" data-id="{{$notification->id}}">{{$notification->data['message']}}</a></li>
                                @endforeach
                                <!-- <li><a id="mark-all" class="dropdown-item" href="#">Mark all as read</a></li> -->
                            </ul>
                        </li>
                </div>
                        @if(!Auth::guard('web')->user()->email_verified_at)
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button class="nav-link btn btn-link">{{ __('Activate Email') }}</button>
                        </form>
                    </li>
                    @endif

                    </ul>

                        <button class="btn btn-outline-dark">
                            <i class="bi-cart-fill me-1"></i>                            
                                <a href="{{ route('keranjang') }}" style="text-decoration:none; color:black;">Cart</a>
                        </button>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-outline-dark" type="submit">Logout
                            </button>
                        </form>


                    <ul class="navbar-nav ml-5">                       

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link" href="{{ route('status-transaksi-page') }}"
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::guard('web')->user()->name}}</span>
                                <img style="width:50px"
                                    src=" {{ asset('assets/img2/undraw_profile.svg') }}">
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>
        @if (session('resent'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
        @endif

        @yield('content')

            <!-- Footer-->
                <footer class="py-5 bg-dark">
                    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Prognet Kelompok 1 Website 2021</p></div>
                </footer>
            <!-- Bootstrap core JS-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/cart.js') }}"></script>
        <script src="{{ asset('assets/shop/js/scripts.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('dropdown-toggle').dropdown()
            });
        </script>
        @include('sweetalert::alert')
        </div>
    </body>
</html>