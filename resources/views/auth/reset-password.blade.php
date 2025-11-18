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
                    <p class="login-box-msg">Reset Password</p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $request->email) }}" required autocomplete="email" readonly>
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

                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" required autocomplete="new-password">
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

                        <!-- Confirm Password -->
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm New Password" required autocomplete="new-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <a href="#" id="togglePasswordConfirm" style="text-decoration: none; color: #6c757d;">
                                        <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                        <i class="fas fa-eye-slash d-none" id="eyeSlashIconConfirm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle for reset
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

            // Confirm password toggle for reset
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');
            const eyeSlashIconConfirm = document.getElementById('eyeSlashIconConfirm');

            togglePasswordConfirm.addEventListener('click', function(e) {
                e.preventDefault();

                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);

                eyeIconConfirm.classList.toggle('d-none');
                eyeSlashIconConfirm.classList.toggle('d-none');
            });
        });
    </script>

@stop
