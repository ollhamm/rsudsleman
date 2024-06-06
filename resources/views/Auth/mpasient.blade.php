@extends('layouts.app')

@section('title', 'Manajemen')

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
        <div class="mt-5">
            <div class="header-container rounded text-center mb-4">
                <h1 class=" font-weight-bold text-primary">Manajemen Pasien</h1>
            </div>
            
            <button type="button" class="btn mb-3 btn-primary" data-bs-toggle="modal" data-bs-target="#createPatientModal">
                <i class="fa-solid_pasien fa-plus"></i> Create
            </button>
            <a href="{{ route('admin.home') }}" class="btn btn-primary mb-3">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <form action="{{ route('admin.mpasient') }}" method="GET" class="mb-4 fade-in-left">
                <!-- Form pencarian -->
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control mb-2"
                            placeholder="Search by name....click enter">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <input type="text" name="rm" class="form-control"
                                placeholder="Search by RM....click enter">
                            <div class="input-group-append">
                                <a href="{{ route('admin.mpasient') }}" class="btn btn-secondary">Reset</a>
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
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">RM</th>
                            <th scope="col">Rujukan</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="alamat">{{ $patient->user->name }}</td>
                                <td>{{ $patient->user->jenis_kelamin_user }}</td>
                                <td class="alamat">{{ $patient->user->address }}</td>
                                <td>{{ $patient->rm }}</td>
                                <td>{{ $patient->rujukan }}</td>
                                <td>
                                    @if ($patient->status == 'Aktif')
                                        <p style="color: green;">{{ $patient->status }}</p>
                                    @else
                                        <p style="color: red;">{{ $patient->status }}</p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn text-warning btn-sm mr-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPatientModal{{ $patient->id_pasien }}"><i
                                            class="fa-solid fa-pen"></i></button>
                                    <form action="{{ route('admin.mpasient.destroy', $patient->id_pasien) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn text-danger btn-sm" type="submit"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.patient.details.pemeriksaan', $patient->id_pasien) }}"
                                        class="btn text-primary btn-sm ml-2"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createPatientModal" tabindex="-1" aria-labelledby="createPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPatientModalLabel">Create New Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.mpasient.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" id="id_call" name="id_call"> <!-- Hidden input for id_call -->
    <!-- Input for id_pasien -->
    <input type="hidden" name="id_pasien" value="1">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama:</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="" disabled selected>Pilih Nama Pengguna</option>
                                @foreach ($users as $key => $user)
                                    <option value="{{ $user->id }}">{{ $key + 1 }}. {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="id_call" name="id_call"> <!-- Hidden input for id_call -->
                        <div class="form-group mb-3">
                            <label for="rm" class="form-label text-secondary">RM</label>
                            <span class="form-control-plaintext bg-light border rounded p-2">{{ $defaultRM }}</span>
                        </div>
                        <input type="hidden" name="rm" value="{{ $defaultRM }}">
                        <div class="mb-3">
                            <label for="rujukan" class="form-label">Rujukan:</label>
                            <select class="form-select" id="rujukan" name="rujukan" required>
                                <option value="" disabled selected>Pilih Rujukan</option>
                                <option value="UMUM">UMUM</option>
                                <option value="LAB">LABORATORIUM</option>
                                <option value="KIA">KIA</option>
                            </select>
                            <div class="invalid-feedback">Rujukan wajib dipilih.</div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_asuransi" class="form-label">Jenis Asuransi:</label>
                            <select class="form-select" id="jenis_asuransi" name="jenis_asuransi" required>
                                <option value="" disabled selected>Pilih Jenis Asuransi</option>
                                <option value="BPJS-KESEHATAN">BPJS KESEHATAN</option>
                                <option value="NON-BPJS">NON-BPJS</option>
                            </select>
                            <div class="invalid-feedback">Jenis Asuransi wajib dipilih.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_asuransi" class="form-label">Nomor Asuransi:</label>
                            <input type="text" class="form-control" id="nomor_asuransi" name="nomor_asuransi"
                                placeholder="Masukkan Nomor Asuransi (Opsional)">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback">Status wajib dipilih.</div>
                        </div>
                        <!-- Hidden input for callcenter_id -->
                        <button style="background-color: primary;" type="submit"
                            class="btn btn-primary w-100">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($patients as $patient)
        <!-- Edit Patient Modal for ID: {{ $patient->id_pasien }} -->
        <div class="modal fade" id="editPatientModal{{ $patient->id_pasien }}" tabindex="-1"
            aria-labelledby="editPatientModalLabel{{ $patient->id_pasien }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.mpasient.update', $patient->id_pasien) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label text-secondary">Nama Pasien:</label>
                                <span
                                    class="form-control-plaintext bg-light border rounded p-2">{{ $patient->user->name }}</span>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $patient->user_id }}">
                            <div class="mb-3">
                                <label for="rujukan" class="form-label">Rujukan:</label>
                                <select class="form-select" id="rujukan" name="rujukan" required>
                                    <option value="" disabled>Pilih Rujukan</option>
                                    <option value="UMUM" {{ $patient->rujukan == 'UMUM' ? 'selected' : '' }}>UMUM
                                    </option>
                                    <option value="LAB" {{ $patient->rujukan == 'LABORATORIUM' ? 'selected' : '' }}>
                                        LABORATORIUM</option>
                                    <option value="KIA" {{ $patient->rujukan == 'KIA' ? 'selected' : '' }}>KIA</option>
                                </select>
                                <div class="invalid-feedback">Rujukan wajib dipilih.</div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_asuransi" class="form-label">Jenis Asuransi:</label>
                                <select class="form-select" id="jenis_asuransi" name="jenis_asuransi" required>
                                    <option value="" disabled>Pilih Jenis Asuransi</option>
                                    <option value="BPJS-KESEHATAN"
                                        {{ $patient->jenis_asuransi == 'BPJS-KESEHATAN' ? 'selected' : '' }}>BPJS KESEHATAN
                                    </option>
                                    <option value="NON-BPJS"
                                        {{ $patient->jenis_asuransi == 'NON-BPJS' ? 'selected' : '' }}>NON-BPJS</option>
                                </select>
                                <div class="invalid-feedback">Jenis Asuransi wajib dipilih.</div>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_asuransi" class="form-label">Nomor Asuransi:</label>
                                <input type="text" class="form-control" id="nomor_asuransi" name="nomor_asuransi"
                                    value="{{ $patient->nomor_asuransi }}"
                                    placeholder="Masukkan Nomor Asuransi (Opsional)">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Aktif" {{ $patient->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak Aktif" {{ $patient->status == 'Tidak Aktif' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                                <div class="invalid-feedback">Status wajib dipilih.</div>
                            </div>
                            <!-- Hidden input for callcenter_id -->
                            <button type="submit"
                                class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tangkap perubahan pada elemen user_id
            document.getElementById('user_id').addEventListener('change', function () {
                // Dapatkan nilai id_pasien dari opsi yang dipilih
                var id_pasien = this.value;
                
                // Isi nilai id_call dengan nilai id_pasien
                document.getElementById('id_call').value = id_pasien;
            });
        });
    </script>
@endsection
