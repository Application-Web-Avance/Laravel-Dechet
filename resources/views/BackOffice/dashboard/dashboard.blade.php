@extends('BackOffice.LayoutBack.layout')

@section('content')
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inclure Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Inclure Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Tableau de Bord des Statistiques </strong></h1>

        @if (Auth::user()->role == 'admin')
            <div class="row">
                <div class="col-xl-12 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <!-- Card 1 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Responsables de Centre</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="users"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbUserRoleCentre }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des Responsables de Centre</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Responsables d'Entreprise</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="users"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbUserRoleEntreprise }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des Responsables d'Entreprise</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Utilisateurs Simples</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="user"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbUserSimple }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des Utilisateurs Simples</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Card 4 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Total des Utilisateurs</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="user-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbTotalUsers }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des utilisateurs non administrateurs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 5 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Événements par Responsables d'Entreprise</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbTotalEventsByEntreprise }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des événements créés par les Responsables
                                                d'Entreprise</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 6 -->
                            <div class="col-sm-6 col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Événements par Responsables de Centre</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $nbTotalEventsByCentre }}</h1>
                                        <div class="mb-0">
                                            <span class="text-muted">Total des événements créés par les Responsables de
                                                Centre</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Colonne pour le calendrier -->
                <div class="col-md-6 col-xxl-3 ">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Calendar</h5>
                        </div>
                        <div class="card-body d-flex">
                            <div class="align-self-center w-100">
                                <div class="chart">
                                    <input type="text" id="datetimepicker-dashboard" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne pour le graphique des types de déchets -->
                <div class="col-sm-6 col-md-4 "> <!-- Ajuster la largeur de la colonne ici -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Types de déchets les plus utilisés dans les événements :</h5>
                            <canvas id="typesDechetsChart" style="max-height: 700px; max-width: 100%;"></canvas>
                            <!-- 100% pour remplir la carte -->
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var ctx = document.getElementById('typesDechetsChart').getContext('2d');
                var typesDechetsChart = new Chart(ctx, {
                    type: 'bar', // Type de graphique (bar, line, pie, etc.)
                    data: {
                        labels: {!! json_encode($labels) !!}, // Noms des types de déchets
                        datasets: [{
                            label: 'Occurrences',
                            data: {!! json_encode($data) !!}, // Nombre d'occurrences
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de remplissage
                            borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la bordure
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true // Commencer l'axe Y à 0
                            }
                        }
                    }
                });
            </script>

            <script>
                // Initialisation de Flatpickr
                flatpickr("#datetimepicker-dashboard", {
                    defaultDate: new Date(), // Utiliser la date actuelle
                    dateFormat: "Y-m-d", // Format de la date
                });
            </script>
        @endif

        @if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise')
            <div class="row">
                <!-- Card 1 -->
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Participant</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $totalParticipants }}</h1>
                            <div class="mb-0">
                                <span class="text-muted">Total des Participant de @if (Auth::user()->role == 'Responsable_Centre') centre @else entreprise @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Colonne pour le graphique des types de déchets -->
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Types de déchets les plus utilisés dans les événements :</h5>
                            <canvas id="typesDechetsChart" style="max-height: 700px; max-width: 100%;"></canvas>
                            <!-- 100% pour remplir la carte -->
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var ctx = document.getElementById('typesDechetsChart').getContext('2d');
                var typesDechetsChart = new Chart(ctx, {
                    type: 'bar', // Type de graphique (bar, line, pie, etc.)
                    data: {
                        labels: {!! json_encode($labels) !!}, // Noms des types de déchets
                        datasets: [{
                            label: 'Occurrences',
                            data: {!! json_encode($data) !!}, // Nombre d'occurrences
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de remplissage
                            borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la bordure
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true // Commencer l'axe Y à 0
                            }
                        }
                    }
                });
            </script>
        @endif
        

    </div>
@endsection
