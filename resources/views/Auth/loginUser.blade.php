@extends('layouts.app')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="row g-0">
                    <!-- Left Content -->
                    <div class="col-md-6 d-none d-md-block">
                        <img src="{{ asset('images/login_user2.png') }}" alt="Login Image" class="img-fluid rounded-start h-100">
                        
                    </div>
                    <!-- Right Content -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-primary">User Login</h2>
                            </div>
                            <form method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label text-muted">{{ __('E-Mail Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-end-0">
                                            <i class="fa fa-envelope text-muted"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
        
                                <div class="mb-3">
                                    <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-end-0">
                                            <i class="fa fa-lock text-muted"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
        
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="text-primary" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
        
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
        
                                <hr class="my-4">
        
                                <div class="text-center">
                                    <p class="text-muted">Don't have an account? <a href="{{ route('user.register') }}" class="text-primary">Sign Up</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
