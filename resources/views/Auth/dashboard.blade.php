<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100%;
            background-color: #333;
            padding: 20px;
            position: fixed;
            background-color: #a9c9e6;
            top: 0;
            left: 0;
            transition: left 0.3s ease;
            overflow-y: auto;
        }
        @media print {
            .sidebar {
                display: none;
            }
        }
        @media print {
            .profile-p {
                display: none;
            }
        }
        @media print {
            .amnesis-p {
                display: none;
            }
        }
        @media print {
            .toggle-sidebar {
                display: none;
            }
        }

        .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        body {
            background-color: #f0f8ff;
        }

        .toggle-sidebar {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
            background-color: #a0a0a0;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .profile-picture {
        width: 50px;
        height: 50px;
        object-fit: cover; 
        border-radius: 50%; 
    }
    </style>
</head>

<body>
    <button class="toggle-sidebar ml-4" onclick="toggleSidebar()">
        <i class="fas fa-chevron-left"></i>
    </button>

    <div id="sidebar" class="sidebar shadow">
        <div class="profile mt-5">
            <div class="card-body text-center">
                <img src="{{ asset('/storage/app/public/profile_pictures/' . Auth::user()->profile_picture) }}" class="profile-picture" alt="Profile Picture">
                <p class="card-text">{{ $user->email }}</p>
                <button type="button" class="btn btn-info text-light" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">Complete Profile</button>
            </div>
        </div>
    </div>

    <div class="main-content">
        {{-- profile --}}
        <div class=" profile-p card shadow-sm mb-4">
            <div class="card-body">
                <pre>
