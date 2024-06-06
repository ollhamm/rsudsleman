@extends('layouts.app')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-md-6 d-none mt-5 d-md-block">
                            <img src="{{ asset('images/callcenterRegister.png') }}" alt="Login Call Center" class="img-fluid rounded-start">
                            <div class="text-center mt-4" style="font-weight: bold; color: #84cdde;">
                                “EXCELLENCE IN CUSTOMER SERVICE”
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <h2 style="color:  #84cdde" class="font-weight-bold">Register Call Center</h2>
                                <p class="text-muted">Create a new Call Center account.</p>
                            </div>
                            <form method="POST" action="{{ route('callcenter.register') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-block text-light custom-btn">
                                        Register
                                    </button>
                                </div>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="text-muted">Already have an account? <a href="{{ route('callcenter.login') }}" class="text-primary">Login</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
