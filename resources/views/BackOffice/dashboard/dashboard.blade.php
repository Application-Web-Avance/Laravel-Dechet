@extends('BackOffice.LayoutBack.layout')

@section('content')
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inclure Flatpickr CSS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <head>
        <!-- Other head elements -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
            integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMD4E7x8c0zB8QlgONEx0tV9j/g9R8M9jcG93y" crossorigin="anonymous" />
    </head>


    <style>
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Pour un effet d'ombre subtil */
            border-radius: 10px;
            /* Ajouter un peu de courbure aux cartes */
        }

        .card-body {
            padding: 20px;
            /* Uniformiser le padding interne */
        }

        .card-title {
            font-weight: bold;
            text-align: center;
            /* Centrer les titres pour une meilleure présentation */
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            /* 7 columns for the days of the week */
            gap: 5px;
            text-align: center;
        }

        .day {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .today {
            background-color: #007bff;
            /* Highlight color for the current day */
            color: white;
        }

        .header {
            font-weight: bold;
            padding: 10px;
        }
    </style>

    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Tableau de Bord des Statistiques </strong></h1>


        @if (Auth::user()->role == 'Responsable_Centre' ||
                Auth::user()->role == 'Responsable_Entreprise' ||
                Auth::user()->role == 'admin')
            <div class="row mt-5">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Paiements Effectués</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="check-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $paiements_effectues }}</h1>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Paiements en Attente</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $paiements_en_attente }}</h1>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Annonces non Disponible</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="x-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $annonces_en_attente }}</h1>

                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Total des Paiements Effectués</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">
                                            {{ number_format($total_paiements, 2, ',', ' ') }} DT
                                        </h1>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Annonces</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="archive"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $total_annonces }}</h1>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Annonces disponible</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="loader"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $annonces_disponibles }}</h1>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <div class="card flex-fill w-100">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Paiements de mouvement récents</h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart chart-sm">
                                <canvas id="paiementsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var ctx = document.getElementById('paiementsChart').getContext('2d');
                var paiementsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                            label: 'Paiements au fil du temps',
                            data: @json($paiements_montants),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endif



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


            <div class="row g-4"> <!-- Utiliser g-4 pour un espacement uniforme entre les colonnes -->
                <!-- Colonne pour le calendrier -->
                <!-- Colonne pour le calendrier -->
                <div class="col-md-6 col-xxl-4">
                    <div class="card h-100"> <!-- h-100 pour s'assurer que la hauteur est égale -->
                        <div class="card-header">
                            <h5 class="card-title mb-0" id="calendar-title"></h5>
                        </div>
                        <div class="card-body">
                            <div class="calendar" id="calendar"></div>
                        </div>
                    </div>
                </div>

                <!-- Colonne pour le graphique des types de déchets -->
                <div class="col-md-6 col-xxl-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Types de déchets les plus utilisés dans les événements :</h5>
                            <canvas id="typesDechetsChart" style="max-height: 700px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card pour la météo -->
                <div class="col-md-6 col-xxl-4">
                    <div class="card h-100" id="weather-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Météo d'aujourd'hui</h5>
                            <button id="weather-btn" class="btn btn-primary mb-3">Voir la météo</button>
                            <div id="weather-info" style="display: none; margin-top: 10px;">
                                <p id="weather-location" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="map" class="align-middle me-2"></i>
                                    <span></span>
                                </p>
                                <p id="weather-temp" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="map" class="align-middle me-2"></i>
                                    <span></span>
                                </p>
                                <p id="weather-condition" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="sun" class="align-middle me-2"></i>
                                    <span></span>
                                </p>
                                <p id="weather-humidity" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="droplet" class="align-middle me-2"></i>
                                    Humidité: <span></span>
                                </p>
                                <p id="weather-wind" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="wind" class="align-middle me-2"></i>
                                    Vitesse du vent: <span></span>
                                </p>
                                <p id="latit" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="map" class="align-middle me-2"></i>
                                    Latitude: <span id="lat" class="ms-2"></span>
                                </p>
                                <p id="antit" class="d-flex justify-content-center align-items-center">
                                    <i data-feather="map" class="align-middle me-2"></i>
                                    Longitude: <span id="lon" class="ms-2"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <script>
                function generateCalendar() {
                    const today = new Date();
                    const currentYear = today.getFullYear();
                    const currentMonth = today.getMonth();
                    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
                    const lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

                    const calendarTitle = document.getElementById("calendar-title");
                    calendarTitle.innerText = today.toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });

                    const calendar = document.getElementById("calendar");
                    calendar.innerHTML = ""; // Clear existing calendar

                    // Days of the week
                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    daysOfWeek.forEach(day => {
                        const header = document.createElement("div");
                        header.classList.add("header");
                        header.innerText = day;
                        calendar.appendChild(header);
                    });

                    // Fill in the calendar days
                    for (let i = 0; i < firstDayOfMonth; i++) {
                        const emptyCell = document.createElement("div");
                        calendar.appendChild(emptyCell); // Empty cell for days before the first of the month
                    }

                    for (let date = 1; date <= lastDateOfMonth; date++) {
                        const dayCell = document.createElement("div");
                        dayCell.classList.add("day");
                        dayCell.innerText = date;

                        // Highlight today's date
                        if (date === today.getDate()) {
                            dayCell.classList.add("today");
                        }

                        calendar.appendChild(dayCell);
                    }
                }

                // Call the function to generate the calendar on page load
                document.addEventListener("DOMContentLoaded", generateCalendar);
            </script>


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
                document.getElementById('weather-btn').addEventListener('click', function() {
                    // Vérifier si le navigateur supporte la géolocalisation
                    if (navigator.geolocation) {
                        // Récupérer la position actuelle
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;

                            // Construire l'URL de l'API avec les coordonnées actuelles
                            const apiUrl =
                                `http://api.weatherapi.com/v1/current.json?key=afb66e4eb684479f8f2204109241710&q=${latitude},${longitude}`;

                            // Rendre la carte floue
                            const card = document.getElementById('weather-card');
                            card.style.filter = 'blur(5px)';

                            // Appeler l'API pour récupérer la météo
                            fetch(apiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    // Afficher les informations météo
                                    document.getElementById('weather-location').innerHTML =
                                        `<i data-feather="map-pin" class="align-middle me-2"></i>Lieu: ${data.location.name}, ${data.location.country}`;
                                    document.getElementById('weather-temp').innerHTML =
                                        `<i data-feather="thermometer" class="align-middle me-2"></i>Température : ${data.current.temp_c} °C`;
                                    document.getElementById('weather-condition').innerHTML =
                                        `<i data-feather="sun" class="align-middle me-2"></i>Condition : ${data.current.condition.text}`;
                                    document.getElementById('weather-humidity').innerHTML =
                                        `<i data-feather="droplet" class="align-middle me-2"></i>Humidité : ${data.current.humidity}%`;
                                    document.getElementById('weather-wind').innerHTML =
                                        `<i data-feather="wind" class="align-middle me-2"></i>Vitesse du vent : ${data.current.wind_kph} km/h`;
                                    // Ajouter Latitude et Longitude
                                    document.getElementById('lat').innerText = data.location
                                        .lat; // Assurez-vous que les données de latitude existent
                                    document.getElementById('lon').innerText = data.location
                                        .lon; // Assurez-vous que les données de longitude existent
                                    // N'oubliez pas de réinitialiser les icônes après la mise à jour
                                    feather.replace();

                                    // Afficher la section météo
                                    document.getElementById('weather-info').style.display = 'block';

                                    // Enlever le flou après 1 seconde
                                    setTimeout(() => {
                                        card.style.filter = 'none';
                                    }, 1000);
                                })
                                .catch(error => {
                                    console.error('Erreur lors de la récupération de la météo:', error);
                                });
                        }, function(error) {
                            console.error('Erreur de géolocalisation:', error);
                        });
                    } else {
                        alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                    }
                });
            </script>
        @endif




        @if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise')
            <div class="row">
                <!-- Card 1: Participant -->
                <div class="col-sm-6 col-md-6 mb-4">
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
                                <span class="text-muted">Total des Participants de
                                    @if (Auth::user()->role == 'Responsable_Centre')
                                        centre
                                    @else
                                        entreprise
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Graphique des types de déchets -->
                <div class="col-sm-6 col-md-6">
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
