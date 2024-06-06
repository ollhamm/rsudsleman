@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="font-weight: bold; background-color: #c2c2c2; color: white;">
                        Detail Reagensia <br />
                        Tanggal Kadaluarsa :{{ $reagensia->tanggal_kadaluarsa }}
                    </div>
                    <ul class="mt-2">
                        <pre>
    Nama Reagen                 : <strong>{{ $reagensia->nama_reagen_kit }}</strong>
    TANGGAL KADALUARSA          : <strong>{{ $reagensia->tanggal_kadaluarsa }}</strong>
    REAGEN YANG TELAH DIAPAKAI  : <strong>{{ $reagensia->reagen_yang_telah_dipakai }}</strong>
    KETERSEDIAAN                : <strong>{{ $reagensia->ketersediaan }}</strong>
                                </pre>
                    </ul>
                </div>
            </div>
        </div>
        <a id="btn-home" href="{{ route('admin.reagensia') }}" class="btn btn-primary mt-2">
            <i class="fa-solid fa-backward"></i> Back
        </a>
    </div>
@endsection
