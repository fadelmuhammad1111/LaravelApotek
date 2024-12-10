@extends('layout.template')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="max-width: 450px; width: 100%; border-radius: 15px; background-color: #f8f9fa;">
            <form action="{{ route('login.auth') }}" method="POST">
                @csrf
                @if (Session::get('failed'))
                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                @endif
                @if (Session::get('logout'))
                    <div class="alert alert-primary">{{ Session::get('logout') }}</div>
                @endif
                @if (Session::get('canAccess'))
                    <div class="alert alert-danger">{{ Session::get('canAccess') }}</div>
                @endif

                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="font-size: 1.6rem; color: #2c3e50;">Login to Your Account</h3>
                    <p style="font-size: 1rem; color: #7f8c8d;">Enter your credentials to continue</p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label" style="font-size: 1.1rem; color: #2c3e50;">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter your email" required style="font-size: 1.1rem; padding: 12px; border-radius: 8px; background-color: #ecf0f1;">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label" style="font-size: 1.1rem; color: #2c3e50;">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter your password" required style="font-size: 1.1rem; padding: 12px; border-radius: 8px; background-color: #ecf0f1;">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer; background-color: #ecf0f1; border: 1px solid #ccc; border-radius: 8px;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-success btn-lg w-100" style="font-size: 1.2rem; padding: 12px; border-radius: 8px; transition: all 0.3s ease; background-color: #27ae60; border: none; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
    
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>
@endsection
