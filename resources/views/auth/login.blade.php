@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('body')

    <div class="login-page min-vh-100 d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('vendor/adminlte/dist/img/default-background.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary shadow">
                <div class="card-header text-center">
                    <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="h4">
                        <b>Cargo</b>Track
                    </a>
                </div>

                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <!-- Session Status -->
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <a href="#" id="togglePassword" style="text-decoration: none; color: #6c757d;">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                        <i class="fas fa-eye-slash d-none" id="eyeSlashIcon"></i>
                                    </a>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-1 mt-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">I forgot my password</a>
                        @endif
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();

                // Toggle password visibility
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icons
                eyeIcon.classList.toggle('d-none');
                eyeSlashIcon.classList.toggle('d-none');
            });
        });
    </script>

@stop
