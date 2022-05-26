@extends('landing-layout')

@section('title', 'Admin | Login')

@section('content')
<div class="section section-signup" style="background-position: top center; min-height: 700px;">
    <div class="container">
        <div class="row">
            <div class="card card-signup" data-background-color="orange">
                <form class="form" method="post" action="{{route('admin.adm-login-auth')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header text-center">
                        <h3 class="card-title title-up">Sign In</h3>
                    </div>
                    <div class="card-body">
                        <div class="input-group no-border">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons-sharp">
                                        manage_accounts
                                    </i>
                                </span>
                            </div>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{old('username')}}" required spellcheck="false">
                        </div>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="input-group no-border">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons-sharp">
                                        lock
                                    </i>
                                </span>
                            </div>
                            <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required spellcheck="false" />
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="pull-right mr-1">
                            <h6>
                                <a href="{{route('admin.adm-register')}}" class="link">Register</a>
                            </h6>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-neutral btn-round btn-lg">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col text-center mt-4">
            <a href="{{route('landing')}}" class="btn btn-outline-default btn-round btn-white btn-lg">Kembali Ke Landing Page</a>
        </div>
    </div>
</div>
@endsection