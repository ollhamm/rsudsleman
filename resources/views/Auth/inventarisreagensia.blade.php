@extends('layouts.app')

@section('title', 'Reagensia')

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
                <h1 class=" font-weight-bold text-primary">Inventaris Reagensia</h1>
            </div>
            
            <button type="button" class="btn mb-3 btn-primary" data-bs-toggle="modal"
                data-bs-target="#createInventarisModal">
                <i class="fa-solid_pasien fa-plus"></i> Create
            </button>
            <a href="{{ route('admin.home') }}" class="btn btn-primary mb-3">
                <i class="fa-solid fa-house"></i> Home
            </a>
            <form action="{{ route('admin.reagensia') }}" method="GET" class="mb-4 fade-in-left">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="nama_reagen_kit" class="form-control mb-2"
                            placeholder="Search by nama reagen....click enter">
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="ketersediaan" class="form-control mb-2"
                            placeholder="Search by ketersediaan....click enter">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <input type="date" name="tanggal_kadaluarsa" class="form-control">
                            <div class="input-group-append">
                                <a href="{{ route('admin.reagensia') }}" class="btn btn-secondary">Reset</a>
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
                            <th scope="col">Nama Reagen Kit</th>
                            <th scope="col">Tanggal Kadaluarsa</th>
                            <th scope="col">Reagen yang Telah Dipakai</th>
                            <th scope="col">Ketersediaan</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($reagensias as $reagensia)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="alamat">
                                    @if ($reagensia->ketersediaan == 0)
                                        <i class="fa-solid fa-triangle-exclamation" style="color: red;"></i>
                                    @endif
                                    {{ $reagensia->nama_reagen_kit }}
                                </td>
                                <td>{{ $reagensia->tanggal_kadaluarsa }}</td>
                                <td>{{ $reagensia->reagen_yang_telah_dipakai }}</td>
                                <td>{{ $reagensia->ketersediaan }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn text-warning btn-sm mr-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ediReagentModal{{ $reagensia->id_reagen }}"><i
                                            class="fa-solid fa-pen"></i></button>
                                    <form action="{{ route('admin.reagensia.destroy', $reagensia->id_reagen) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn text-danger btn-sm" type="submit"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.reagensia.details', $reagensia->id_reagen) }}"
                                        class="btn text-primary btn-sm ml-2"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="createInventarisModal" tabindex="-1" aria-labelledby="createInventarisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInventarisModalLabel">Create New Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reagensia.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nama_reagen_kit" class="form-label">Nama Reagensia:</label>
                            <input type="text" class="form-control" id="nama_reagen_kit" name="nama_reagen_kit"
                                placeholder="Masukkan nama reagensia" required>
                            <div class="invalid-feedback">
                                Nama reagensia wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa:</label>
                            <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                                required>
                            <div class="invalid-feedback">
                                Tanggal kadaluarsa wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reagen_yang_telah_dipakai" class="form-label">Reagen Yang Telah Di Pakai:</label>
                            <input type="number" class="form-control" id="reagen_yang_telah_dipakai"
                                name="reagen_yang_telah_dipakai" placeholder="Masukkan jumlah reagen yang telah dipakai"
                                required>
                            <div class="invalid-feedback">
                                Jumlah reagen yang telah dipakai wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ketersediaan" class="form-label">Ketersediaan:</label>
                            <input type="number" class="form-control" id="ketersediaan" name="ketersediaan"
                                placeholder="Masukkan jumlah ketersediaan" required>
                            <div class="invalid-feedback">
                                Ketersediaan wajib diisi.
                            </div>
                        </div>
                        <button  type="submit"
                            class="btn btn-primary w-100">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
    @foreach ($reagensias as $reagensia)
        <!-- Edit Patient Modal for ID: {{ $reagensia->id_reagen }} -->
        <div class="modal fade" id="ediReagentModal{{ $reagensia->id_reagen }}" tabindex="-1"
            aria-labelledby="editReagenModalLabel{{ $reagensia->id_reagen }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReagenModalLabel">Edit Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.reagensia.update', $reagensia->id_reagen) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_reagen_kit" class="form-label">Nama Reagen Kit:</label>
                                <input type="text" class="form-control" id="nama_reagen_kit" name="nama_reagen_kit"
                                    value="{{ $reagensia->nama_reagen_kit }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa:</label>
                                <input type="date" class="form-control" id="tanggal_kadaluarsa"
                                    name="tanggal_kadaluarsa" value="{{ $reagensia->tanggal_kadaluarsa }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="reagen_yang_telah_dipakai" class="form-label">Reagen yang Telah
                                    Dipakai:</label>
                                <input type="text" class="form-control" id="reagen_yang_telah_dipakai"
                                    name="reagen_yang_telah_dipakai" value="{{ $reagensia->reagen_yang_telah_dipakai }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="ketersediaan" class="form-label">Ketersediaan:</label>
                                <input type="text" class="form-control" id="ketersediaan" name="ketersediaan"
                                    value="{{ $reagensia->ketersediaan }}" required>
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