Name                      : <strong>{{ $user->name }}</strong>
Birthplace and Date       : <strong>{{ $user->tempat_lahir }}</strong>
Gender                    : <strong>{{ $user->jenis_kelamin_user }}</strong>
Residence                 : <strong>{{ $user->address }}</strong>
                </pre>
                <div class="d-flex justify-content-end mt-3">
                    <form action="{{ route('user.logoutUser') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
        <div class=" amnesis-p card shadow-sm mb-4">
            <div class="card-body">
                <div class="small">
                    <strong>Current Medical History:</strong>
                    @if (isset($pemeriksaan) && is_object($pemeriksaan))
                        <p>{{ $pemeriksaan->amnesis_dokter ?? '' }}</p>
                    @else
                        <p>You have not had a check-up yet!</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- detail pemeriksaan --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mt-4 rounded" style="background-color: #f0f0f0; padding: 20px;">
                    <div class="rounded">
                        <div class="card-header text-start text-light px-3 mb-2 rounded"
                            style="font-weight: bold; background-color: #a9c9e6;">
                            Detail Pemeriksaan <br />
                        </div>
        
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 small">
                            <div class="card-header border-0 font-weight-bold small"
                                style=" background-color: #a9c9e6; color: white;">
                                Identitas Pasien <br />
                                {{ isset($patient) ? $patient->rm : '' }}
                            </div>
                            <div id="barcode" class="card-body" data-rm="{{ isset($patient) ? $patient->rm : '' }}">
                                <pre class="small-banget">
        Nama                 : <strong>{{ isset($patient->user) ? $patient->user->name : '' }}</strong>
        Jenis Kelamin        : <strong>{{ isset($patient->user) ? $patient->user->jenis_kelamin_user : '' }}</strong>
        Tempat Tanggal Lahir : <strong>{{ isset($patient->user) ? $patient->user->tempat_lahir : '' }}</strong>
        Alamat               : <strong>{{ isset($patient->user) ? $patient->user->address : '' }}</strong>
        Jenis Asuransi       : <strong>{{ isset($patient) ? $patient->jenis_asuransi : '' }}</strong>
        Nomor Asuransi       : <strong>{{ isset($patient) ? ($patient->nomor_asuransi ?: '-') : '' }}</strong>
        RM (Rekam Medis)     : <strong>{{ isset($patient) ? $patient->rm : '' }}</strong>
        Status               : <strong style="color: {{ isset($patient) && $patient->status == 'Aktif' ? 'green' : 'red' }}">{{ isset($patient) ? $patient->status : '' }}</strong>
                                                            </pre>
                                <div class="text-right mt-4">
                                    <a id="btn-print-barcode" class="b-small btn btn-secondary btn-sm">
                                        <i class="fa-solid fa-barcode"></i> Barcode
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card border-0">
                                    <div class="card-header border-0 font-weight-bold small"
                                        style="background-color: #a9c9e6; color: white;">
                                        Tanggal Kunjungan LAB :
                                    </div>
                                    <div class="card-body">
                                        @if (!empty($pemeriksaanData['tanggalKunjunganLab']) &&
                                        !empty($pemeriksaanData['tanggalSelesaiLab']))
                                        <pre class="small-banget">
                                                                            <strong class="text-danger">Kunjungan :</strong> {{ $pemeriksaanData['tanggalKunjunganLab'] }}<br>
                                                                            <strong class="vertical-line ">---></strong>
                                                                            <strong class="text-success">Selesai :</strong> {{ $pemeriksaanData['tanggalSelesaiLab'] }}
                                                                        </pre>
                                        @else
                                        <p class="small-banget">Anda belum melakukan kunjungan LAB!
                                        </p>
                                        @endif
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card border-0">
                                    <div class="card-header border-0 font-weight-bold small"
                                        style=" background-color: #a9c9e6; color: white;">
                                        Hasil :
                                    </div>
                                    <div class="card-body">
                                        @if (!empty($pemeriksaanData))
                                        <table class="table table-bordered mt-2 small text-center float-center">
                                            <thead class="small">
                                                <tr class="small-banget">
                                                    <th>EDTA</th>
                                                    <th>Serum</th>
                                                    <th>Citrate</th>
                                                    <th>Urine</th>
                                                    <th>Lainya</th>
                                                    <th>Kondisi Sampel</th>
                                                </tr>
                                            </thead>
                                            <tbody class="small">
                                                <tr class="small">
                                                    <td class="text-center">
                                                        <div
                                                            class="bg-{{ isset($pemeriksaanData['edtaValue']) && $pemeriksaanData['edtaValue'] == 'YA' ? 'success' : 'danger' }} text-white rounded-circle p-2 small">
                                                            {!! isset($pemeriksaanData['edtaValue']) &&
                                                            $pemeriksaanData['edtaValue'] == 'YA'
                                                            ? '<i class="fas fa-check"></i>'
                                                            : '<i class="fas fa-times"></i>' !!}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="bg-{{ isset($pemeriksaanData['serumValue']) && $pemeriksaanData['serumValue'] == 'YA' ? 'success' : 'danger' }} text-white rounded-circle p-2 small">
                                                            {!! isset($pemeriksaanData['serumValue']) &&
                                                            $pemeriksaanData['serumValue'] == 'YA'
                                                            ? '<i class="fas fa-check"></i>'
                                                            : '<i class="fas fa-times"></i>' !!}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="bg-{{ isset($pemeriksaanData['citrateValue']) && $pemeriksaanData['citrateValue'] == 'YA' ? 'success' : 'danger' }} text-white rounded-circle p-2 small">
                                                            {!! isset($pemeriksaanData['citrateValue']) &&
                                                            $pemeriksaanData['citrateValue'] == 'YA'
                                                            ? '<i class="fas fa-check"></i>'
                                                            : '<i class="fas fa-times"></i>' !!}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="bg-{{ isset($pemeriksaanData['urineValue']) && $pemeriksaanData['urineValue'] == 'YA' ? 'success' : 'danger' }} text-white rounded-circle p-2 small">
                                                            {!! isset($pemeriksaanData['urineValue']) &&
                                                            $pemeriksaanData['urineValue'] == 'YA'
                                                            ? '<i class="fas fa-check"></i>'
                                                            : '<i class="fas fa-times"></i>' !!}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="bg-{{ isset($pemeriksaanData['lainyaValue']) && $pemeriksaanData['lainyaValue'] == 'YA' ? 'success' : 'danger' }} text-white rounded-circle p-2 small">
                                                            {!! isset($pemeriksaanData['lainyaValue']) &&
                                                            $pemeriksaanData['lainyaValue'] == 'YA'
                                                            ? '<i class="fas fa-check"></i>'
                                                            : '<i class="fas fa-times"></i>' !!}
                                                        </div>
                                                    </td>
                                                    <td class="text-center small-banget">
                                                        {{ isset($pemeriksaanData['kondisi_sampel']) ?
                                                        $pemeriksaanData['kondisi_sampel'] : '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else
                                        <p class="small-banget">Tidak ada hasil!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-header border-0 font-weight-bold small"
                                style="background-color: #a9c9e6; color: white;">
                                Amnesis Dokter :
                            </div>
                            <div class="card-body">
                                @if (isset($pemeriksaan) && is_object($pemeriksaan))
                                <pre class="small">
{{ isset($pemeriksaan->amnesis_dokter) ? $pemeriksaan->amnesis_dokter : '' }}
                                                        </pre>
                                @else
                                <p class="small-banget">Anda belum melakukan pemeriksaan!</p>
                                @endif
        
                            </div>
                        </div>
                        <div class="card border-0 mt-2 small" style="height: 82%">
                            <div class="card-header border-0 font-weight-bold small"
                                style="background-color: #a9c9e6; color: white;">
                                Tindakan Pelayanan Laboratorium :
                            </div>
                            <div class="card-body">
                                @if (isset($pemeriksaan) && is_object($pemeriksaan))
                                <pre class="small-banget">
Tanggal          : <strong>{{ isset($pemeriksaan->tanggal_pemeriksaan) ? $pemeriksaan->tanggal_pemeriksaan : '-' }}</strong>
Unit             : <strong>{{ isset($pemeriksaan->unit_pemeriksaan) ? $pemeriksaan->unit_pemeriksaan : '-' }}</strong>
Verifikator      : <strong>{{ isset($pemeriksaan->verifikator) ? $pemeriksaan->verifikator : '-' }}</strong>
Rujukan Dari     : <strong>{{ isset($pemeriksaan->rujukan_pemeriksaan) ? $pemeriksaan->rujukan_pemeriksaan : '-' }}</strong>
Jenis Pembayaran : <strong>{{ isset($pemeriksaan->jenis_pembayaran) ? $pemeriksaan->jenis_pembayaran : '-' }}</strong><br/>Rincian Tindakan :
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="10" class="bg-light p-2">Pemeriksaan Hematologi Lengkap</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="small">
                                                                        <tr class="p-5">
                                                                            <td class="p-2 small">WBC :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->WBC) ? $pemeriksaan->WBC : '-' }}</strong></td>
                                                                            <td class="p-2 small">RBC :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->RBC) ? $pemeriksaan->RBC : '-' }}</strong></td>
                                                                            <td class="p-2 small">PLT :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->PLT) ? $pemeriksaan->PLT : '-' }}</strong></td>
                                                                            <td class="p-2 small">HGB :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->HGB) ? $pemeriksaan->HGB : '-' }}</strong></td>
                                                                            <td class="p-2 small">HTM :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->HTM) ? $pemeriksaan->HTM : '-' }}</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="p-2 small">Neu :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->Neu) ? $pemeriksaan->Neu : '-' }}</strong></td>
                                                                            <td class="p-2 small">Eos :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->Eos) ? $pemeriksaan->Eos : '-' }}</strong></td>
                                                                            <td class="p-2 small">Bas :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->Bas) ? $pemeriksaan->Bas : '-' }}</strong></td>
                                                                            <td class="p-2 small">Lym :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->Lym) ? $pemeriksaan->Lym : '-' }}</strong></td>
                                                                            <td class="p-2 small">Mon :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->Mon) ? $pemeriksaan->Mon : '-' }}</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="p-2 small">MCV :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->MCV) ? $pemeriksaan->MCV : '-' }}</strong></td>
                                                                            <td class="p-2 small">MCH :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->MCH) ? $pemeriksaan->MCH : '-' }}</strong></td>
                                                                            <td class="p-2 small">MCHC :</td>
                                                                            <td class="p-2 small"><strong>{{ isset($pemeriksaan->MCHC) ? $pemeriksaan->MCHC : '-' }}</strong></td>
                                                                            <td colspan="5" class="p-2 small"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
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
        
                                                            </pre>
                                @else
                                <p class="small-banget">Anda belum melakukan pemeriksaan!</p>
                                @endif
        
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mt-5 ml-3">
                        <div class="col-md-auto ml-auto">
                            <a id="btn-print-detail" class="btn btn-secondary">
                                <i class="fa-solid fa-print"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Form for editing profile information -->
            <form method="POST" action="{{ route('user.updateProfile') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="editBirthdate" class="form-label">Tempat Tanggal Lahir</label>
                    <input type="text" class="form-control" id="editBirthdate" name="tempat_lahir"
                        value="{{ $user->tempat_lahir }}">
                </div>

                <div class="mb-3">
                    <label for="editAddress" class="form-label">Alamat Domisili</label>
                    <textarea type="text" class="form-control" id="editAddress" name="address" rows="3">{{ $user->address }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="editJenisKelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="editJenisKelamin" name="jenis_kelamin_user">
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editProfilePicture" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="editProfilePicture" name="profilePicture">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script src="https://kit.fontawesome.com/09b5482c09.js" crossorigin="anonymous"></script>
<!-- JavaScript to handle sidebar toggling -->
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-250px';
            mainContent.style.marginLeft = '0';
        } else {
            sidebar.style.left = '0';
            mainContent.style.marginLeft = '250px';
        }
    }
