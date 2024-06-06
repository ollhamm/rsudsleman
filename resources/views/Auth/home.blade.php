<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Custom CSS for hover effect */
        .btn-custom-hover {
            background-color: transparent;
            color: #665b5b;
            border: none;
        }

        .btn-custom-hover:hover {
            background-color: #8bb9e0;
            color: #fff;
        }

        /* Efek tautan aktif */
        .btn-custom-hover.active {
            background-color: #8bb9e0;
            color: #fff;
        }

        .col-md-2 {
            height: 100vh;
            overflow-y: auto;
        }

        /* Animasi sidebar saat masuk ke halaman */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.5s ease-in-out;
            height: 100vh;
        }

        .sidebar.active {
            transform: translateX(0);
            /* Sidebar muncul dari sisi kiri */
        }

        .content {
            opacity: 0;
            /* Konten awalnya tidak terlihat */
            transition: opacity 0.5s ease-in-out;
            /* Efek transisi untuk opacity */
        }

        .content.active {
            opacity: 1;
            /* Konten muncul dengan opacity 1 */
        }

        .card-admin {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-admin:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(0);
            }
        }

/* CSS untuk konten di bawah navbar */
.container-fluid .row .col {
    padding-left: 0;
    padding-right: 0;
}
    </style>
</head>

