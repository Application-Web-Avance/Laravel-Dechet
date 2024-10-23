<style>
    .modal-body {
        background-color: #f8f9fa;
        /* Light background for the modal body */
        border-radius: 0.5rem;
        /* Rounded corners */
    }

    .modal-title {
        font-weight: bold;
        /* Bold title */
    }

    .text-secondary {
        color: #6c757d;
        /* Bootstrap secondary color */
    }

    .text-muted {
        color: #6c757d;
        /* Use for description to differentiate */
    }

    .badge-position {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        font-size: 0.75rem;
        border-radius: 0.25rem;
    }

    .badge-success {
        background-color: #28a745;
        /* Vert pour "Ouvert" */
    }

    .badge-danger {
        background-color: #dc3545;
        /* Rouge pour "Complet" */
    }

    .frame {
        width: 90%;
        margin: 40px auto;
        text-align: center;
    }

    button {
        margin: 20px;
    }

    .custom-btn {
        width: 130px;
        height: 40px;
        color: #fff;
        border-radius: 5px;
        padding: 10px 25px;
        font-family: 'Lato', sans-serif;
        font-weight: 500;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, .5),
            7px 7px 20px 0px rgba(0, 0, 0, .1),
            4px 4px 5px 0px rgba(0, 0, 0, .1);
        outline: none;
    }


    /* 8 */
    .btn-8 {
        background-color: #f0ecfc;
        background-image: linear-gradient(315deg, #f0ecfc 0%, #1938c4 74%);
        line-height: 42px;
        padding: 0;
        border: none;
    }

    .btn-8 span {
        position: relative;
        display: block;
        width: 100%;
        height: 100%;
    }

    .btn-8:before,
    .btn-8:after {
        position: absolute;
        content: "";
        right: 0;
        bottom: 0;
        background: #144968;
        /*box-shadow:  4px 4px 6px 0 rgba(255,255,255,.5),
              -4px -4px 6px 0 rgba(116, 125, 136, .2),
    inset -4px -4px 6px 0 rgba(255,255,255,.5),
    inset 4px 4px 6px 0 rgba(116, 125, 136, .3);*/
        transition: all 0.3s ease;
    }

    .btn-8:before {
        height: 0%;
        width: 2px;
    }

    .btn-8:after {
        width: 0%;
        height: 2px;
    }

    .btn-8:hover:before {
        height: 100%;
    }

    .btn-8:hover:after {
        width: 100%;
    }

    .btn-8:hover {
        background: transparent;
    }

    .btn-8 span:hover {
        color: #4368ce;
    }

    .btn-8 span:before,
    .btn-8 span:after {
        position: absolute;
        content: "";
        left: 0;
        top: 0;
        background: #2a70ca;
        /*box-shadow:  4px 4px 6px 0 rgba(255,255,255,.5),
              -4px -4px 6px 0 rgba(116, 125, 136, .2),
    inset -4px -4px 6px 0 rgba(255,255,255,.5),
    inset 4px 4px 6px 0 rgba(116, 125, 136, .3);*/
        transition: all 0.3s ease;
    }

    .btn-8 span:before {
        width: 2px;
        height: 0%;
    }

    .btn-8 span:after {
        height: 2px;
        width: 0%;
    }

    .btn-8 span:hover:before {
        height: 100%;
    }

    .btn-8 span:hover:after {
        width: 100%;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        /* Space between buttons */
        align-items: center;
        /* Center vertically */
        margin-top: 10px;
        /* Adjust spacing as needed */
    }

    /* Pagination styling */
    .pagination {
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
    }

    .pagination .page-item {
        margin: 0 0.25rem;
    }

    .pagination .page-link {
        border: 1px solid #007bff;
        border-radius: 50%;
        color: #007bff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
    }

    .pagination .page-link:hover:not(.disabled) {
        background-color: #e0f7ff;
        color: #007bff;
    }
</style>
@extends('FrontOffice.LayoutFront.layout')
@section('content')

    <div class="container-fluid blog py-2">

        <div class="container py-5">
            @if ($events->isNotEmpty())
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h1 class="display-4 mb-4">Tous les Événements</h1>
                    <p class="mb-0 ">
                        Participez à un événement pour rencontrer de nouveaux amis et vivre de nouvelles expériences, tout
                        en
                        découvrant des opportunités intéressantes.
                    </p>
                    <div class="mt-4 d-flex justify-content-center align-items-center">
                        <input type="text" id="search" placeholder="Rechercher des événements..."
                            class="form-control me-2" style="max-width: 400px;">
                        <a href="{{ route('evenement.proches') }}" class="btn btn-primary">Événements Proches</a>
                    </div>
                </div>


                <div class="row g-4 justify-content-center">
                    @foreach ($events as $event)
                        <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="blog-item">
                                <div class="blog-img position-relative">
                                    @php
                                        $imagePath = $event->image
                                            ? asset('storage/' . $event->image)
                                            : asset('storage/images/collectes/Collectdechet.jpeg');
                                    @endphp

                                    <img src="{{ $imagePath }}" class="img-fluid rounded-top w-100"
                                        alt="{{ $event->nomEvent }}" style="height: 300px; object-fit: cover;">

                                    <!-- Badge pour l'état de l'événement -->
                                    @if ($event->nbparticipant < $event->Maxnbparticipant && now() < $event->date)
                                        <span class="badge badge-success badge-position">Ouvert</span>
                                    @elseif ($event->nbparticipant == $event->Maxnbparticipant || now() >= $event->date)
                                        <span class="badge badge-danger badge-position">Complet</span>
                                    @endif
                                    <!-- Button for Image Preview -->
                                    <button type="button" class="btn  position-absolute top-50 start-50 translate-middle"
                                        data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $imagePath }}"
                                        style="z-index: 10;">
                                        <span class="fa fa-eye"></span> <!-- Eye icon -->
                                    </button>
                                </div>
                                <div class="blog-content p-4">
                                    <h5 href="#" class=" d-inline-block mb-3">{{ $event->nomEvent }}</h5>

                                    <div class="blog-comment d-flex flex-column mb-3">
                                        {{-- <div class="small">
                                        <span class="fa fa-user text-primary"></span>
                                        {{ $event->user->nomPrincipale }}
                                    </div> --}}
                                        <div class="small">
                                            <span class="fa fa-calendar text-primary"></span>
                                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y \à h:i A') }}
                                        </div>
                                        <div class="small">
                                            <span class="fa fa-map-marker-alt text-primary"></span>
                                            {{ $event->lieu }}
                                        </div>
                                        <div class="small">
                                            <span class="fa fa-recycle text-primary"></span>
                                            Type de déchet : {{ $event->typeDeDechet->type }}
                                        </div>
                                        <div class="small">
                                            <span class="fa fa-users text-primary"></span>
                                            {{ $event->nbparticipant }} / {{ $event->Maxnbparticipant }}
                                        </div>

                                    </div>
                                    <p class="mb-3">{{ Str::limit($event->description, 80, '...') }}</p>

                                    <div class="button-container d-flex justify-content-between">
                                        <a href="#" class="btn p-0" data-bs-toggle="modal"
                                            data-bs-target="#eventDetailsModal" data-name="{{ $event->nomEvent }}"
                                            data-description="{{ $event->description }}"
                                            data-date="{{ \Carbon\Carbon::parse($event->date)->format('d M Y \à h:i A') }}"
                                            data-location="{{ $event->lieu }}"
                                            data-waste-type="{{ $event->typeDeDechet->type }}"
                                            data-participants="{{ $event->nbparticipant }} / {{ $event->Maxnbparticipant }}"
                                            data-nom-principale="{{ $event->user->nomPrincipale }}"
                                            data-image="{{ $imagePath }}" date-test="{{ $event->date }}">
                                            Détails <i class="fa fa-arrow-right"></i>
                                        </a>

                                        @if (
                                            $variablePourDisabledButton[$event->id] ||
                                                $event->nbparticipant === $event->Maxnbparticipant ||
                                                now()->greaterThan(\Carbon\Carbon::parse($event->date)))
                                            <button type="button" class="btn btn-secondary"
                                                style="margin-left: 10px; cursor: not-allowed;" disabled>
                                                <span class="fa fa-lock"></span> <!-- Lock icon to indicate disabled -->
                                            </button>
                                        @else
                                            <form
                                                action="{{ route('evenementFront.participer', ['eventId' => $event->id]) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="custom-btn btn-8" style="margin-left: 10px;">
                                                    <span>Participer</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $events->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $events->previousPageUrl() }}" tabindex="-1">
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $events->lastPage(); $i++)
                                <li class="page-item {{ $i == $events->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $events->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $events->nextPageUrl() }}">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @else
                <p class="text-center">aucun événement existe !</p>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const events = document.querySelectorAll('.blog-item');

            events.forEach(event => {
                const title = event.querySelector('.blog-content h5').textContent.toLowerCase();
                if (title.includes(query)) {
                    event.style.display = 'block'; // Show matched event
                } else {
                    event.style.display = 'none'; // Hide unmatched event
                }
            });
        });
    </script>

    <!-- Modal for Event Details -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #015FC9; color: white;">
                    <h5 class="modal-title text-white d-flex align-items-center" id="eventDetailsModalLabel">
                        Détails de l'Événement
                        <!-- Badge indicating the event status -->
                        <span id="eventStatusBadge" class="badge ms-3"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <img src="" id="eventImage" class="img-fluid rounded-circle mb-3" alt="Image de l'événement"
                        style="width: 150px; height: 150px;"
                        onerror="this.onerror=null; this.src='{{ asset('storage/images/collectes/Collectdechet.jpeg') }}'">
                    <!-- Default image -->

                    <!-- Horizontal line under the image -->
                    <hr style="border-top: 2px solid #007bff; width: 80%; margin: 0 auto 1rem;">

                    @if (!empty($event->user->role))
                        <!-- Event Details -->
                        <p class="lead"><strong>
                                Nom de la {{ $event->user->role == 'Responsable_Centre' ? 'centre' : 'entreprise' }} :
                            </strong> <span id="nomPrincipale" class="text-primary">{{ $nomPrincipale ?? '' }}</span>
                        </p>
                    @endif
                    <p><strong>Nom de l'événement :</strong>
                        <span id="eventName" class="text-dark"></span>
                    </p>
                    <p><strong>Description :</strong>
                        <span id="eventDescription" class="text-dark"></span>
                    </p>
                    <p><strong>Date :</strong> <span id="eventDate" class="text-dark"></span></p>
                    <p><strong>Lieu :</strong> <span id="eventLocation" class="text-dark"></span></p>
                    <p><strong>Type de déchet :</strong> <span id="eventWasteType" class="text-dark"></span></p>
                    <p><strong>Participants :</strong> <span id="eventParticipants" class="text-dark"></span></p>
                </div>
            </div>
        </div>
    </div>


    <script>
        const eventDetailsModal = document.getElementById('eventDetailsModal');
        eventDetailsModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Le bouton qui a déclenché le modal

            // Extract information from the data-* attributes of the button
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            const date = button.getAttribute('data-date');
            const location = button.getAttribute('data-location');
            const wasteType = button.getAttribute('data-waste-type');
            const participants = button.getAttribute('data-participants');
            const nomPrincipale = button.getAttribute('data-nom-principale');
            const image = button.getAttribute('data-image');
            const dateRaw = button.getAttribute('date-test'); // For parsing to Date object

            const nbParticipants = parseInt(button.getAttribute('data-participants').split('/')[0].trim());
            const maxParticipants = parseInt(button.getAttribute('data-participants').split('/')[1].trim());


            const now = new Date(); // Get the current date and time
            console.log(now);
            // Example using moment.js
            const eventDate = new Date(dateRaw); // Now you can use this date for any logic

            console.log(eventDate);

            // Update the modal content
            eventDetailsModal.querySelector('#eventName').textContent = name;
            eventDetailsModal.querySelector('#eventDescription').textContent = description;
            eventDetailsModal.querySelector('#eventDate').textContent = date;
            eventDetailsModal.querySelector('#eventLocation').textContent = location;
            eventDetailsModal.querySelector('#eventWasteType').textContent = wasteType;
            eventDetailsModal.querySelector('#eventParticipants').textContent = participants;
            eventDetailsModal.querySelector('#nomPrincipale').textContent = nomPrincipale;
            eventDetailsModal.querySelector('#eventImage').src = image;

            // Update the event status badge dynamically based on the number of participants
            const badge = eventDetailsModal.querySelector('#eventStatusBadge');
            // Vérifiez que vous avez bien récupéré les bons nombres
            if (nbParticipants < maxParticipants && now < eventDate) {
                badge.textContent = 'Ouvert';
                badge.classList.remove('bg-danger');
                badge.classList.add('bg-success');
            } else if (nbParticipants === maxParticipants || now >= eventDate) {
                badge.textContent = 'Complet';
                badge.classList.remove('bg-success');
                badge.classList.add('bg-danger');
            }
        });
    </script>


    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid" alt="Aperçu de l'image"
                        onerror="this.onerror=null; this.src='{{ asset('storage/images/collectes/Collectdechet.jpeg') }}'">
                </div>
            </div>
        </div>
    </div>

    {{-- script de image apercu --}}
    <script>
        const imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Le bouton qui a déclenché le modal
            const imageSrc = button.getAttribute('data-image'); // Extraire l'info de l'attribut data-*

            console.log('Image Source:', imageSrc); // Affiche le chemin de l'image dans la console

            const modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageSrc; // Met à jour la source de l'image du modal

            // Vérifiez si l'image est correctement chargée
            modalImage.onload = () => {
                console.log('Image loaded successfully:', modalImage
                    .src); // Affiche le message de succès avec la source de l'image
            };

            modalImage.onerror = () => {
                console.error('Error loading image for src:', modalImage
                    .src); // Affiche le message d'erreur avec la source de l'image
                modalImage.src =
                    '{{ asset('storage/images/collectes/Collectdechet.jpeg') }}'; // Charger une image par défaut en cas d'erreur
            };
        });
    </script>
@endsection