</script>

{{-- print barcode --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('btn-print-barcode').addEventListener('click', function() {
            var kodeRM = document.getElementById('barcode').getAttribute('data-rm');
            generateBarcode(kodeRM);
        });

        function generateBarcode(text) {
            var printWidth = 100;
            var printHeight = 100;
            var paperWidth = 200;
            var paperHeight = 100;

            var barcodeImage = document.createElement('img');
            barcodeImage.src = 'https://barcode.tec-it.com/barcode.ashx?data=' + text + '&code=Code128&dpi=96';
            barcodeImage.style.width = printWidth + 'px';
            barcodeImage.style.height = 'auto';
            barcodeImage.style.display = 'block';
            barcodeImage.style.margin = 'auto';

            var barcodeDiv = document.getElementById('barcode');
            barcodeDiv.innerHTML = '';
            barcodeDiv.appendChild(barcodeImage);

            var style = document.createElement('style');
            style.textContent = `
    @media print {
        body * {
            visibility: hidden;
        }
        #barcode, #barcode * {
            visibility: visible;
        }
        #barcode {
            position: absolute;
            left: 20%;
            width: ${printWidth}px;
            height: ${printHeight}px;
        }
        @page {
            size: ${paperWidth} ${paperHeight};
            margin: 0;
        }
    }
`;
        }
    });
