@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4 rounded" style="background-color: #f0f0f0; padding: 20px;">
            
            <div class="rounded">
                <div class="card-header text-start px-3 mb-2 rounded"
                    style="font-weight: bold; background-color: #c2c2c2; color: white;">
                    Detail Pemeriksaan <br />
                </div>

            </div>
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header text-center"
                        style="font-weight: bold; background-color:#c2c2c2; color: white;">
                        Identitas Pasien <br />
                        {{ $patient->rm }}
                    </div>
                    <div id="barcode" class="card-body" data-rm="{{ $patient->rm }}">
                        <pre>
Nama                 : <strong>{{ $patient->user->name }}</strong>
Jenis Kelamin        : <strong>{{ $patient->user->jenis_kelamin_user }}</strong>
Tempat Tanggal Lahir : <strong>{{ $patient->user->birthdate }}</strong>
Alamat               : <strong class="alamat">{{ $patient->user->address }}</strong>
Jenis Asuransi       : <strong>{{ $patient->jenis_asuransi }}</strong>
Nomor Asuransi       : <strong>{{ $patient->nomor_asuransi ?: '-' }}</strong>
RM (Rekam Medis)     : <strong>{{ $patient->rm }}</strong>
Rujukan              : <strong>{{ $patient->rujukan }}</strong>
Status               : <strong style="color: {{ $patient->status == 'Aktif' ? 'green' : 'red' }}">{{ $patient->status }}</strong>
                        </pre>
                        <div class="text-right mt-4">
                            <a id="btn-print-barcode" class="btn btn-secondary">
                                <i class="fa-solid fa-print"></i> Barcode
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card border-0">
                            <div class="card-header" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                                Tanggal Kunjungan LAB :
                            </div>
                            <div class="card-body mt-4">
                                <pre>
