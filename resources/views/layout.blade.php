<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{url('assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    {{-- CSS Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- CSS Files -->
    <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{url('assets/css/now-ui-kit.css?v=1.2.0')}}" rel="stylesheet" />
    <title>@yield('title')</title>
</head>

<body class="landing-page sidebar-collapse">


    <nav class="navbar navbar-expand-lg bg-primary fixed-top">
        <div class="container">
            <div class="navbar-translate">

                @auth('user')
                <a class="navbar-brand" href="{{route('user-beranda')}}" rel="tooltip" data-placement="bottom">
                    Toko Buku
                </a>
                @endauth

                @auth('admin')
                <a class="navbar-brand" href="{{route('admin.adm-beranda')}}" rel="tooltip" data-placement="bottom">
                    Toko Buku
                </a>
                @endauth

                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar top-bar"></span>
                    <span class="navbar-toggler-bar middle-bar"></span>
                    <span class="navbar-toggler-bar bottom-bar"></span>
                </button>
            </div>
            @auth('admin')
            <form class="form-inline ml-auto" action="/adm/beranda" method="get" data-background-color>
                <div class="form-group has-white">
                    <input type="search" class="form-control" placeholder="Cari" name="keyword" id="keyword" style="width:800px;">
                </div>
            </form>
            @endauth

            @auth('user')
            <form class="form-inline ml-auto" action="/user/beranda" method="get" data-background-color>
                <div class="form-group has-white">
                    <input type="search" class="form-control" placeholder="Cari" name="keyword" id="keyword" style="width:800px;">
                </div>
            </form>
            @endauth

            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <!-- <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </li>
                </ul> -->
                <div class="dropdown button-dropdown ">
                    <a class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                        <!-- <span class="material-icons mb-0">
                            account_circle
                        </span> -->
                        @auth('admin')
                        @if(!empty(Auth::guard('admin')->user()->profile_image))
                        <img src="{{url('profile_image/'.Auth::guard('admin')->user()->profile_image)}}" style="height:26px; width:26px; border-radius: 50%;" class="ml-2">
                        @else
                        <img src="{{url('image/profile.jpg')}}" style="height:26px; width:26px; border-radius: 50%;">
                        @endif
                        {{Auth::guard('admin')->user()->name}}
                        @endauth

                        @auth('user')
                        @if(!empty(Auth::guard('user')->user()->profile_image))
                        <img src="{{url('profile_image/'.Auth::guard('user')->user()->profile_image)}}" style="height:26px; width:26px; border-radius: 50%;" class="mr-2">
                        @else
                        <img src="{{url('image/profile.jpg')}}" style="height:26px; width:26px; border-radius: 50%;" class="mr-2">
                        @endif
                        {{Auth::guard('user')->user()->name}}
                        @endauth
                    </a>
                   

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @auth('user')
                        {{-- <a class="dropdown-item" href="#"><span class="material-icons-sharp mr-2" style="color: #8F9193;">notifications</span>Notifikasi</a> --}}
                        <a class="dropdown-item" href="{{route('keranjang')}}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">shopping_cart</span>Keranjang</a>
                        <a class="dropdown-item" href="{{route('transaksi')}}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">shopping_bag</span>Transaksi</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('profil') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">settings</span>Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('logout')}}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">logout</span>Logout</a>
                        @endauth

                        @auth('admin')
                        <a class="dropdown-item" href="{{ route('adm-beranda') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">shop</span>Beranda</a>
                        {{-- <a class="dropdown-item" href="#"><span class="material-icons-sharp mr-2" style="color: #8F9193;">notifications</span>Notifikasi</a> --}}
                        <a class="dropdown-item" href="{{ route('adm-grafik') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">analytics</span>graphic</a>
                        <a class="dropdown-item" href="{{route('admin.adm-transaksi')}}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">shopping_bag</span>Transaksi</a>
                        
                        <a class="dropdown-item" href="{{ route('adm-profil') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">settings</span>Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('adm-img-book-category-detail') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">new_label</span>Kategori Detail Buku</a>
                        <a class="dropdown-item" href="{{ route('adm-img-book') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">new_label</span>Gambar Buku</a>
                        <a class="dropdown-item" href="{{ route('adm-book-category') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">new_label</span>Kategori Buku</a>
                        <a class="dropdown-item" href="{{ route('adm-buku') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">book</span>Buku</a>
                        <a class="dropdown-item" href="{{ route('adm-courier') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">local_shipping</span>Kurir</a>
                        <a class="dropdown-item" href="{{ route('adm-diskon') }}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">sell</span>Diskon</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('admin.adm-logout')}}"><span class="material-icons-sharp mr-2" style="color: #8F9193;">logout</span>Logout</a>
                        @endauth
                    </div>
                 
                
                </div>
                @auth('admin')
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle icon-menu" data-toggle="dropdown" style="text-decoration: none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                                </svg>
                                @php $admin_unRead = App\Models\admin_notification::where('notifiable_id',3)->where('read_at', NULL)->orderBy('created_at','desc')->count(); @endphp
                                <span class="badge bg-danger">@php echo $admin_unRead @endphp</span>
                            </a>
            
                            <ul class="dropdown-menu notifications">
                                @php $admin_notifikasi = App\Models\admin_notification::where('notifiable_id',3)->where('read_at', NULL)->orderBy('created_at','desc')->get(); @endphp
                                @forelse ($admin_notifikasi as $notifikasi)
                                @php $notif = json_decode($notifikasi->data); @endphp
                                <li>
                                    <a href="{{ route('admin.notification', $notifikasi->id) }}" class="dropdown-item btnunNotif" data-num=""><small> <img src="{{url('image/profile.jpg')}}" style="height:15px; width:15px; border-radius: 50%;" class="mr-1">[{{ $notif->nama }}] {{ $notif->message }}</small></a>
                                </li>
                                @empty
                                    <li>
                                    <a href="#" class="dropdown-item btnunNotif" data-num="" >
                                        &nbsp;<small>Tidak ada notifikasi</small>
                                    </a>
                                    </li>
                                @endforelse
                            </ul>
                        </ul>
                    </div>
                @endauth
                @auth('user')
   
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-left mr-3">
                        <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle icon-menu" data-toggle="dropdown" style="text-decoration: none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                              <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                            </svg>
                            @php $user_unRead = App\Models\user_notification::where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->orderBy('created_at','desc')->count(); @endphp
                            <span class="badge bg-danger">@php echo $user_unRead @endphp</span>
                        </a>
    
                        <ul class="dropdown-menu notifications">
                            @php $user_notifikasi = App\Models\user_notification::where('notifiable_id', Auth::user()->id)->where('read_at', NULL)->orderBy('created_at','desc')->get(); @endphp
                            @forelse ($user_notifikasi as $notifikasi)
                              @php $notif = json_decode($notifikasi->data); @endphp
                              <li>
                                <a href="{{ route('user.notification', $notifikasi->id) }}" class="dropdown-item btnunNotif" data-num=""><small> <img src="{{url('image/profile.jpg')}}" style="height:15px; width:15px; border-radius: 50%;" class="mr-1">[{{ $notif->nama }}] {{ $notif->message }}</small></a>
                              </li>
                            @empty
                                <li>
                                  <a href="#" class="dropdown-item btnunNotif" data-num="" >
                                    &nbsp;<small>Tidak ada notifikasi</small>
                                  </a>
                                </li>
                            @endforelse
                        </ul>
                    </ul>
                </div>
            @endauth
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top:100px; min-height:779px;">
        @yield('body')
    </div>

    <footer class="footer footer-default">

        <div class=" container ">
            <nav>
                <ul>
                    <li>
                        <a>
                            Kelompok 20
                        </a>
                    </li>
                    <li>
                        <a>
                            Tentang Kami
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright" id="copyright">
                &copy;
                <script>
                    document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                </script>, Designed by
                <a>Kelompok 20</a>. Coded by
                <a>Kelompok 20</a>.
            </div>
        </div>
    </footer>

    <!--   Core JS Files   -->
    <script src="{{url('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>

    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{url('assets/js/plugins/bootstrap-switch.js')}}"></script>

    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{url('assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>

    <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="{{url('assets/js/plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>

    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>


    <!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
    <script src="{{url('assets/js/now-ui-kit.js?v=1.2.0')}}" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>