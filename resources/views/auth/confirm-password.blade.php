@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('body')

    <div class="login-page min-vh-100 d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('vendor/adminlte/dist/img/default-background.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="login-box">
            <div class="card card-outline card-primary shadow">
                <div class="card-header text-center">
                    <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="h4">
                        <b>Cargo</b>Track
                    </a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Enter your password to continue</p>

                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
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
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Confirm Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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

                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                eyeIcon.classList.toggle('d-none');
                eyeSlashIcon.classList.toggle('d-none');
            });
        });
    </script>

@stop
