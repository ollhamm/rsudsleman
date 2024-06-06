@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                        Detail Manajemen sampel <br />
                    </div>
                    <ul class="mt-2">
                        <pre>
    Nama Pasien      : <strong>{{ $kunjungan->pemeriksaan->patients->nama }}</strong>
    Tanggal Mulai    : <strong>{{ $kunjungan->tanggal_kunjungan }}</strong>
    Tanggal Selesai  : <strong>{{ $kunjungan->tanggal_selesai }}</strong>
    EDTA             : <strong>{{ $kunjungan->EDTA }}</strong>
    Serum            : <strong>{{ $kunjungan->Serum }}</strong>
    Citrate          : <strong>{{ $kunjungan->Citrate }}</strong>
    Urine            : <strong>{{ $kunjungan->Urine }}</strong>
    Lainya           : <strong>{{ $kunjungan->Lainya }}</strong>
    kondisi_sampel   : <strong>{{ $kunjungan->kondisi_sampel }}</strong>
                                </pre>
                    </ul>
                </div>
            </div>
        </div>
        <a id="btn-home" href="{{ route('admin.kunjunganLabolaturium') }}" class="btn btn-primary mt-2">
            <i class="fa-solid fa-backward"></i> Back
        </a>
    </div>
@endsection
