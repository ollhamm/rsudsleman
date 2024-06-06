@extends('layouts.app')

@section('title', 'Daftar Pasien')

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

        <div class="d-flex justify-content-end mt-3">
            <form action="{{ route('callcenter.logoutCallcenter') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <div class="mt-4">
            <div class="header-container rounded text-center mb-4" style="background-color: #3490dc; padding: 20px;">
                <h1 class="display-5 font-weight-bold text-white">Daftar Pasien</h1>
            </div>
            <div class="table-responsive">
                <table class="fade-in table table-bordered table-hover rounded shadow table-rounded">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">RM</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($call as $c)
                            <tr class="{{ $loop->first ? 'bg-warning font-weight-bold' : 'collapse' }} patient-row"
                                id="row-{{ $no }}">
                                <td>{{ $no }}</td>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->rm }}</td>
                                <td>
                                    <form action="{{ route('callcenter.antrian.destroy', $c->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fa-solid fa-trash"></i> Panggil dan Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php $no++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
            </div>
        </div>
    </div>

    <style>
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }


        .patient-row {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .collapse:not(.show) {
            display: table-row !important;
            opacity: 0;
            transform: scaleY(0);
        }

        .collapse.show {
            opacity: 1;
            transform: scaleY(1);
        }

        .highlight {
            animation: highlight 0.5s ease-in-out forwards;
        }

        @keyframes highlight {
            from {
                background-color: yellow;
            }

            to {
                background-color: inherit;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.patient-row');
            let currentIndex = 0;
            let intervalId = null;

            function startHighlightInterval() {
                intervalId = setInterval(() => {
                    if (currentIndex >= rows.length) {
                        clearInterval(intervalId);
                        return;
                    }

                    rows.forEach(row => row.classList.remove('highlight'));
                    const currentRow = rows[currentIndex];
                    currentRow.classList.add('highlight');
                    alert(
                        `Calling patient with RM: ${currentRow.querySelector('td:nth-child(3)').textContent}`);

                    currentIndex++;
                }, 90000);
            }

            startHighlightInterval();

            const showMoreBtn = document.querySelector('.btn-show-more');
            showMoreBtn.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                if (expanded) {
                    this.querySelector('span').textContent = 'Show More';
                    this.querySelector('i').classList.add('fa-chevron-down');
                    this.querySelector('i').classList.remove('fa-chevron-up');
                    clearInterval(intervalId);

                    // Hide rows
                    rows.forEach(row => {
                        if (!row.classList.contains('show')) {
                            row.classList.add('collapsed');
                        }
                    });
                } else {
                    this.querySelector('span').textContent = 'Show Less';
                    this.querySelector('i').classList.add('fa-chevron-up');
                    this.querySelector('i').classList.remove('fa-chevron-down');
                    startHighlightInterval();

                    // Show rows
                    rows.forEach(row => row.classList.remove('collapsed'));
                }
                this.setAttribute('aria-expanded', !expanded);
            });
        });
    </script>
@endsection
