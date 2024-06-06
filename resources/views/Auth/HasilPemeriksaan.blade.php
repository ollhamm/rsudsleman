@extends('layouts.app')

@section('title', 'Pemeriksaan')

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
                <h1 class=" font-weight-bold text-primary">Hasil Pemeriksaan</h1>
            </div>
            <button type="button" class="btn mb-3 btn-primary" data-bs-toggle="modal"
                data-bs-target="#createPemeriksaanModal">
                <i class="fa-solid_pasien fa-plus"></i> Create
            </button>
            <a href="{{ route('admin.home') }}" class="btn btn-primary mb-3">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <form action="{{ route('admin.pemeriksaanHasil') }}" method="GET" class="mb-4 fade-in-left">
                <!-- Form pencarian -->
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control mb-2"
                            placeholder="Search by name pasien....click enter">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <input type="date" name="tanggal_pemeriksaan" class="form-control"
                                placeholder="Search by date....click enter">
                            <div class="input-group-append">
                                <a href="{{ route('admin.pemeriksaanHasil') }}" class="btn btn-secondary">Reset</a>
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
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Rujukan</th>
                            <th scope="col">Jenis Pembayaran</th>
                            <th scope="col" class="text-center">Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($pemeriksaans as $periksa)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $periksa->patients->user->name }}</td>
                                <td>{{ $periksa->tanggal_pemeriksaan }}</td>
                                <td>{{ $periksa->unit_pemeriksaan }}</td>
                                <td>{{ $periksa->rujukan_pemeriksaan }}</td>
                                <td>{{ $periksa->jenis_pembayaran }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.pemeriksaan.details', $periksa->id_periksa) }}"
                                        class="btn text-primary btn-sm ml-2"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- modal
    <div class="modal fade" id="createPemeriksaanModal" tabindex="-1" aria-labelledby="createPemeriksaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPemeriksaanModalLabel">Create New Pemeriksaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pemeriksaan.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="id_pasien" class="form-label">Pilih Pasien:</label>
                            <select class="form-select" id="id_pasien" name="id_pasien" required>
                                @foreach ($pemeriksaan as $key => $periksa)
                                    <option value="{{ $periksa->id_pasien }}">{{ $key + 1 }}.{{ $periksa->user->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih pasien wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pemeriksaan" class="form-label">Tanggal:</label>
                            <input type="date" class="form-control" id="tanggal_pemeriksaan"
                                name="tanggal_pemeriksaan" required>
                            <div class="invalid-feedback">
                                Tanggal wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amnesis_dokter" class="form-label">Amnesis Dokter:</label>
                            <input type="text" class="form-control" id="amnesis_dokter" name="amnesis_dokter"
                                placeholder="Masukkan rincian" required>
                            <div class="invalid-feedback">
                                Rincian wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="unit_pemeriksaan" class="form-label">Unit:</label>
                            <select class="form-select" id="unit_pemeriksaan" name="unit_pemeriksaan" required>
                                <option value="" disabled selected>Pilih Unit</option>
                                <option value="UNIT-PATOLOGI-KLINIK">UNIT PATOLOGI KLINIK</option>
                                <option value="UNIT-MIKROBIOLOGI-KLINIK">UNIT MIKROBIOLOGI KLINIK</option>
                            </select>
                            <div class="invalid-feedback">
                                Unit wajib dipilih.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="verifikator" class="form-label">Verifikator:</label>
                            <input type="text" class="form-control" id="verifikator" name="verifikator"
                                placeholder="Masukkan rincian" required>
                            <div class="invalid-feedback">
                                Verifikator wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="rujukan_pemeriksaan" class="form-label">Rujukan:</label>
                            <select class="form-select" id="rujukan_pemeriksaan" name="rujukan_pemeriksaan" required>
                                <option value="" disabled selected>Pilih Rujukan</option>
                                <option value="Poli-penyakit-dalam">POLI PENYAKIT DALAM</option>
                                <option value="POLI-SARAF">POLI-SARAF</option>
                                <option value="POLI-KANDUNGAN">POLI-KANDUNGAN</option>
                                <option value="POLI-BEDAH UMUM">POLI-BEDAH UMUM</option>
                                <option value="POLI-UROLOGI">POLI-UROLOGI</option>
                                <option value="POLI-MATA">POLI-MATA</option>
                                <option value="POLI-THT">POLI-THT</option>
                                <option value="POLI-KULIT & KELAMIN">POLI-KULIT & KELAMIN</option>
                                <option value="POLI-REHABILITASI MEDIK">POLI-REHABILITASI MEDIK</option>
                                <option value="POLI-JANTUNG & PEMBULUH DARAH">POLI-JANTUNG & PEMBULUH DARAH</option>
                                <option value="POLI-ANAK">POLI-ANAK</option>
                                <option value="POLI-KONSERVASI GIGI">POLI-KONSERVASI GIGI</option>
                            </select>
                            <div class="invalid-feedback">
                                Rujukan wajib dipilih.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran:</label>
                            <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                <option value="BPJS">BPJS</option>
                                <option value="NON-BPJS">NON-BPJS</option>
                            </select>
                            <div class="invalid-feedback">
                                Jenis Pembayaran wajib dipilih.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="payment" class="form-label">Payment:</label>
                            <select class="form-select" id="payment" name="payment" required>
                                <option value="" disabled selected>Pilih Payment</option>
                                <option value="100000.00">100.000,00</option>
                                <option value="200000.00">200.000,00</option>
                                <option value="300000.00">300.000,00</option>
                                <option value="400000.00">400.000,00</option>
                                <option value="500000.00">500.000,00</option>
                            </select>
                            <div class="invalid-feedback">
                                Payment wajib dipilih.
                            </div>
                        </div>
                        <!-- Additional Fields for WBC, RBC, etc. -->
                        @foreach (['WBC', 'RBC', 'PLT', 'HGB', 'HTM', 'Neu', 'Eos', 'Bas', 'Lym', 'Mon', 'MCV', 'MCH', 'MCHC'] as $field)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ $field }}:</label>
                                <input type="number" step="0.01" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" placeholder="Masukkan nilai {{ $field }}">
                                <div class="invalid-feedback">
                                    {{ $field }} wajib diisi.
                                </div>
                            </div>
                        @endforeach

                        <button type="submit"
                            class="btn btn-primary w-100">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- modal edit --}}
    {{-- @foreach ($pemeriksaans as $periksa)
    <div class="modal fade" id="editPemeriksaanModal{{ $periksa->id_periksa }}" tabindex="-1"
        aria-labelledby="editPemeriksaanModalLabel{{ $periksa->id_periksa }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPemeriksaanModalLabel{{ $periksa->id_periksa }}">Edit Pemeriksaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pemeriksaan.update', $periksa->id_periksa) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="id_pasien" class="form-label text-secondary">Nama Pasien:</label>
                            <span class="form-control-plaintext bg-light border rounded p-2">{{ $periksa->patients->user->name }}</span>
                        </div>
                        <input type="hidden" name="id_pasien" value="{{ $periksa->id_pasien }}">

                        <div class="mb-3">
                            <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan:</label>
                            <input type="date" class="form-control" id="tanggal_pemeriksaan"
                                name="tanggal_pemeriksaan" value="{{ $periksa->tanggal_pemeriksaan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="unit_pemeriksaan" class="form-label">Unit Pemeriksaan:</label>
                            <select class="form-select" id="unit_pemeriksaan" name="unit_pemeriksaan" required>
                                <option value="UNIT-PATOLOGI-KLINIK"
                                    {{ $periksa->unit_pemeriksaan === 'UNIT-PATOLOGI-KLINIK' ? 'selected' : '' }}>
                                    UNIT PATOLOGI KLINIK</option>
                                <option value="UNIT-MIKROBIOLOGI-KLINIK"
                                    {{ $periksa->unit_pemeriksaan === 'UNIT-MIKROBIOLOGI-KLINIK' ? 'selected' : '' }}>
                                    UNIT MIKROBIOLOGI KLINIK</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="verifikator" class="form-label">Verifikator:</label>
                            <input type="text" class="form-control" id="verifikator" name="verifikator"
                                value="{{ $periksa->verifikator }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="rujukan_pemeriksaan" class="form-label">Rujukan Pemeriksaan Dari:</label>
                            <select class="form-select" id="rujukan_pemeriksaan" name="rujukan_pemeriksaan" required>
                                <option value="Rujukan_1"
                                    {{ $periksa->rujukan_pemeriksaan === 'Rujukan_1' ? 'selected' : '' }}>Rujukan 1
                                </option>
                                <option value="Rujukan_2"
                                    {{ $periksa->rujukan_pemeriksaan === 'Rujukan_2' ? 'selected' : '' }}>Rujukan 2
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran:</label>
                            <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="BPJS" {{ $periksa->jenis_pembayaran === 'BPJS' ? 'selected' : '' }}>
                                    BPJS</option>
                                <option value="NON-BPJS"
                                    {{ $periksa->jenis_pembayaran === 'NON-BPJS' ? 'selected' : '' }}>NON-BPJS</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment" class="form-label">Payment:</label>
                            <select class="form-select" id="payment" name="payment" required>
                                <option value="100000.00" {{ $periksa->payment == 100000.00 ? 'selected' : '' }}>100.000,00</option>
                                <option value="200000.00" {{ $periksa->payment == 200000.00 ? 'selected' : '' }}>200.000,00</option>
                                <option value="300000.00" {{ $periksa->payment == 300000.00 ? 'selected' : '' }}>300.000,00</option>
                                <option value="400000.00" {{ $periksa->payment == 400000.00 ? 'selected' : '' }}>400.000,00</option>
                                <option value="500000.00" {{ $periksa->payment == 500000.00 ? 'selected' : '' }}>500.000,00</option>
                            </select>
                        </div>
                        @foreach (['WBC', 'RBC', 'PLT', 'HGB', 'HTM', 'Neu', 'Eos', 'Bas', 'Lym', 'Mon', 'MCV', 'MCH', 'MCHC'] as $field)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ $field }}:</label>
                                <input type="number" step="0.01" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" value="{{ $periksa->$field }}">
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach --}}

@endsection
