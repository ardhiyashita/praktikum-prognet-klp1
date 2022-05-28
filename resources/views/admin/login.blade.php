<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login Admin</title>
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
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login Admin</h3></div>
                                    <div class="card-body">
                                        
                                        <form action="{{ route('admin.login_proses') }}" class="form-group mt-3" method="post">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md">
                                                    <div class="form-floating mb-3">
                                                    <input type="email"  class="form-control @error ('email') is-invalid @enderror"id="email" name="email" autofocus value="{{ old('email') }}">
                                                    <label for="inputFirstName">Email</label>
                                                    <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                                                    </div>
                                                
                                                    <div class="form-floating mb-3">
                                                        <input type="password"  class="form-control @error ('password') is-invalid @enderror"id="password" name="password" value="{{ old('password') }}">
                                                        <label for="inputFirstName">Password</label>
                                                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary btn-block" type="submit">Login</button></div>
                                            </div>
                                        </form>
                                        
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
                            <div class="text-muted">Copyright &copy; Prognet Kelompok 1 Website 2021</div>
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
