@extends('layouts.app')

@section('title', 'Kunjungan Laboratorium')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="mt-4">
            <div class="header-container rounded text-center mb-4">
                <h1 class=" font-weight-bold text-primary">Manajemen Sampel</h1>
            </div>
            <button type="button" class="btn mb-3 btn-primary" data-bs-toggle="modal"
                data-bs-target="#createKunjunganModal">
                <i class="fa-solid_pasien fa-plus"></i> Create
            </button>
            <a href="{{ route('admin.home') }}" class="btn btn-primary mb-3">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <form action="{{ route('admin.kunjunganLabolaturium') }}" method="GET" class="mb-4 fade-in-left">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Cari berdasarkan nama">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <input type="date" name="tanggal_selesai" class="form-control">
                            <div class="input-group-append">
                                <a href="{{ route('admin.kunjunganLabolaturium') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm mr-2 d-none">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="fade-in table table-bordered table-hover rounded shadow table-rounded">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">Tanggal Pemeriksaan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($kunjunganLabolaturium as $kunjungan)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="alamat">{{ $kunjungan->pemeriksaan->patients->user->name }}</td>
                                <td>{{ $kunjungan->pemeriksaan->tanggal_pemeriksaan }}</td>
                                <td class="text-danger">{{ $kunjungan->tanggal_kunjungan }}</td>
                                <td class="text-success">{{ $kunjungan->tanggal_selesai }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn text-warning btn-sm mr-2"
                                        data-bs-toggle="modal" data-bs-target="#editKunjunganModal{{ $kunjungan->id }}"><i
                                            class="fa-solid fa-pen"></i></button>
                                    <form action="{{ route('admin.kunjunganLabolaturium.destroy', $kunjungan->id) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn text-danger btn-sm" type="submit"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.kunjunganLabolaturium.details', $kunjungan->id) }}"
                                        class="btn text-primary btn-sm ml-2"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="createKunjunganModal" tabindex="-1" aria-labelledby="createKunjunganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKunjunganModalLabel">Create Kunjungan LAB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.kunjunganLabolaturium.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="id_pemeriksaan" class="form-label">Pilih Pasien:</label>
                            <select class="form-select" id="id_pemeriksaan" name="id_pemeriksaan" required>
                                @foreach ($pemeriksaan as $key => $knj)
                                    <option value="{{ $knj->id_periksa }}">{{ $key + 1 }}.{{ $knj->patients->user->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih pasien wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kunjungan" class="form-label">Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan"
                                required>
                            <div class="invalid-feedback">
                                Tanggal mulai wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                required>
                            <div class="invalid-feedback">
                                Tanggal selesai wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="EDTA" class="form-label">EDTA:</label>
                            <select class="form-select" id="EDTA" name="EDTA" required>
                                <option value="YA">YA</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan EDTA wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Serum" class="form-label">Serum:</label>
                            <select class="form-select" id="Serum" name="Serum" required>
                                <option value="YA">YA</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan Serum wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Citrate" class="form-label">Citrate:</label>
                            <select class="form-select" id="Citrate" name="Citrate" required>
                                <option value="YA">YA</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan Citrate wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Urine" class="form-label">Urine:</label>
                            <select class="form-select" id="Urine" name="Urine" required>
                                <option value="YA">YA</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan Urine wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Lainya" class="form-label">Lainya:</label>
                            <select class="form-select" id="Lainya" name="Lainya" required>
                                <option value="YA">YA</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan Lainya wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="kondisi_sampel" class="form-label">Kondisi Sampel:</label>
                            <select class="form-select" id="kondisi_sampel" name="kondisi_sampel" required>
                                <option value="Normal">Normal</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tidak-Normal">Tidak-Normal</option>
                            </select>
                            <div class="invalid-feedback">
                                Pilihan kondisi sampel wajib diisi.
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-primary w-100">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    @foreach ($kunjunganLabolaturium as $kunjungan)
        <div class="modal fade" id="editKunjunganModal{{ $kunjungan->id }}" tabindex="-1"
            aria-labelledby="editKunjunganModalLabel{{ $kunjungan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKunjunganModalLabel{{ $kunjungan->id }}">Edit Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.kunjunganLabolaturium.update', $kunjungan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="id_pasien" class="form-label text-secondary">Nama Pasien:</label>
                                <span
                                    class="form-control-plaintext bg-light border rounded p-2">{{ $kunjungan->pemeriksaan->patients->user->name }}</span>
                            </div>
                            <input type="hidden" name="id_pemeriksaan" value="{{ $kunjungan->id_pemeriksaan }}">
                            <div class="mb-3">
                                <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan:</label>
                                <input type="date" class="form-control" id="tanggal_kunjungan"
                                    name="tanggal_kunjungan" value="{{ $kunjungan->tanggal_kunjungan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ $kunjungan->tanggal_selesai }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="EDTA" class="form-label">EDTA:</label>
                                <select class="form-select" id="EDTA" name="EDTA">
                                    <option value="YA" {{ $kunjungan->EDTA == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="Tidak" {{ $kunjungan->EDTA == 'Tidak' ? 'selected' : '' }}>Tidak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Serum" class="form-label">Serum:</label>
                                <select class="form-select" id="Serum" name="Serum">
                                    <option value="YA" {{ $kunjungan->Serum == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="Tidak" {{ $kunjungan->Serum == 'Tidak' ? 'selected' : '' }}>Tidak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Citrate" class="form-label">Citrate:</label>
                                <select class="form-select" id="Citrate" name="Citrate">
                                    <option value="YA" {{ $kunjungan->Citrate == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="Tidak" {{ $kunjungan->Citrate == 'Tidak' ? 'selected' : '' }}>Tidak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Urine" class="form-label">Urine:</label>
                                <select class="form-select" id="Urine" name="Urine">
                                    <option value="YA" {{ $kunjungan->Urine == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="Tidak" {{ $kunjungan->Urine == 'Tidak' ? 'selected' : '' }}>Tidak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Lainya" class="form-label">Lainya:</label>
                                <select class="form-select" id="Lainya" name="Lainya">
                                    <option value="YA" {{ $kunjungan->Lainya == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="Tidak" {{ $kunjungan->Lainya == 'Tidak' ? 'selected' : '' }}>Tidak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kondisi_sampel" class="form-label">Kondisi Sampel:</label>
                                <select class="form-select" id="kondisi_sampel" name="kondisi_sampel">
                                    <option value="Normal" {{ $kunjungan->kondisi_sampel == 'Normal' ? 'selected' : '' }}>
                                        Normal</option>
                                    <option value="Sedang" {{ $kunjungan->kondisi_sampel == 'Sedang' ? 'selected' : '' }}>
                                        Sedang</option>
                                    <option value="Tidak-Normal"
                                        {{ $kunjungan->kondisi_sampel == 'Tidak-Normal' ? 'selected' : '' }}>Tidak-Normal
                                    </option>
                                </select>
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