<strong class="text-danger">Kunjungan :</strong> {{ $pemeriksaanData['tanggalKunjunganLab'] }}<br>
<strong class="vertical-line ">---></strong>
<strong class="text-success">Selesai   :</strong> {{ $pemeriksaanData['tanggalSelesaiLab'] }}
                                </pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card border-0">
                            <div class="card-header" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                                <strong class="text-light">Selesai :</strong> {{ $pemeriksaanData['tanggalSelesaiLab'] }}
                            </div>
                            <div class="card-body">
                                <div class="text-bold bg-light text-center rounded">
                                    Jenis Sampel
                                </div>
                                <table class="table table-bordered mt-2">
                                    <thead class="small">
                                        <tr>
                                            <th>EDTA</th>
                                            <th>Serum</th>
                                            <th>Citrate</th>
                                            <th>Urine</th>
                                            <th>Lainya</th>
                                            <th>Kondisi Sampel</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <tr>
                                            <td class="text-center">
                                                <div class="{!! $pemeriksaanData['edtaValue'] == 'YA'
                                                    ? 'bg-success text-white rounded-circle p-3'
                                                    : 'bg-danger text-white rounded-circle p-3' !!}">
                                                    {!! $pemeriksaanData['edtaValue'] == 'YA' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="{!! $pemeriksaanData['serumValue'] == 'YA'
                                                    ? 'bg-success text-white rounded-circle p-3'
                                                    : 'bg-danger text-white rounded-circle p-3' !!}">
                                                    {!! $pemeriksaanData['serumValue'] == 'YA' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="{!! $pemeriksaanData['citrateValue'] == 'YA'
                                                    ? 'bg-success text-white rounded-circle p-3'
                                                    : 'bg-danger text-white rounded-circle p-3' !!}">
                                                    {!! $pemeriksaanData['citrateValue'] == 'YA' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="{!! $pemeriksaanData['urineValue'] == 'YA'
                                                    ? 'bg-success text-white rounded-circle p-3'
                                                    : 'bg-danger text-white rounded-circle p-3' !!}">
                                                    {!! $pemeriksaanData['urineValue'] == 'YA' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' !!}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="{!! $pemeriksaanData['lainyaValue'] == 'YA'
                                                    ? 'bg-success text-white rounded-circle p-3'
                                                    : 'bg-danger text-white rounded-circle p-3' !!}">
                                                    {!! $pemeriksaanData['lainyaValue'] == 'YA' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' !!}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $pemeriksaanData['kondisi_sampel'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-header" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                        Amnesis Dokter :
                    </div>
                    <div class="card-body">
                        @if ($pemeriksaan && is_object($pemeriksaan))
                            <pre>
<strong>{{ $pemeriksaan->amnesis_dokter }}</strong>
                            </pre>
                        @else
                            <p>Pasien belum melakukan pemeriksaan!</p>
                        @endif
                    </div>
                </div>
                <div class="card border-0 mt-2" style="height: 84%">
                    <div class="card-header" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                        Tindakan Pelayanan Laboratorium :
                    </div>
                    <div class="card-body">
                        @if ($pemeriksaan && is_object($pemeriksaan))
                            <pre>
Tanggal          : <strong>{{ $pemeriksaan->tanggal_pemeriksaan }}</strong>
Unit             : <strong>{{ $pemeriksaan->unit_pemeriksaan }}</strong>
Verifikator      : <strong>{{ $pemeriksaan->verifikator }}</strong>
Rujukan Dari     : <strong>{{ $pemeriksaan->rujukan_pemeriksaan }}</strong>
Jenis Pembayaran : <strong>{{ $pemeriksaan->jenis_pembayaran }}</strong><br/>
Rincian Tindakan :

<table class="table">
    <thead>
        <tr>
            <th colspan="10" class="bg-light p-2">Pemeriksaan Hematologi Lengkap</th>
        </tr>
    </thead>
    <tbody>
        <tr class="p-5">
            <td class="p-2 small">WBC :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->WBC ?: '-' }}</strong></td>
            <td class="p-2 small">RBC :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->RBC ?: '-' }}</strong></td>
            <td class="p-2 small">PLT :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->PLT ?: '-' }}</strong></td>
            <td class="p-2 small">HGB :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->HGB ?: '-' }}</strong></td>
            <td class="p-2 small">HTM :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->HTM ?: '-' }}</strong></td>
        </tr>
        <tr>
            <td class="p-2 small">Neu :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->Neu ?: '-' }}</strong></td>
            <td class="p-2 small">Eos :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->Eos ?: '-' }}</strong></td>
            <td class="p-2 small">Bas :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->Bas ?: '-' }}</strong></td>
            <td class="p-2 small">Lym :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->Lym ?: '-' }}</strong></td>
            <td class="p-2 small">Mon :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->Mon ?: '-' }}</strong></td>
        </tr>
        <tr>
            <td class="p-2 small">MCV :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->MCV ?: '-' }}</strong></td>
            <td class="p-2 small">MCH :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->MCH ?: '-' }}</strong></td>
            <td class="p-2 small">MCHC :</td>
            <td class="p-2 small"><strong>{{ $pemeriksaan->MCHC ?: '-' }}</strong></td>
            <td colspan="5" class="p-2 small"></td>
        </tr>
    </tbody>
</table>
@php
    $formattedPayment = number_format($pemeriksaan->payment, 2, '.', '.');
@endphp

Jumlah Tagihan      : Rp.<strong class="text-success">@if ($pemeriksaan->payment < 1000000)
    {{ $formattedPayment }}
@elseif ($pemeriksaan->payment < 10000000)
    {{ substr($formattedPayment, 0, -6) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@elseif ($pemeriksaan->payment < 100000000)
    {{ substr($formattedPayment, 0, -6) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@else
    {{ substr($formattedPayment, 0, -9) . '.' . substr($formattedPayment, -9, 3) . '.' . substr($formattedPayment, -6, 3) . '.' . substr($formattedPayment, -3) }}
@endif</strong>
                            </pre>
                        @else
                            <p>Pasien belum melakukan pemeriksaan!</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row justify-content-end mt-5 ml-3">
                <div class="col-md-auto ml-auto">
                    <a id="btn-home" href="{{ route('admin.mpasient') }}" class="btn btn-primary">
                        <i class="fa-solid fa-backward"></i> Back
                    </a>
                    <a id="btn-print-detail" class="btn btn-secondary">
                        <i class="fa-solid fa-print"></i> Print Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