</script>

{{-- print detail --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('btn-print-detail').addEventListener('click', function() {
        // Hide navbar and print buttons
        var navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.style.visibility = 'hidden';
        }
        var printButtonDetail = document.getElementById('btn-print-detail');
        if (printButtonDetail) {
            printButtonDetail.style.display = 'none';
        }
        var sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.style.display = 'none'; // Hide sidebar when printing
        }
        var printButtonBarcode = document.getElementById('btn-print-barcode');
        if (printButtonBarcode) {
            printButtonBarcode.style.display = 'none';
        }
        var printButtonHome = document.getElementById('btn-home');
        if (printButtonHome) {
            printButtonHome.style.display = 'none';
        }

        // Create print style with center alignment
        var printStyle = document.createElement('style');
        printStyle.textContent = `
            @media print {
                @page {
                    size: A4;
                    margin: 0;
                }

                body {
                    margin: 0;
                    padding: 0;
                    font-size: 100%;
                    display: flex;
                    justify-content: center; /* Center alignment */
                    align-items: center; /* Center alignment */
                    min-height: 100vh;
                }

                .container {
                    max-width: 100% !important;
                    width: 100% !important;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }

                .row,
                .col-md-6,
                .card,
                .card-header,
                .card-body,
                pre {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }

                .card {
                    margin: 10px 0; /* Jarak atas dan bawah antar card */
                }

                .no-print {
                    display: none !important;
                }

                /* Hide navbar and print buttons */
                .navbar,
                #btn-print-detail,
                #btn-print-barcode,
                #btn-home {
                    display: none !important;
                }
            }
        `;
        document.head.appendChild(printStyle);

        // Call window.print() to open print dialog
        window.print();

        // Restore visibility and display of navbar and print buttons after printing
        setTimeout(function() {
            if (navbar) {
                navbar.style.visibility = 'visible';
            }
            if (printButtonDetail) {
                printButtonDetail.style.display = 'block';
            }
            if (sidebar) {
                sidebar.style.display = 'block'; // Show sidebar after printing
            }
            if (printButtonBarcode) {
                printButtonBarcode.style.display = 'block';
            }
            if (printButtonHome) {
                printButtonHome.style.display = 'block';
            }
            document.head.removeChild(printStyle);
        }, 1000);
    });
});

</script>

</html>




