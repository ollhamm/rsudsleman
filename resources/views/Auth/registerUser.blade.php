@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="row">
                        {{-- Konten Kiri --}}
                        <div class="col-md-6 d-none mt-5 d-md-block">
                            <img src="{{ asset('images/user_register.png') }}" alt="Register Image" class="img-fluid rounded-start">
                        </div>
                        {{-- Konten Kanan --}}
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <h2 class="text-primary" style="font-weight: bold; ">Register</h2>
                                <p class="text-muted">Create your account. It’s free and only takes a minute.</p>
                            </div>
                            <form method="POST" action="{{ route('user.register') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label text-muted">{{ __('Name') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-user text-muted"></i>
                                        </span>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="form-label text-muted">{{ __('E-Mail Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-envelope text-muted"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                               name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                               name="password" required autocomplete="new-password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password-confirm" class="form-label text-muted">{{ __('Confirm Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-lock text-muted"></i>
                                        </span>
                                        <input id="password-confirm" type="password" class="form-control" 
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class=" btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="text-muted">Already have an account? <a href="{{ route('user.login') }}" class="text-primary">Login</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
