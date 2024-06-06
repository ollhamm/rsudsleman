@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                        Detail Pemeriksaan <br />
                        {{ $pemeriksaan->rincian_pemeriksaan }}
                    </div>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <pre class="small-text">
Nama Pasien : <strong>{{ $pemeriksaan->patients->user->name }}</strong>
Tanggal     : <strong>{{ $pemeriksaan->tanggal_pemeriksaan }}</strong>
Tanggal     : <strong>{{ $pemeriksaan->amnesis_dokter }}</strong>
Unit        : <strong>{{ $pemeriksaan->unit_pemeriksaan }}</strong>
Rujukan     : <strong>{{ $pemeriksaan->rujukan_pemeriksaan }}</strong>
@php
    $formattedPayment = number_format($pemeriksaan->payment, 2, '.', '.');
@endphp

Total Tagihan      : Rp.<strong class="text-success">@if ($pemeriksaan->payment < 1000000)
    {{ $formattedPayment }}
@elseif ($pemeriksaan->payment < 10000000)
    {{ substr($formattedPayment, 0, -6) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@elseif ($pemeriksaan->payment < 100000000)
    {{ substr($formattedPayment, 0, -6) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@else
    {{ substr($formattedPayment, 0, -9) . '.' . substr($formattedPayment, -9, 3) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@endif</strong>
Status      : <strong style="color: {{ $pemeriksaan->payment_status == 'lunas' ? 'green' : 'red' }}">{{ $pemeriksaan->payment_status }}</strong>
Rincian     : <strong>{{ $pemeriksaan->rincian_pemeriksaan }}</strong>
                                </pre>
                            </div>
                            <div class="col-md-4">
                                <pre class="small-text">
WBC  : <strong>{{ $pemeriksaan->WBC ?: '-' }}</strong>
RBC  : <strong>{{ $pemeriksaan->RBC ?: '-' }}</strong>
PLT  : <strong>{{ $pemeriksaan->PLT ?: '-' }}</strong>
HGB  : <strong>{{ $pemeriksaan->HGB ?: '-' }}</strong>
HTM  : <strong>{{ $pemeriksaan->HTM ?: '-' }}</strong>
Neu  : <strong>{{ $pemeriksaan->Neu ?: '-' }}</strong>
                                </pre>
                            </div>
                            <div class="col-md-4">
                                <pre class="small-text">
Eos  : <strong>{{ $pemeriksaan->Eos ?: '-' }}</strong>
Bas  : <strong>{{ $pemeriksaan->Bas ?: '-' }}</strong>
Lym  : <strong>{{ $pemeriksaan->Lym ?: '-' }}</strong>
Mon  : <strong>{{ $pemeriksaan->Mon ?: '-' }}</strong>
MCV  : <strong>{{ $pemeriksaan->MCV ?: '-' }}</strong>
MCH  : <strong>{{ $pemeriksaan->MCH ?: '-' }}</strong>
MCHC : <strong>{{ $pemeriksaan->MCHC ?: '-' }}</strong>
                                </pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a id="btn-home" href="{{ route('admin.pemeriksaanHasil') }}" class="btn btn-primary mt-2">
            <i class="fa-solid fa-backward"></i> Back
        </a>
    </div>
@endsection
