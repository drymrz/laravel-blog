@extends('frontview.layouts.main')

@section('container')
<div class="container">
    <div class="row vh-100 pt-5 align-content-center justify-content-center">
        <div class="col-lg-4">
            <main class="form-registration">
                <p class="h4 mb-3 text-center" style="font-weight: 600">Registration</p>
                <form action="/register" method="post">
                    @csrf
                    <hr class="mb-4">
                    <div class="form-floating mb-4">
                        <input type="text" name="name"
                            class="form-control rounded-top @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" value="{{ old('name') }}" required>
                        <label for="name">Name</label>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            id="username" placeholder="Username" value="{{ old('username') }}" required>
                        <label for="username">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        <label for="email">Email address</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" name="password"
                            class="form-control rounded-bottom @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" value="{{ old('password') }}" required>
                        <label for="password">Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mt-3"
                        style="height: 53px; font-size: 14px; font-weight:600" type="submit">Register</button>
                </form>
                <small class="d-block text-center mt-3">Sudah mendaftar? <a href="/login">Login</a></small>
                <p class="mt-5 mb-3 text-muted text-center"> <small>&copy; Adry Mirza - 2022</small></p>
            </main>
        </div>
    </div>
</div>
@endsection