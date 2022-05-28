@extends('layouts.navigation')

@auth('admin')
@section('title', 'Admin | Profil')
@section('content')
<div class="text-center">
    @if(!empty($profil->profile_image))
    <img class="card-img-top" src="{{url('profile_image/'. $profil->profile_image)}}" style="height:200px; width: 200px;">
    @else
    <img class="card-img-top" src="{{url('image/profile.jpg')}}" style="height:200px; width: 200px;">
    @endif
</div>

<form action="{{route('admin.adm-profil-submit', $profil->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$profil->username}}" readonly>
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$profil->name}}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label>No Telepon</label>
        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$profil->phone}}">
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Foto Profil</label>
        <input class="form-control @error('profile_image') is-invalid @enderror" type="file" name="profile_image">
        @error('profile_image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Ubah</button>
        <a href="{{route('admin.adm-beranda')}}" type="button" class="btn btn-danger">Kembali</a>
    </div>

</form>
@endsection
@endauth

@auth('user')
@section('title', 'Sayur Box | Profil')
@section('content')
<div class="text-center">
    @if(!empty($profil->profile_image))
    <img class="card-img-top" src="{{url('profile_image/'. $profil->profile_image)}}" style="height:200px; width: 200px;">
    @else
    <img class="card-img-top" src="{{url('image/profile.jpg')}}" style="height:200px; width: 200px;">
    @endif
</div>

<form action="{{route('profil-submit', $profil->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$profil->email}}" readonly>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$profil->name}}">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Foto Profil</label>
        <input class="form-control @error('profile_image') is-invalid @enderror" type="file" name="profile_image">
        @error('profile_image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Ubah</button>
        <a href="{{route('user-beranda')}}" type="button" class="btn btn-danger">Kembali</a>
    </div>

</form>
@endsection
@endauth