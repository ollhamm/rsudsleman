@extends('layouts.app')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="row">
                        {{-- Konten Kiri --}}
                        <div class="col-md-6 d-none mt-5 d-md-block">
                            <img src="{{ asset('images/callcenterLogin.png') }}" alt="Login Call Center" class="img-fluid rounded-start">
                            <div class="text-center mt-4" style="font-weight: bold; color: #84cdde;">
                                “EXCELLENCE IN CUSTOMER SERVICE”
                            </div>
                        </div>
                        {{-- Konten Kanan --}}
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <h2 class="font-weight-bold" style="font-weight: bold; color: #84cdde;">Login Call Center</h2>
                                <p class="text-muted">Welcome to our call center platform. Please log in to continue.</p>
                            </div>
                            <form method="POST" action="{{ route('callcenter.login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label text-muted">{{ __('E-Mail Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0 ">
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

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
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

                                <div class="form-group d-flex justify-content-between align-items-center mb-4">
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
                                    <button type="submit" class="btn btn-block text-light custom-btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="text-muted">Don't have an account? <a href="{{ route('callcenter.register') }}" class="text-primary">Sign Up</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