<body style="background-color: #cfe2f3">    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 text-white p-4 sidebar" style="background-color:#acd1f1">
                <div class="sidebar-header text-center d-flex align-items-center p-4">
                    <img src="{{ asset('images/logo_home.png') }}" alt="Image" class="img-fluid rounded-circle me-3"
                        style="width: 40px;">
                    <h4 class="m-0 fw-bold"><span class="text-primary">RSUD</span> SLEMAN</h4>
                </div>
                <ul class="list-unstyled mt-2" id="menuList">
                    <!-- Menu-item 1: Dashboard -->
                    <li class="mt-2">
                        <a href="{{ route('admin.home') }}" class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover active" role="button" onclick="changeActive(event, this)">Dashboard</a>
                    </li> 
                    <!-- Menu-item 2: Manajemen Pasien -->
                    <li class="mt-2">
                        <a href="{{ route('admin.mpasient') }}"
                            class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover" role="button"
                            onclick="changeActive(event, this); return true;">Manajemen Pasien</a>
                    </li>
                    <!-- Menu-item 3: Pemeriksaan -->
                    <li class="mt-2">
                        <a href='{{ route('admin.pemeriksaan') }}'
                            class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover" role="button"
                            onclick="changeActive(event, this); return true;">Pemeriksaan</a>
                    </li>
                    <!-- Menu-item 4: Hasil Pemeriksaan -->
                    <li class="mt-2">
                        <a href='{{ route('admin.pemeriksaanHasil') }}' class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover"
                            role="button" onclick="changeActive(event, this); return true;">Hasil Pemeriksaan</a>
                    </li>
                    <!-- Menu-item 5: Kunjungan Lab -->
                    <li class="mt-2">
                        <a href='{{ route('admin.kunjunganLabolaturium') }}' class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover"
                            role="button" onclick="changeActive(event, this); return true;">Manajemen Sampel</a>
                    </li>
                    <!-- Menu-item 6: Inventaris Reagensia -->
                    <li class="mt-2">
                        <a href='{{ route('admin.reagensia') }}' class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover"
                            role="button" onclick="changeActive(event, this); return true;">Inventaris Reagensia</a>
                    </li>
                    <li class="mt-2">
                        <a href='{{ route('admin.instrumen') }}' class="btn btn-primary btn-block text-start py-2 w-100 btn-custom-hover"
                            role="button" onclick="changeActive(event, this); return true;">Kalibrasi Alat</a>
                    </li>
                    <!-- Informasi Pengguna -->
                    <li style="margin-top: 3rem" class=" text-primary text-start">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </li>
                    <!-- Form Logout -->
                    <form class="mt-3" action="{{ route('admin.logoutAdmin') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </ul>
            </div>

            <!-- Content -->
            <div class="col-md-9">
                <div class="content p-4">
                    <h4 class="text-primary">Dashboard</h4>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <div class="card py-4 border-0 shadow">
                                <div class="card-body">
                                    <img src="{{ asset('images/total_pemeriksaan.png') }}" alt="Image"
                                        class="img-fluid mx-auto d-block" style="width: 100px;">
                                    <h5 class="card-title mt-3">Total Pemeriksaan : <strong
                                            class="text-danger">{{ $totalPemeriksaanCount }}</strong></h5>
                                    <p class="card-text small">Jumlah total pemeriksaan yang telah dilakukan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 offset-md-2 mb-2">
                            <div class="card py-4 border-0 shadow card-admin">
                                <div class="card-body">
                                    <ul>
                                        <h5>Jumlah Pendapatan : <strong class="text-success">
                                            @php
                                                $formattedTotalPayment = number_format($totalPaymentSum, 2, '.', '.');
                                            @endphp
                        
                                            @if ($totalPaymentSum < 1000000)
                                                {{ $formattedTotalPayment }}
                                            @elseif ($totalPaymentSum < 10000000)
                                                {{ substr($formattedTotalPayment, 0, -6) . '.' . substr($formattedTotalPayment, -6, 3) . '.' . substr($formattedTotalPayment, -3) }}
                                            @elseif ($totalPaymentSum < 100000000)
                                                {{ substr($formattedTotalPayment, 0, -6) . '.' . substr($formattedTotalPayment, -6, 3) . '.' . substr($formattedTotalPayment, -3) }}
                                            @else
                                                {{ substr($formattedTotalPayment, 0, -9) . '.' . substr($formattedTotalPayment, -9, 3) . '.' . substr($formattedTotalPayment, -6, 3) . '.' . substr($formattedTotalPayment, -3) }}
                                            @endif
                                        </strong></h5>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        

                    </div>

                    <!-- Tiga card di bawahnya dalam satu baris -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3 border-0">
                                <div class="card-body">
                                    <img src="{{ asset('images/total_pasien.png') }}" alt="Image"
                                        class="img-fluid mx-auto d-block" style="width: 100px;">
                                    <h5 class="card-title mt-3">Total Pasien : <strong
                                            class="text-danger">{{ $totalPatientsCount }}</strong></h5>
                                    <p class="card-text small">Jumlah total pasien yang terdaftar.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 border-0">
                                <div class="card-body">
                                    <img src="{{ asset('images/total_reagen.png') }}" alt="Image"
                                        class="img-fluid mx-auto d-block" style="width: 100px;">
                                    <h5 class="card-title mt-3">Total Reagensia : <strong
                                            class="text-danger">{{ $totalReagensiaCount }}</strong></h5>
                                    <p class="card-text small">Jumlah total reagensia yang ada.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 border-0">
                                <div class="card-body">
                                    <img src="{{ asset('images/total_lab.png') }}" alt="Image"
                                        class="img-fluid mx-auto d-block" style="width: 100px;">
                                    <h5 class="card-title mt-3">Total Kunjungan LAB : <strong
                                            class="text-danger">{{ $totalKunjunganCount }}</strong></h5>
                                    <p class="card-text small">Jumlah total kunjungan ke laboratorium.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://kit.fontawesome.com/09b5482c09.js" crossorigin="anonymous"></script>
<script>
    function changeActive(event, element) {
        event.preventDefault(); // Menghentikan perilaku default dari tautan

        // Menghapus kelas 'active' dari tautan yang sedang aktif
        document.querySelector('.btn-custom-hover.active').classList.remove('active');
        // Menambah kelas 'active' pada tautan yang diklik
        element.classList.add('active');

        // Lakukan navigasi ke halaman yang ditentukan dalam href
        window.location.href = element.getAttribute('href');
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.add('active');
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const content = document.querySelector('.content');
        content.classList.add('active');
    });
</script>



</html>
