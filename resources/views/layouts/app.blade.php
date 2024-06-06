<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .fade-in {
            animation: fadeInAnimation ease 0.5s;
            animation-iteration-count: 1;
            opacity: 0;
            transform: translateX(-100%);
        }

        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .custom-btn {
            background-color: #84cdde;
            border-color: #84cdde;
        }

        .custom-btn:hover {
            background-color: #5aa3af;
            border-color: #5aa3af;
        }


        .fade-in-left {
            animation: fadeInLeftAnimation ease 0.5s;
            animation-iteration-count: 1;
            opacity: 0;
            transform: translateX(-100%);
        }

        @keyframes fadeInLeftAnimation {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in-right {
            animation: fadeInRightAnimation ease 0.5s;
            animation-iteration-count: 1;
            opacity: 0;
            transform: translateX(100%);
        }

        @keyframes fadeInRightAnimation {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }


        .navbar-content {
            animation: slideInFromTop ease 0.5s forwards;
            opacity: 0;
            transform: translateY(-100%);
            z-index: 1000;
        }

        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-100%);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }


        }

        .vertical-line {
            height: 30px;
            margin-left: 10px;
            display: inline-block;
            writing-mode: vertical-rl;
        }


        /* table ketimbun */
        .alamat {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }



        /* logout konten */
        .dropdown-item:hover,
        .dropdown-item:focus,
        .dropdown-item:active {
            color: inherit;
            background-color: transparent !important;
            text-decoration: none;
        }

        .form-control:focus {
            border-color: #69b3f3 !important;
            box-shadow: 0 0 0 0.25rem rgba(58, 129, 211, 0.25) !important;
        }

        .small-text {
            font-size: 12px;
        }

        .small-banget {
            font-size: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .b-small {
            font-size: 8px;
            word-wrap: break-word;
        }

        .bg-custom {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>

<body style="background-color: #cfe2f3">
    {{-- Navbar Start --}}
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 navbar-content" style="background-color: #c9f7c9">
        <a class="navbar-brand"
            href="{{ Auth::check() ? (Auth::guard('admin')->check() ? route('admin.home') : route('user.dashboard')) : '/' }}">
            <span style="font-weight: bold; color: #7fbf7f;"> <i class="fa-solid fa-notes-medical"></i> RSU Cinta
                Kasih</span>
        </a>
        @if (Auth::check())
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a style="font-weight: bold; color: #7fbf7f;" class="nav-link dropdown-toggle" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-danger mt-2" aria-labelledby="navbarDropdown"
                            style="max-width:200px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                            @if (Auth::guard('admin')->check())
                                <!-- Tambahkan form untuk logout admin -->
                                <form id="admin-logout-form" action="{{ route('admin.logoutAdmin') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-light">
                                        Logout <i class="fas fa-sign-out-alt ms-2"></i>
                                    </button>
                                </form>
                                <a class="dropdown-item text-light" href="{{ route('admin.home') }}">Home <i
                                        class="fas fa-home ms-2"></i></a> <!-- Admin diarahkan ke /home -->
                            @else
                                <!-- Tambahkan form untuk logout user -->
                                <form id="user-logout-form" action="{{ route('user.logoutUser') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-light">
                                        Logout <i class="fas fa-sign-out-alt ms-2"></i>
                                    </button>
                                </form>                                
                                </form>
                                <a class="dropdown-item text-light" href="{{ route('user.dashboard') }}">Dashboard <i
                                        class="fas fa-tachometer-alt ms-2"></i></a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </nav> --}}

    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 navbar-content"
        style="background-color: {{ Auth::check() ? (Auth::guard('admin')->check() ? '#c9f7c9' : '#c9f7c9') : 'gray' }}">
        <a class="navbar-brand"
            href="{{ Auth::check() ? (Auth::guard('admin')->check() ? route('admin.home') : route('user.dashboard')) : '/' }}">
            <span
                style="font-weight: bold; color: {{ Auth::check() ? (Auth::guard('admin')->check() ? '#7fbf7f' : '#6ecbe0') : 'gray' }}">
                <i class="fa-solid fa-notes-medical"></i> RSU Cinta Kasih
            </span>
        </a>
        @if (Auth::check())
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a style="font-weight: bold; color: {{ Auth::guard('admin')->check() ? '#7fbf7f' : '#6ecbe0' }}"
                            class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-danger mt-2" aria-labelledby="navbarDropdown"
                            style="max-width:200px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                            @if (Auth::guard('admin')->check())
                                <!-- Tambahkan form untuk logout admin -->
                                <form id="admin-logout-form" action="{{ route('admin.logoutAdmin') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-light">
                                        Logout <i class="fas fa-sign-out-alt ms-2"></i>
                                    </button>
                                </form>
                                <a class="dropdown-item text-light" href="{{ route('admin.home') }}">Home <i
                                        class="fas fa-home ms-2"></i></a>
                            @else
                                <form id="user-logout-form" action="{{ route('user.logoutUser') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-light">
                                        Logout <i class="fas fa-sign-out-alt ms-2"></i>
                                    </button>
                                </form>
                                <a class="dropdown-item text-light" href="{{ route('user.dashboard') }}">Dashboard <i
                                        class="fas fa-tachometer-alt ms-2"></i></a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </nav> --}}

    {{-- Navbar end --}}





    <div class="container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script src="https://kit.fontawesome.com/09b5482c09.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    {{-- print barcode start --}}
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
    {{-- end print barcode --}}

    {{-- print detail start --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('btn-print-detail').addEventListener('click', function() {
                var navbar = document.querySelector('.navbar');
                if (navbar) {
                    navbar.style.visibility = 'hidden';
                }

                var printButtonDetail = document.getElementById('btn-print-detail');
                if (printButtonDetail) {
                    printButtonDetail.style.display = 'none';
                }
                var printButtonBarcode = document.getElementById('btn-print-barcode');
                if (printButtonBarcode) {
                    printButtonBarcode.style.display = 'none';
                }
                var printButtonBarcode = document.getElementById('btn-home');
                if (printButtonBarcode) {
                    printButtonBarcode.style.display = 'none';
                }

                var printStyle = document.createElement('style');
                printStyle.textContent = `
                @media print {
                    @page {
                        size: A4;
                        margin: 0.5cm;
                    }
                    .no-print {
                display: none !important;
            }

                    body {
                        margin: 0;
                        padding: 0;
                        font-size: 100%;
                    }

                    .container {
                        max-width: 100% !important;
                        width: 100% !important;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }

                    .row, .col-md-6, .card, .card-header, .card-body, pre {
                        width: 100% !important;
                        margin: 0 !important;
                        padding: 0 !important;
                    }

                    .card {
                        margin: 10px 0; /* Jarak atas dan bawah antar card */
                    }

                    .navbar,
                    #btn-print-detail,
                    #btn-print-barcode {
                        display: none !important;
                    }
                }
            `;
                document.head.appendChild(printStyle);

                window.print();

                setTimeout(function() {
                    if (navbar) {
                        navbar.style.visibility = 'visible';
                    }
                    if (printButtonDetail) {
                        printButtonDetail.style.display = 'block';
                    }
                    if (printButtonBarcode) {
                        printButtonBarcode.style.display = 'block';
                    }
                    document.head.removeChild(printStyle);
                }, 1000);
            });
        });
    </script>
    {{-- print detail end --}}

    {{-- Animasi Start --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elementsFadeIn = document.querySelectorAll('.fade-in');
            elementsFadeIn.forEach(element => {
                element.classList.add('animate_animated', 'animate_fadeIn');
                element.addEventListener('animationend', () => {
                    element.classList.remove('animate_animated', 'animate_fadeIn');
                });
                element.style.opacity = 1;
                element.style.transform = 'translateX(0)';
            });

            const elementsFadeInLeft = document.querySelectorAll('.fade-in-left');
            elementsFadeInLeft.forEach(element => {
                element.classList.add('animate_animated', 'animate_fadeInLeft');
                element.addEventListener('animationend', () => {
                    element.classList.remove('animate_animated', 'animate_fadeInLeft');
                });
                element.style.opacity = 1;
                element.style.transform = 'translateX(0)';
            });

            const elementsFadeInRight = document.querySelectorAll('.fade-in-right');
            elementsFadeInRight.forEach(element => {
                element.classList.add('animate_animated', 'animate_fadeInRight');
                element.addEventListener('animationend', () => {
                    element.classList.remove('animate_animated', 'animate_fadeInRight');
                });
                element.style.opacity = 1;
                element.style.transform = 'translateX(0)';
            });

            const navbarContent = document.querySelector('.navbar-content');
            navbarContent.classList.add('animate_animated', 'animate_slideInFromTop');
            navbarContent.addEventListener('animationend', () => {
                navbarContent.classList.remove('animate_animated', 'animate_slideInFromTop');
            });
            navbarContent.style.opacity = 1;
            navbarContent.style.transform = 'translateY(0)';
        });
    </script>
    {{-- Animasi End --}}

    {{-- Kalender start --}}
    <script>
        let calendar = document.querySelector('.calendar')

        const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ]

        isLeapYear = (year) => {
            return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 === 0)
        }

        getFebDays = (year) => {
            return isLeapYear(year) ? 29 : 28
        }

        generateCalendar = (month, year) => {
            let calendar_days = calendar.querySelector('.calendar-days')
            let calendar_header_year = calendar.querySelector('#year')

            let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

            calendar_days.innerHTML = ''

            let currDate = new Date()
            if (!month) month = currDate.getMonth()
            if (!year) year = currDate.getFullYear()

            let curr_month = month_names[month]
            month_picker.innerHTML = curr_month
            calendar_header_year.innerHTML = year

            let first_day = new Date(year, month, 1)

            for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
                let day = document.createElement('div')
                if (i >= first_day.getDay()) {
                    day.classList.add('calendar-day-hover')
                    day.innerHTML = i - first_day.getDay() + 1
                    day.innerHTML += `<span></span><span></span><span></span><span></span>`
                    if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() &&
                        month === currDate.getMonth()) {
                        day.classList.add('curr-date')
                    }
                }
                calendar_days.appendChild(day)
            }
        }

        let month_list = calendar.querySelector('.month-list')

        month_names.forEach((e, index) => {
            let month = document.createElement('div')
            month.innerHTML = `<div data-month="${index}">${e}</div>`
            month.querySelector('div').onclick = () => {
                month_list.classList.remove('show')
                curr_month.value = index
                generateCalendar(index, curr_year.value)
            }
            month_list.appendChild(month)
        })

        let month_picker = calendar.querySelector('#month-picker')

        month_picker.onclick = () => {
            month_list.classList.add('show')
        }

        let currDate = new Date()

        let curr_month = {
            value: currDate.getMonth()
        }
        let curr_year = {
            value: currDate.getFullYear()
        }

        generateCalendar(curr_month.value, curr_year.value)

        document.querySelector('#prev-year').onclick = () => {
            --curr_year.value
            generateCalendar(curr_month.value, curr_year.value)
        }

        document.querySelector('#next-year').onclick = () => {
            ++curr_year.value
            generateCalendar(curr_month.value, curr_year.value)
        }

        let dark_mode_toggle = document.querySelector('.dark-mode-switch')

        dark_mode_toggle.onclick = () => {
            document.querySelector('body').classList.toggle('light')
            document.querySelector('body').classList.toggle('dark')
        }
    </script>
    {{-- kalender End --}}

    {{-- pop up berhasil --}}
    <script>
        function showSuccessAlert() {
            const alert = document.getElementById('successAlert');
            alert.classList.remove('d-none');
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSuccessAlert();
        });
    </script>



</body>

</html>
