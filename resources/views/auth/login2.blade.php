<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login User</title>
        <!-- Script CSS-->
            <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/>
            <link href="{{ asset('assets/css/projekStyle.css') }}" rel="stylesheet"/>
        <!-- End Script CSS-->
    </head>
    <body class="bg-image">
        <!-- <img src="../img/top-view-vegetables-fruits-bag.jpg" style="width: 100%; height:100%" alt=""> -->
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login User</h3></div>
                                    <div class="card-body">
                                        <form action="{{ route('login_proses') }}" method="POST">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" 
                                                            placeholder="Enter your first name" required value="{{ old('email') }}">
                                                        <label for="inputFirstName">Email</label>
                                                        @error('email')
                                                            <div class="invalid-feedback mb-2">
                                                            {{$message}}
                                                        @enderror
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" 
                                                            placeholder="Create a password" required value="{{ old('password') }}">
                                                        <label for="inputPassword">Password</label>
                                                        @error('password')
                                                            <div class="invalid-feedback mb-2">
                                                            {{$message}}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary btn-block" type="submit">Login</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                    <div class="col-6 card-footer text-center py-3">
                                        <div class="small"><a href="{{ route('register') }}">Belum memiliki akun? Silahkan Sign Up</a></div>
                                    </div>
                                    <div class="col-6 card-footer py-3">
                                        <div class="small"><a href="{{ route('password.request') }}" style="float:right;margin-right:16px;">Forgot Password</a></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</html>
