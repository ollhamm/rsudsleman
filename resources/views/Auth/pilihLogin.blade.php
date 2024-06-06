@extends('layouts.app')

@section('title', 'Login Selection')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-4 text-center">
                    <h3 class="card-title mb-3">RUMAH SAKIT</h3>
                    <p class="card-text mb-4">Choose your login type:</p>
                    <div class="list-group">
                        <a href="{{ route('user.login') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between rounded-pill mb-2">
                            <span class="fw-bold">User Login</span>
                            <i class="fas fa-user text-primary"></i>
                        </a>
                        <a href="{{ route('admin.login') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between rounded-pill mb-2">
                            <span class="fw-bold">Nakes Login</span>
                            <i class="fas fa-user-shield text-success"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
